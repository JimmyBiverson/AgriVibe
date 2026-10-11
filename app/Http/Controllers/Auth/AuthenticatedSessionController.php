<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = mb_strtolower($request->string('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)]),
            ]);
        }

        $user = \App\Models\User::query()->where('email', $request->email)->first();

        if ($user && in_array($user->status, ['pending'], true)) {
            throw ValidationException::withMessages([
                'email' => 'Your account is still pending review. We will notify you once it is approved.',
            ]);
        }

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        $user = Auth::user();

        // 2FA (authenticator or email OTP) enabled for this account.
        if ($user->two_factor_secret) {
            $code = app(\App\Support\OneTimeCode::class)->issue($user, 'login_2fa', 'email');
            $user->notify(new \App\Notifications\OtpNotification($code, 'login'));

            $request->session()->put('2fa_user_id', $user->id);
            Auth::logout();

            return redirect()->route('otp.show');
        }

        $this->recordLogin($request, $user);

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function recordLogin(Request $request, \App\Models\User $user): void
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        $user->loginHistories()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->device($request),
            'channel' => 'web',
            'status' => 'success',
            'login_at' => now(),
            'logout_at' => null,
        ]);
    }

    protected function device(Request $request): ?string
    {
        $ua = (string) $request->userAgent();

        return match (true) {
            str_contains($ua, 'Android') => 'Android',
            str_contains($ua, 'iPhone') || str_contains($ua, 'iPad') => 'iOS',
            str_contains($ua, 'Macintosh') => 'Desktop',
            default => 'Unknown',
        };
    }
}