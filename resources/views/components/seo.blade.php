@props(['title' => null, 'description' => null, 'image' => null])

@php
    $siteName = agri_setting('site_name', 'Agrivibe');
    $metaTitle = $title ? "{$title} | {$siteName}" : agri_setting('site_meta_title', $siteName.' — Grow Together');
    $metaDescription = $description ?? agri_setting('site_meta_description', 'Agrivibe is the connected farmer&apos;s platform for knowledge, farming tools, animal health, markets and community.');
    $metaImage = $image ?? agri_setting('site_meta_image');
    $themeColor = '#1a3c29';
@endphp

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}" />
<meta name="theme-color" content="{{ $themeColor }}" />
<link rel="canonical" href="{{ url()->current() }}" />

<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ $siteName }}" />
<meta property="og:title" content="{{ $metaTitle }}" />
<meta property="og:description" content="{{ $metaDescription }}" />
@if ($metaImage)
    <meta property="og:image" content="{{ asset($metaImage) }}" />
@endif
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $metaTitle }}" />
<meta name="twitter:description" content="{{ $metaDescription }}" />

@if (agri_setting('site_google_verification'))
    <meta name="google-site-verification" content="{{ agri_setting('site_google_verification') }}" />
@endif