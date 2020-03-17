<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'defaults' => [
        'provider' => 'eloquent',
    ],

    'providers' => [
        'eloquent' => [
            'driver' => 'eloquent',
            'model' => \Overtrue\LaravelOptions\Option::class,
        ],
    ],
];
