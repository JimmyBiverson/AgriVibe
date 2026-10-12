<?php

use App\Support\AgriSettings;

if (! function_exists('agri_setting')) {
    function agri_setting(string $key, mixed $default = null): mixed
    {
        return app(AgriSettings::class)->get($key, $default);
    }
}

if (! function_exists('agri_json_setting')) {
    function agri_json_setting(string $key, mixed $default = []): mixed
    {
        return app(AgriSettings::class)->json($key, $default);
    }
}

if (! function_exists('agri_currencies')) {
    function agri_currencies(): array
    {
        return config('agrivibe.currencies', []);
    }
}

if (! function_exists('agri_account_types')) {
    function agri_account_types(): array
    {
        return collect(config('agrivibe.account_types'))->pluck('label', 'key')->all();
    }
}
