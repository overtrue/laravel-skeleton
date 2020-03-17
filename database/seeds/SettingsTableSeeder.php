<?php

use Illuminate\Database\Seeder;
use Overtrue\LaravelOptions\Option;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::truncate();

        Option::create([
            'key' => 'demo',
            'value' => ['status' => 'it works!'],
        ]);
    }
}
