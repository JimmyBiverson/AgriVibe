<x-layouts.auth
    title="Two-step verification"
    subtitle="We emailed a 6-digit code to {{ $user->email }}. Enter it below to continue."
>
    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-5">
        @csrf
        <div>
            <x-ui.input label="Verification code" name="code" maxlength="6" inputmode="numeric" required placeholder="123456" class="text-center text-lg tracking-[0.4em] font-semibold" />
            <p class="mt-2 text-xs text-leaf-800/60">Codes expire after 10 minutes. If you don't see it, check your spam folder.</p>
        </div>
        <x-ui.button variant="primary" size="lg" type="submit" class="w-full">Verify and continue</x-ui.button>
    </form>
    <form method="POST" action="{{ route('otp.resend') }}" class="mt-3">
        @csrf
        <x-ui.button variant="ghost" size="sm" type="submit" class="w-full">Resend code</x-ui.button>
    </form>
</x-layouts.auth>