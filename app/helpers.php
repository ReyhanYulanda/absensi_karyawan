<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting($key, $default = null) {
        return optional(
            Setting::where('key', $key)->first()
        )->value ?? $default;
    }
}
