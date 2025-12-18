<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\TwoFactorAuthMail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WebsiteTwoFactorAuthController extends Controller
{
    /**
     * Show the 2FA verification form.
     */
    public function show2FAForm(Request $request): View
    {
        $user_id = $request->session()->get('user_id');
        
        if (!$user_id) {
            // If no user_id in session, redirect to login
            return view('auth.login')->withErrors([
                'email' => 'Session expired. Please login again.',
            ]);
        }
        
        return view('auth.login', [
            'show_otp' => true,
            'user_id' => $user_id
        ]);
    }

    /**
     * Verify the 2FA code.
     */
    public function verify2FA(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = User::find($request->user_id);
        
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'User not found. Please login again.',
            ]);
        }
        
        // Check if OTP is valid and not expired
        if (!$user->otp_code || $user->otp_code !== $request->otp_code) {
            return redirect()->route('2fa.show')->with([
                'user_id' => $user->id,
                '2fa_error' => 'Invalid OTP code. Please try again.'
            ]);
        }
        
        // Check if OTP is expired
        if (Carbon::now()->gt($user->otp_expires_at)) {
            return redirect()->route('2fa.show')->with([
                'user_id' => $user->id,
                '2fa_error' => 'OTP code has expired. Please request a new one.'
            ]);
        }
        
        // Clear OTP data
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();
        
        // Log the user in
        Auth::login($user, $request->session()->get('remember', false));
        
        $request->session()->regenerate();
        
        // Remove temporary session data
        $request->session()->forget(['user_id', 'remember']);
        
        // Redirect to appropriate dashboard based on user type
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        
        return redirect()->intended(route('home.index', absolute: false));
    }

    /**
     * Resend the 2FA code.
     */
    public function resend2FA(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = User::find($request->user_id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }
        
        // Generate new OTP
        $otpCode = rand(100000, 999999); // 6-digit numeric code
        $otpExpiresAt = Carbon::now()->addMinutes(10);
        
        // Store OTP in database
        $user->otp_code = $otpCode;
        $user->otp_expires_at = $otpExpiresAt;
        $user->save();
        
        try {
            // Send new OTP via email
            Mail::to($user->email)->send(new TwoFactorAuthMail($otpCode));
            
            return response()->json([
                'success' => true,
                'message' => 'New OTP sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }
}