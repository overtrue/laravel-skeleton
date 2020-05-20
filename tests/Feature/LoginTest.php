<?php

namespace Tests\Feature;

use App\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function authenticate()
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
    public function fetch_the_current_user()
    {
        Sanctum::actingAs($this->user);
        $this->getJson('/api/user')
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'name', 'username']);
    }

    /** @test */
    public function log_out()
    {
        $token = $this->postJson('/api/login', [
            'username' => $this->user->username,
            'password' => 'password',
        ])->json()['token'];

        $headers = ['Authorization' => 'Bearer ' . $token];

        $this->withHeaders($headers)->postJson("/api/logout")
            ->assertSuccessful();

        $this->refreshApplication();

        $this->flushHeaders()->getJson("/api/user")
            ->assertStatus(401);
    }
}
