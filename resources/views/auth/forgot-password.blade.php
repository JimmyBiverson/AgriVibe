<x-layouts.auth
    title="Reset your password"
    subtitle="Enter your account email and we'll send you a secure reset link."
>
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <x-ui.input label="Email" name="email" type="email" required autocomplete="email" placeholder="you@example.com" />
        <x-ui.button variant="primary" size="lg" type="submit" class="w-full">Send reset link</x-ui.button>
    </form>
    <p class="mt-5 text-center text-sm text-leaf-900">
        <a href="{{ route('login') }}" class="font-semibold text-leaf-600 underline-offset-4 hover:underline">Back to login</a>
    </p>
</x-layouts.auth>