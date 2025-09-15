<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // First, attempt to authenticate with email and password only
        $credentials = $request->only($this->username(), 'password');
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            $selectedRole = $request->input('role');
            
            // Validate that the selected role matches the user's actual role
            if ($user->role !== $selectedRole) {
                // Log the invalid role attempt
                \Log::warning("Invalid role login attempt", [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'actual_role' => $user->role,
                    'selected_role' => $selectedRole,
                    'ip_address' => $request->ip(),
                ]);

                // Logout the user immediately
                Auth::logout();

                // Invalidate the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Return with specific error message
                $errorMessage = "Access denied. Your account role is '{$user->role}' but you selected '{$selectedRole}'. Please select the correct role for your account.";
                
                return $this->sendFailedLoginResponse($request, $errorMessage);
            }

            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return $this->sendLoginResponse($request);
        }

        // If authentication failed, increment the login attempts and return
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|string|in:organizer,guest',
        ], [
            'role.required' => 'Please select your role.',
            'role.in' => 'Invalid role selected. Please choose either Organizer or Guest.',
        ]);
    }

    /**
     * Get the failed login response instance.
     */
    protected function sendFailedLoginResponse(Request $request, $customMessage = null)
    {
        $message = $customMessage ?: trans('auth.failed');
        
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember', 'role'))
            ->withErrors([
                $this->username() => $message,
            ]);
    }

    /**
     * Get the post-login redirect path based on user role.
     */
    protected function redirectTo()
    {
        if (Auth::user()->isOrganizer()) {
            return '/admin/dashboard'; // Organizers go to admin dashboard
        }
        
        return '/dashboard'; // Guests go to regular dashboard
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


}
