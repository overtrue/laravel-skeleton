<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'username' => 'admin',
            'name' => '超级管理员',
            'is_admin' => 1,
            'password' => 'changeThis!!'
        ]);
    }
}
