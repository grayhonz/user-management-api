<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_users()
    {
        // Create some test users
        User::create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'age' => 25
        ]);

        User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'age' => 30
        ]);

        // Test the endpoint
        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function test_can_create_user()
    {
        $userData = [
            'name' => 'New User',
            'email' => 'new@example.com',
            'age' => 28
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                 ->assertJsonFragment($userData);

        $this->assertDatabaseHas('users', $userData);
    }

    public function test_can_get_single_user()
    {
        $user = User::create([
            'name' => 'Single User',
            'email' => 'single@example.com',
            'age' => 35
        ]);

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Single User',
                     'email' => 'single@example.com',
                     'age' => 35
                 ]);
    }

    public function test_can_update_user()
    {
        $user = User::create([
            'name' => 'User to Update',
            'email' => 'update@example.com',
            'age' => 40
        ]);

        $updatedData = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'age' => 41
        ];

        $response = $this->putJson('/api/users/' . $user->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('users', $updatedData);
    }

    public function test_can_delete_user()
    {
        $user = User::create([
            'name' => 'User to Delete',
            'email' => 'delete@example.com',
            'age' => 45
        ]);

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_validates_invalid_input()
    {
        $invalidData = [
            'name' => '',
            'email' => 'not-an-email',
            'age' => 'not-a-number'
        ];

        $response = $this->postJson('/api/users', $invalidData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'age']);
    }
}