<?php

namespace App\Api\User\Tests;

use Domain\User\User;
use Tests\TestCase;

class GetMeTest extends TestCase
{
    public function test_user_can_get_me()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->getJson(route('users.me'))->assertSuccessful()
            ->assertJsonFragment([
                'id' => $user->id,
                'username' => $user->username,
                'nickname' => $user->nickname,
            ]);
    }
}
