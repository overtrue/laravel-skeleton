<?php

namespace App\Api\Auth\Tests;

use Domain\User\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_can_login_with_username_and_password()
    {
        $user = User::factory()->create();
        $this->postJson(route('auth.login'), [
            'username' => $user->username,
            'password' => 'password',
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['token'])
            ->assertJson(['type' => 'bearer']);
    }

    public function test_can_fetch_self()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->getJson(route('users.me'))
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'nickname', 'username']);
    }

    public function test_can_logout()
    {
        $user = User::factory()->create();
        $token = $this->postJson(route('auth.login'), [
            'username' => $user->username,
            'password' => 'password',
        ])->json()['token'];

        $headers = ['Authorization' => 'Bearer '.$token];

        $this->withHeaders($headers)->postJson(route('auth.logout'))
            ->assertSuccessful();

        $this->refreshApplication();

        $this->flushHeaders()->getJson(route('users.me'))
            ->assertStatus(401);
    }
}
