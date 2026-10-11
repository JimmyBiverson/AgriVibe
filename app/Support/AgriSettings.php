<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class AgriSettings
{
    protected ?array $items = null;

    public function all(): array
    {
        if ($this->items === null) {
            $this->items = Cache::remember('agrisettings.all', now()->addHour(), function () {
                return Setting::query()
                    ->get()
                    ->pluck('value', 'key')
                    ->filter(fn ($value) => $value !== null && $value !== '')
                    ->all();
            });
        }

        return $this->items;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = Arr::get($this->all(), $key, $default);

        if ($value === null) {
            return $default;
        }

        if (is_string($value) && in_array(strtolower($value), ['true', 'false'], true)) {
            return strtolower($value) === 'true';
        }

        return $value;
    }

    public function json(string $key, mixed $default = []): mixed
    {
        $value = $this->get($key);

        if (is_string($value)) {
            return json_decode($value, true) ?? $default;
        }

        return $value ?? $default;
    }

    public function forget(): void
    {
        Cache::forget('agrisettings.all');
        $this->items = null;
    }
}