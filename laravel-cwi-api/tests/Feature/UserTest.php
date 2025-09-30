<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list users', function () {
    User::factory()->count(3)->create();

    $response = $this->getJson('/api/users');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('can create user', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/users', $userData);

    $response->assertStatus(201)
        ->assertJsonFragment(['name' => 'John Doe', 'email' => 'john@example.com']);

    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

test('can show user', function () {
    $user = User::factory()->create();

    $response = $this->getJson("/api/users/{$user->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['id' => $user->id, 'name' => $user->name]);
});

test('can update user', function () {
    $user = User::factory()->create();

    $updateData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ];

    $response = $this->putJson("/api/users/{$user->id}", $updateData);

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Updated Name', 'email' => 'updated@example.com']);

    $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
});

test('can delete user', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson("/api/users/{$user->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('returns 404 for non-existent user', function () {
    $response = $this->getJson('/api/users/999');

    $response->assertStatus(404)
        ->assertJson(['message' => 'User not found.']);
});
