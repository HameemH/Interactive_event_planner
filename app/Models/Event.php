<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'event_name',
        'event_date',
        'total_cost',
        'status',
        'payment_status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'total_cost' => 'decimal:2'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';

    /**
     * Get the user who created this event
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the venue configuration for this event
     */
    public function venue()
    {
        return $this->hasOne(EventVenue::class);
    }

    /**
     * Get the seating configuration for this event
     */
    public function seating()
    {
        return $this->hasOne(EventSeating::class);
    }

    /**
     * Get the stage configuration for this event
     */
    public function stage()
    {
        return $this->hasOne(EventStage::class);
    }

    /**
     * Get the catering configuration for this event
     */
    public function catering()
    {
        return $this->hasOne(EventCatering::class);
    }

    /**
     * Get the photography configuration for this event
     */
    public function photography()
    {
        return $this->hasOne(EventPhotography::class);
    }

    /**
     * Get the extra options for this event
     */
    public function extraOptions()
    {
        return $this->hasOne(EventExtraOptions::class);
    }

    /**
     * Check if event is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if event is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if event is rejected
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Approve the event
     */
    public function approve()
    {
        $this->status = self::STATUS_APPROVED;
        return $this->save();
    }

    /**
     * Reject the event
     */
    public function reject()
    {
        $this->status = self::STATUS_REJECTED;
        return $this->save();
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_APPROVED => 'bg-green-100 text-green-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            self::STATUS_COMPLETED => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get formatted status
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get the payments for this event
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if event is paid
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if event is unpaid
     */
    public function isUnpaid()
    {
        return $this->payment_status === 'unpaid';
    }
}
