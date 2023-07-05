<?php

namespace Tests\Feature;

use Domain\User\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @var \Domain\User\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function can_login_with_username_and_password()
    {
        $this->postJson('/api/login', [
            'username' => $this->user->username,
            'password' => 'password',
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['token'])
            ->assertJson(['token_type' => 'bearer']);
    }

    /** @test */
    public function can_fetch_self()
    {
        Sanctum::actingAs($this->user);
        $this->getJson('/api/user')
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'name', 'username']);
    }

    /** @test */
    public function can_logout()
    {
        $token = $this->postJson('/api/login', [
            'username' => $this->user->username,
            'password' => 'password',
        ])->json()['token'];

        $headers = ['Authorization' => 'Bearer '.$token];

        $this->withHeaders($headers)->postJson('/api/logout')
            ->assertSuccessful();

        $this->refreshApplication();

        $this->flushHeaders()->getJson('/api/user')
            ->assertStatus(401);
    }
}
