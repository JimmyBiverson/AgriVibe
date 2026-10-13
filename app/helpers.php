<?php

use App\Models\Farm;
use App\Models\User;
use App\Support\AgriSettings;
use Illuminate\Database\Eloquent\Collection;

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

if (! function_exists('available_farms')) {
    /**
     * Farms owned by or shared with the given (or current) user.
     *
     * @return Collection<int, Farm>
     */
    function available_farms(?User $user = null): Collection
    {
        $user ??= auth()->user();

        if (! $user) {
            return new Collection;
        }

        return $user->ownedFarms()->get()
            ->merge($user->farms()->get())
            ->unique('id')
            ->values();
    }
}

if (! function_exists('current_farm')) {
    function current_farm(?int $id = null, ?User $user = null): ?Farm
    {
        $farms = available_farms($user);

        return ($id ? $farms->firstWhere('id', $id) : null) ?? $farms->first();
    }
}
