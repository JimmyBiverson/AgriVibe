<x-layouts.auth
    title="Create your free account"
    subtitle="Join the connected farming community. Choose the account type that fits you."
    maxWidth="max-w-lg"
>
    <form method="POST" action="{{ route('register.post') }}" class="space-y-4" x-data="{ accountType: '{{ old('account_type', 'farmer') }}' }">
        @csrf

        <x-ui.input label="Full name" name="name" required autocomplete="name" placeholder="e.g. Joan Akello" />

        <div class="grid gap-4 sm:grid-cols-2">
            <x-ui.input label="Email" name="email" type="email" required autocomplete="email" placeholder="you@example.com" />
            <x-ui.input label="Phone (optional)" name="phone" autocomplete="tel" placeholder="+256 700 000 000" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-leaf-900">I am a…</label>
            <select name="account_type" x-model="accountType" class="block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-sm text-leaf-950 shadow-sm ring-1 ring-inset ring-sand-300 focus:ring-2 focus:ring-inset focus:ring-leaf-500">
                @foreach ($accountTypes as $key => $type)
                    <option value="{{ $key }}">{{ $type['label'] }}</option>
                @endforeach
            </select>
            <p class="mt-2 min-h-4 text-xs text-leaf-800/60" x-text="'{{ $accountTypes->pluck('description')->implode('|') }}'.split('|')[$el.closest('div').querySelector('select').selectedIndex] ?? ''"></p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-ui.input label="Password" name="password" type="password" required autocomplete="new-password" placeholder="At least 8 characters" />
            <x-ui.input label="Confirm password" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Repeat password" />
        </div>

        <label class="flex items-start gap-2 text-sm text-leaf-900">
            <input type="checkbox" name="agreed_terms" value="1" class="mt-0.5 h-4 w-4 rounded border-sand-300 text-leaf-600 focus:ring-leaf-500">
            <span>I agree to the <a href="#" class="font-medium text-leaf-600 underline decoration-leaf-300 underline-offset-2">Terms of Service</a> and <a href="#" class="font-medium text-leaf-600 underline decoration-leaf-300 underline-offset-2">Privacy Policy</a>.</span>
        </label>

        <div class="pt-2">
            <x-ui.button variant="primary" size="lg" type="submit" class="w-full">Create my account</x-ui.button>
        </div>
    </form>

    <div class="mt-6 flex items-center gap-3 text-xs text-leaf-800/50">
        <span class="h-px flex-1 bg-sand-200"></span>
        ALREADY HAVE AN ACCOUNT?
        <span class="h-px flex-1 bg-sand-200"></span>
    </div>

    <p class="mt-4 text-center text-sm text-leaf-900">
        <a href="{{ route('login') }}" class="font-semibold text-leaf-600 underline-offset-4 hover:underline">Log in instead</a>
    </p>
</x-layouts.auth>