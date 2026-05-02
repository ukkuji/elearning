<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('courses can be created updated and deleted', function () {
    $this->actingAs(User::factory()->create());

    $createResponse = $this->post('/courses', [
        'title' => 'Laravel Basics',
        'description' => 'Learn routing, controllers, models, and Blade views.',
        'level' => 'Beginner',
        'duration' => '5 Weeks',
        'price' => 250000,
        'image_style' => 'img-1',
    ]);

    $createResponse->assertRedirect('/courses');
    $this->assertDatabaseHas('courses', [
        'title' => 'Laravel Basics',
        'level' => 'Beginner',
    ]);

    $course = \App\Models\Course::first();

    $updateResponse = $this->put("/courses/{$course->id}", [
        'title' => 'Laravel CRUD Basics',
        'description' => 'Learn complete CRUD with Laravel.',
        'level' => 'Intermediate',
        'duration' => '6 Weeks',
        'price' => 300000,
        'image_style' => 'img-2',
    ]);

    $updateResponse->assertRedirect('/courses');
    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'title' => 'Laravel CRUD Basics',
    ]);

    $deleteResponse = $this->delete("/courses/{$course->id}");

    $deleteResponse->assertRedirect('/courses');
    $this->assertDatabaseMissing('courses', [
        'id' => $course->id,
    ]);
});

test('guest is redirected to login before managing courses', function () {
    $this->get('/courses')->assertRedirect('/login');
});

test('user can register login and logout from the web', function () {
    $this->post('/register', [
        'name' => 'Web User',
        'email' => 'web@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect('/courses');

    $this->assertAuthenticated();

    $this->post('/logout')->assertRedirect('/');
    $this->assertGuest();

    $this->post('/login', [
        'email' => 'web@example.com',
        'password' => 'password123',
    ])->assertRedirect('/courses');

    $this->assertAuthenticated();
});
