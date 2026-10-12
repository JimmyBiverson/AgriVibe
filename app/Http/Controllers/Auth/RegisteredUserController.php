<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\Consent;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register', [
            'accountTypes' => collect(config('agrivibe.account_types')),
            'defaultAccountType' => 'farmer',
        ]);
    }

    public function store(Request $request)
    {
        $accountTypes = collect(config('agrivibe.account_types'));

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'regex:/^[a-z0-9._-]+$/', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'account_type' => ['required', 'string', 'in:'.$accountTypes->keys()->implode(',')],
            'password' => ['required', 'confirmed', Password::defaults()],
            'agreed_terms' => ['required', 'accepted'],
        ]);

        $type = $accountTypes->get($validated['account_type']);

        $user = User::query()->create([
            'name' => $validated['name'],
            'username' => $validated['username'] ?? 'user_'.Str::lower(Str::random(6)),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'account_type' => $validated['account_type'],
            'status' => ! empty($type['requires_verification']) ? 'pending' : 'active',
            'password' => $validated['password'],
            'referral_code' => strtoupper(Str::random(8)),
        ]);

        $user->assignRole($type['roles'] ?? []);

        UserProfile::query()->create([
            'user_id' => $user->id,
            'label' => 'account',
            'first_name' => Str::before($validated['name'], ' '),
            'last_name' => Str::afterLast($validated['name'], ' '),
            'metadata' => ['account_type' => $validated['account_type']],
        ]);

        Consent::query()->create([
            'user_id' => $user->id,
            'type' => 'terms_of_service',
            'version' => '1.0',
            'granted' => true,
            'granted_at' => now(),
        ]);

        event(new Registered($user));

        Mail::to($user)->queue(new WelcomeMail($user));

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        Auth::login($user);

        return redirect()->guest(route('verification.notice'));
    }
}
