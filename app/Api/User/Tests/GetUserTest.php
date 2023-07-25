<?php

namespace App\Api\User\Tests;

use Domain\User\User;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    public function test_can_get_user()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user);

        $this->getJson(route('users.show', $user2->id))->assertSuccessful()
            ->assertJsonFragment([
                'id' => $user2->id,
                'username' => $user2->username,
                'nickname' => $user2->nickname,
            ]);
    }
}
