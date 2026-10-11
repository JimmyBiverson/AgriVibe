<x-layouts.auth
    title="Choose a new password"
    subtitle="Pick a strong password you'll remember."
>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-ui.input label="Email" name="email" type="email" required value="{{ $email }}" placeholder="you@example.com" />
        <x-ui.input label="New password" name="password" type="password" required autocomplete="new-password" placeholder="At least 8 characters" />
        <x-ui.input label="Confirm password" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Repeat password" />
        <x-ui.button variant="primary" size="lg" type="submit" class="w-full">Reset password</x-ui.button>
    </form>
</x-layouts.auth>