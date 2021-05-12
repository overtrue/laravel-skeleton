<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAgent;
use Carbon\Carbon;
use Tests\TestCase;

class UserAgentTest extends TestCase
{
    public function test_record_user_agent_middleware_create_availability()
    {
        $alex = User::factory()->create();

        // 任意访问一个地址通过中间件记录 UA
        $this->actingAs($alex)->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'Alex\'s Browser'])->assertStatus(200);
        $this->assertDatabaseHas('user_agents', ['user_id' => $alex->id, 'agent' => 'Alex\'s Browser']);
        $this->assertDatabaseCount('user_agents', 1);

        // 不带 UA 的请求
        $this->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => ''])->assertStatus(200);
        $this->assertDatabaseHas('user_agents', ['user_id' => $alex->id, 'agent' => 'Unknown']);
        $this->assertDatabaseCount('user_agents', 2);

        // 同一用户不同 UA
        $this->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'Alex\'s Other Browser'])->assertStatus(200);
        $this->assertDatabaseHas('user_agents', ['user_id' => $alex->id, 'agent' => 'Alex\'s Other Browser']);
        $this->assertDatabaseCount('user_agents', 3);

        $this->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'sketch'])->assertStatus(200);
        $this->assertDatabaseHas('user_agents', ['user_id' => $alex->id, 'agent' => 'sketch']);
        $this->assertDatabaseCount('user_agents', 4);
    }

    public function test_record_user_agent_middleware_update_availability()
    {
        $alex = User::factory()->create();

        $this->actingAs($alex)->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'Alex\'s Browser'])->assertStatus(200);

        $oldRecord = UserAgent::where('user_id', $alex->id)->first();

        Carbon::setTestNow(\now()->addMinutes(5));

        $this->actingAs($alex)->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'Alex\'s another Browser'])->assertStatus(200);
        $this->assertDatabaseHas('user_agents', ['user_id' => $alex->id, 'agent' => 'Alex\'s another Browser']);
        $this->assertNotEquals($oldRecord->last_used_at, UserAgent::where('user_id', $alex->id)->where('agent', 'Alex\'s another Browser')->first()->last_used_at);

        // 使用不同 UA 更新记录 last_used_at
        $this->actingAs($alex)->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'sketch'])->assertStatus(200);

        $oldRecord = UserAgent::where('user_id', $alex->id)->where('agent', 'sketch')->first();

        Carbon::setTestNow(\now()->addMinutes(10));
        $this->actingAs($alex)->get(sprintf('/api/users/%s', $alex->id), ['User-Agent' => 'sketch'])->assertStatus(200);
        $this->assertDatabaseHas('user_agents', ['user_id' => $alex->id, 'agent' => 'sketch']);
        $this->assertNotEquals($oldRecord->last_used_at, UserAgent::where('user_id', $alex->id)->where('agent', 'sketch')->first()->last_used_at);
    }
}
