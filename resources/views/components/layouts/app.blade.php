@props(['title' => null, 'description' => null, 'image' => null])

@php
    $siteName = agri_setting('site_name', 'Agrivibe');
    $flashes = collect([
        'success' => 'success',
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
    ]);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.svg') }}">
    <x-seo :title="$title" :description="$description" :image="$image" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex min-h-screen flex-col bg-sand-50 font-sans text-leaf-950 antialiased">
    <x-public.header />

    <div class="fixed inset-x-0 top-0 z-[60] space-y-2 p-4 sm:p-6">
        @foreach ($flashes as $key => $type)
            @if (session($key))
                <x-ui.alert :type="$type" dismissable class="mx-auto max-w-lg shadow-lg">
                    {{ session($key) }}
                </x-ui.alert>
            @endif
        @endforeach
        @if ($errors->any())
            <x-ui.alert type="danger" dismissable class="mx-auto max-w-lg shadow-lg">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </x-ui.alert>
        @endif
    </div>

    <main {{ $attributes->merge(['class' => 'flex-1']) }}>
        {{ $slot }}
    </main>

    <x-public.footer />

    <x-public.toasts />
    @stack('scripts')
</body>
</html>