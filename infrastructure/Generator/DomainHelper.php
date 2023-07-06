<?php

namespace Infrastructure\Generator;

use Illuminate\Support\Str;

class DomainHelper
{
    public static function getStub(string $name): string
    {
        return __DIR__.'/stubs/'.$name.'.stub';
    }

    public static function getNamespace(string $domain, ...$appends): string
    {
        $domain = Str::studly($domain);

        return implode('\\', array_filter(['Domain', $domain, ...$appends]));
    }

    public static function getPath(string $domain, ...$appends): string
    {
        $domain = Str::studly($domain);

        $appends = collect($appends)->transform(function ($append) {
            return explode(DIRECTORY_SEPARATOR, $append);
        })->flatten()->toArray();

        return base_path(implode(DIRECTORY_SEPARATOR, array_filter(['domain', $domain, ...$appends])));
    }
}
