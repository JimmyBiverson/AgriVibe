<?php

namespace App\Support;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OneTimeCode
{
    public function issue(User $user, string $purpose, string $channel = 'email', int $ttlMinutes = 10, int $length = 6): string
    {
        $code = Str::padLeft((string) random_int(0, (int) str_repeat('9', $length)), $length, '0');

        OtpCode::query()
            ->where('user_id', $user->id)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->update(['consumed_at' => now()]);

        OtpCode::query()->create([
            'user_id' => $user->id,
            'identifier' => $channel === 'email' ? $user->email : ($user->phone ?? 'sms'),
            'channel' => $channel,
            'purpose' => $purpose,
            'code_hash' => Hash::make($code),
            'attempts' => 0,
            'expires_at' => now()->addMinutes($ttlMinutes),
            'ip' => request()->ip(),
        ]);

        return $code;
    }

    public function verify(User $user, string $purpose, string $code): bool
    {
        $otp = OtpCode::query()
            ->where('user_id', $user->id)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->latest()
            ->first();

        if (! $otp || ! $otp->isValid()) {
            return false;
        }

        if (! Hash::check($code, $otp->code_hash)) {
            $otp->increment('attempts');
            if ($otp->attempts >= 5) {
                $otp->update(['consumed_at' => now()]);
            }

            return false;
        }

        $otp->update(['consumed_at' => now()]);

        return true;
    }
}