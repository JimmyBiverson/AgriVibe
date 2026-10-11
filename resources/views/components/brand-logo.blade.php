@props(['class' => 'h-9 w-9', 'text' => true])

<a {{ $attributes->merge(['href' => route('home'), 'class' => 'inline-flex items-center gap-2']) }}>
    <span class="inline-flex items-center justify-center rounded-xl bg-leaf-700 {{ $class }}">
        <svg viewBox="0 0 24 24" fill="none" class="h-2/3 w-2/3" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M4 20c0-8 6-14 16-15l1-.1-.6 3.4C19 16 13 20 6.5 19.4 5.4 19.3 4.5 19.4 4 20Z" fill="#f4eedd"/>
            <path d="M17.5 8.5 14.5 12c-3 4.5-6.5 6-9 6" stroke="#8fc6a0" stroke-width="1.6" stroke-linecap="round"/>
            <circle cx="20" cy="4" r="1.6" fill="#deaf2f"/>
        </svg>
    </span>
    @if ($text)
        <span class="font-display text-lg font-semibold tracking-tight text-forest-900">
            Agri<b class="text-leaf-600">vibe</b>
        </span>
    @endif
</a>