<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Overtrue\LaravelOptions\Option;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        Option::truncate();

        Option::create([
            'key' => 'demo',
            'value' => ['status' => 'it works!'],
        ]);
    }
}
