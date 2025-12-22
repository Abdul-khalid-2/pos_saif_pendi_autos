<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorAuthMail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // First, validate credentials
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        $user = Auth::user();

        // Check if user is admin and requires 2FA
        // if ($user->hasRole('admin')) {
        //     // Generate OTP
        //     // $otpCode = rand(100000, 999999); // 6-digit numeric code
        //     $otpCode = '401924'; // 6-digit numeric code
        //     $otpExpiresAt = Carbon::now()->addMinutes(10);

        //     // Store OTP in database
        //     $user->otp_code = $otpCode;
        //     $user->otp_expires_at = $otpExpiresAt;
        //     $user->save();

        //     // Send OTP via email
        //     Mail::to($user->email)->send(new TwoFactorAuthMail($otpCode));

        //     // Store user ID and remember flag in session
        //     $request->session()->put('user_id', $user->id);
        //     $request->session()->put('remember', $request->boolean('remember'));

        //     // Logout user until OTP is verified
        //     Auth::logout();

        //     // Redirect to OTP verification page
        //     return redirect()->route('2fa.show')->with(
        //         '2fa_required',
        //         'Please enter the OTP sent to your email to complete login.'
        //     );
        // }

        // For regular users, just log them in
        $request->session()->regenerate();

        // Redirect regular users to home page
        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
