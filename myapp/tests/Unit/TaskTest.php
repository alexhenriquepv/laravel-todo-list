<?php

namespace Tests\Unit;

use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_api_task_create(): void
    {
        $res = $this->postJson(
            '/api/tasks',
            [
                'title' => 'Title 1',
                'description' => 'Desc 1',
                'user' => 'User'
            ]
        );

        $res->assertStatus(201);
    }

    public function test_api_validation(): void
    {
        $res = $this->postJson(
            '/api/tasks',
            [
                'title' => 'Title 1',
                'description' => 'Desc 1'
            ]
        );

        $res->assertStatus(422)->assertJsonPath('errors.user', ['The user field is required.']);
    }

    public function test_api_error_handler(): void
    {
        $res = $this->getJson('/api/100');
        $res->assertStatus(404)->assertJsonPath('message', 'Resource not found.');
    }
}
