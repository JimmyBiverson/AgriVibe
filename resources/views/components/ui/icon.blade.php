@props(['name'])
@php
    $aliases = [
        'search' => 'magnifying-glass',
        'close' => 'x-mark',
        'chevron-down' => 'chevron-down',
        'chevron-right' => 'chevron-right',
        'chevron-left' => 'chevron-left',
        'user' => 'user',
        'users' => 'users',
        'home' => 'home',
        'menu' => 'bars-3',
        'bag' => 'shopping-bag',
        'academy' => 'academic-cap',
        'community' => 'chat-bubble-left-right',
        'pin' => 'map-pin',
        'cash' => 'banknotes',
        'bell' => 'bell',
        'calendar' => 'calendar',
        'arrow-right' => 'arrow-right',
        'arrow-left' => 'arrow-left',
        'check' => 'check',
        'check-circle' => 'check-circle',
        'warn' => 'exclamation-triangle',
        'info' => 'information-circle',
        'plus' => 'plus',
        'minus' => 'minus',
        'heart' => 'heart',
        'heart-pulse' => 'heart',
        'phone' => 'phone',
        'mail' => 'envelope',
        'truck' => 'truck',
        'sparkles' => 'sparkles',
        'book' => 'book-open',
        'list' => 'queue-list',
        'edit' => 'pencil-square',
        'trash' => 'trash',
        'eye' => 'eye',
        'eye-off' => 'eye-slash',
        'camera' => 'camera',
        'tools' => 'wrench-screwdriver',
        'beaker' => 'beaker',
        'sun' => 'sun',
        'cloud' => 'cloud',
        'briefcase' => 'briefcase',
        'shield' => 'shield-check',
        'clock' => 'clock',
        'flag' => 'flag',
        'send' => 'paper-airplane',
        'share' => 'share',
        'star' => 'star',
        'tag' => 'tag',
        'folder' => 'folder',
        'question' => 'question-mark-circle',
        'document' => 'document-text',
        'photo' => 'photo',
        'play' => 'play',
        'signal' => 'signal',
        'city' => 'building-office',
        'droplet' => 'beaker',
        'grain' => 'cake',
    ];
    $icon = $aliases[$name] ?? $name;
@endphp

@if ($name === 'leaf')
    <svg {{ $attributes->merge(['fill' => 'none', 'viewBox' => '0 0 24 24', 'stroke-width' => '1.5', 'stroke' => 'currentColor']) }} aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5c-.5-8.5 5-15 15-15.5l.6-.04-.05.6C19.6 13.7 12.8 18.9 5 18.6c-.9-.03-1.6.2-2 .9Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 17.5c2.2-3.8 6-6.9 11-8.6" />
    </svg>
@else
    <x-dynamic-component :component="'heroicon-o-'.$icon" {{ $attributes }} />
@endif