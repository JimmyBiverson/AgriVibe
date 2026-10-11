<x-layouts.auth
    title="Verify your email"
    subtitle="We sent you a verification link. Check your inbox (and spam folder) to activate your account."
>
    <div class="space-y-5">
        <div class="flex items-start gap-3 rounded-xl border border-sand-200 bg-sand-50 p-4 text-sm text-leaf-900">
            <x-ui.icon name="mail" class="mt-0.5 h-5 w-5 shrink-0 text-leaf-600" />
            <span>You must confirm your email address before you can access the dashboard.</span>
        </div>

        <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
            @csrf
            <x-ui.button variant="secondary" size="lg" type="submit" class="w-full">Resend verification email</x-ui.button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-ui.button variant="ghost" size="sm" type="submit" class="w-full">Log out</x-ui.button>
        </form>
    </div>
</x-layouts.auth>