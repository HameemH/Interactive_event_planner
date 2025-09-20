<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a payment intent for the event
     */
    public function createPaymentIntent(Request $request, $eventId)
    {
        try {
            Log::info("Payment intent request for event: $eventId");
            Log::info("Request data: " . json_encode($request->all()));
            Log::info("Auth user: " . (auth()->check() ? auth()->id() : 'not authenticated'));
            
            $event = Event::findOrFail($eventId);
            
            // Ensure user owns this event
            if ($event->user_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Ensure event is approved
            if (!$event->isApproved()) {
                return response()->json(['error' => 'Event must be approved before payment'], 400);
            }

            // Check if payment already exists and is successful
            $existingPayment = Payment::where('event_id', $eventId)
                                    ->where('status', 'succeeded')
                                    ->first();
            
            if ($existingPayment) {
                return response()->json(['error' => 'Payment has already been completed for this event'], 400);
            }

            // Convert amount to cents (Stripe requires amounts in smallest currency unit)
            $amountInCents = $request->amount * 100;

            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'bdt', // Bangladesh Taka
                'metadata' => [
                    'event_id' => $event->id,
                    'user_id' => auth()->id(),
                    'event_name' => $event->event_name,
                ],
                'description' => "Payment for event: {$event->event_name}",
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Intent Creation Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create payment intent'], 500);
        }
    }

    /**
     * Handle successful payment confirmation
     */
    public function confirmPayment(Request $request, Event $event)
    {
        try {
            Log::info('Payment confirmation started', [
                'event_id' => $event->id,
                'query_params' => $request->query(),
                'url' => $request->fullUrl()
            ]);
            
            $paymentIntentId = $request->query('payment_intent');
            $paymentIntentClientSecret = $request->query('payment_intent_client_secret');
            
            if (!$paymentIntentId) {
                Log::warning('Payment confirmation failed - missing payment intent', [
                    'event_id' => $event->id,
                    'query_params' => $request->query()
                ]);
                return redirect()->route('profile.event.details', $event)
                    ->with('error', 'Payment confirmation failed - missing payment intent');
            }

            // Ensure Stripe API key is set
            if (!config('services.stripe.secret')) {
                throw new \Exception('Stripe secret key not configured');
            }
            
            // Retrieve payment intent from Stripe
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            Log::info('Payment intent retrieved', [
                'payment_intent_id' => $paymentIntentId,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Update event payment status
                $event->update(['payment_status' => 'paid']);

                // Log successful payment
                Log::info('Payment successful', [
                    'event_id' => $event->id,
                    'payment_intent' => $paymentIntentId,
                    'amount' => $paymentIntent->amount / 100
                ]);

                return redirect()->route('profile.event.details', $event)
                    ->with('success', 'Payment successful! Your event is now fully paid.');
            } else {
                return redirect()->route('profile.event.details', $event)
                    ->with('error', 'Payment was not successful. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error('Payment Confirmation Failed: ' . $e->getMessage());
            return redirect()->route('profile.event.details', $event)
                ->with('error', 'Payment confirmation failed. Please contact support.');
        }
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook.secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload: ' . $e->getMessage());
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event['type']) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event['data']['object'];
                $this->handlePaymentSuccess($paymentIntent);
                break;
            
            case 'payment_intent.payment_failed':
                $paymentIntent = $event['data']['object'];
                $this->handlePaymentFailure($paymentIntent);
                break;

            default:
                Log::info('Received unknown event type: ' . $event['type']);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Handle successful payment from webhook
     */
    private function handlePaymentSuccess($paymentIntent)
    {
        $eventId = $paymentIntent['metadata']['event_id'] ?? null;
        
        if ($eventId) {
            $event = Event::find($eventId);
            if ($event) {
                $event->update(['payment_status' => 'paid']);
                Log::info('Event payment status updated via webhook', ['event_id' => $eventId]);
            }
        }
    }

    /**
     * Handle failed payment from webhook
     */
    private function handlePaymentFailure($paymentIntent)
    {
        $eventId = $paymentIntent['metadata']['event_id'] ?? null;
        
        if ($eventId) {
            Log::warning('Payment failed for event', [
                'event_id' => $eventId,
                'payment_intent' => $paymentIntent['id']
            ]);
        }
    }
}
