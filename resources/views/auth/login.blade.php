<x-layouts.auth
    title="Welcome back"
    subtitle="Log in to manage your farm, explore knowledge and grow your agribusiness."
>
    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf

        <x-ui.input label="Email" name="email" type="email" required autocomplete="email" placeholder="you@example.com" />

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <label for="password" class="mb-1.5 block text-sm font-medium text-leaf-900">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-leaf-600 hover:text-leaf-800">Forgot password?</a>
            </div>
            <div class="relative">
                <x-ui.input name="password" type="password" required autocomplete="current-password" placeholder="••••••••" class="pr-10" x-bind:type="show ? 'text' : 'password'" />
                <button type="button" @click="show = ! show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-leaf-800/50 hover:text-leaf-700" aria-label="Toggle password visibility">
                    <span x-show="!show"><x-ui.icon name="eye" class="h-4 w-4" /></span>
                    <span x-show="show" x-cloak><x-ui.icon name="eye-off" class="h-4 w-4" /></span>
                </button>
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-leaf-900">
            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-sand-300 text-leaf-600 focus:ring-leaf-500">
            Remember me
        </label>

        <div class="pt-2">
            <x-ui.button variant="primary" size="lg" type="submit" class="w-full">Log in</x-ui.button>
        </div>
    </form>

    <div class="mt-6 flex items-center gap-3 text-xs text-leaf-800/50">
        <span class="h-px flex-1 bg-sand-200"></span>
        NEW TO AGRIVIBE?
        <span class="h-px flex-1 bg-sand-200"></span>
    </div>

    <p class="mt-4 text-center text-sm text-leaf-900">
        <a href="{{ route('register') }}" class="font-semibold text-leaf-600 underline-offset-4 hover:underline">Create an account</a>
    </p>
</x-layouts.auth>