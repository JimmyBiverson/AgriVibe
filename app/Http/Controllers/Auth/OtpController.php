<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OtpNotification;
use App\Support\OneTimeCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function create(Request $request)
    {
        $userId = $request->session()->get('2fa_user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::query()->find($userId);

        if (! $user) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp', [
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $userId = $request->session()->get('2fa_user_id');
        $user = $userId ? User::query()->find($userId) : null;

        if (! $user) {
            return redirect()->route('login');
        }

        $valid = app(OneTimeCode::class)->verify($user, 'login_2fa', $request->code);

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => 'That code is invalid or has expired. Please try again.',
            ]);
        }

        $request->session()->forget('2fa_user_id');
        $request->session()->regenerate();

        Auth::login($user);

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        $user->loginHistories()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => 'Unknown',
            'channel' => 'web',
            'status' => 'success',
            'login_at' => now(),
            'logout_at' => null,
        ]);

        return redirect()->intended(route('dashboard'));
    }

    public function resend(Request $request)
    {
        $userId = $request->session()->get('2fa_user_id');
        $user = $userId ? User::query()->find($userId) : null;

        if (! $user) {
            return redirect()->route('login');
        }

        $code = app(OneTimeCode::class)->issue($user, 'login_2fa', 'email');
        $user->notify(new OtpNotification($code, 'login'));

        return back()->with('success', 'A fresh code has been sent to your email address.');
    }
}
