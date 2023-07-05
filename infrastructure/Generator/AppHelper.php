<?php

namespace Infrastructure\Generator;

use Illuminate\Support\Str;

class AppHelper
{
    public static function getNamespace(string $domain, ...$appends): string
    {
        $domain = Str::studly($domain);

        return implode('\\', array_filter(['App', $domain, ...$appends]));
    }

    public static function getPath(string $domain, ...$appends): string
    {
        $domain = Str::studly($domain);

        $appends = collect($appends)->transform(function ($append) {
            return explode(DIRECTORY_SEPARATOR, $append);
        })->flatten()->toArray();

        return base_path(implode(DIRECTORY_SEPARATOR, array_filter(['app', $domain, ...$appends])));
    }
}
