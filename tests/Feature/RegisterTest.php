<?php

namespace Tests\Feature;

use Domain\User\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test */
    public function can_register()
    {
        $this->postJson('/api/register', [
            'name' => 'Test User',
            'username' => 'test@test.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
        ->assertSuccessful()
        ->assertJsonStructure(['token', 'token_type']);
    }

    /** @test */
    public function can_not_register_with_existing_username()
    {
        User::factory()->create(['username' => 'test@test.app']);

        $this->postJson('/api/register', [
            'name' => 'Test User',
            'username' => 'test@test.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['username']);
    }
}
