<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('auth and protected product crud flow works with jwt token', function () {
    $category = Category::create([
        'name' => 'Programming',
        'slug' => 'programming',
    ]);

    $registerResponse = $this->postJson('/auth/register', [
        'name' => 'API Student',
        'email' => 'api@student.test',
        'password' => 'password123',
    ]);

    $registerResponse
        ->assertCreated()
        ->assertJsonPath('status', 'success')
        ->assertJsonStructure(['data' => ['token']]);

    $loginResponse = $this->postJson('/auth/login', [
        'email' => 'api@student.test',
        'password' => 'password123',
    ]);

    $token = $loginResponse
        ->assertOk()
        ->assertJsonPath('status', 'success')
        ->json('data.token');

    $createResponse = $this->withToken($token)->postJson('/products', [
        'title' => 'API Laravel Course',
        'description' => 'Build a Laravel API with authentication and testing.',
        'level' => 'Intermediate',
        'duration' => '6 Weeks',
        'price' => 350000,
        'image_style' => 'img-1',
        'category_id' => $category->id,
    ]);

    $productId = $createResponse
        ->assertCreated()
        ->assertJsonPath('status', 'success')
        ->json('data.id');

    $this->getJson('/products')
        ->assertOk()
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('cached', true);

    $this->withToken($token)->putJson("/products/{$productId}", [
        'title' => 'API Laravel Course Updated',
        'description' => 'Build and test a complete Laravel API.',
        'level' => 'Advanced',
        'duration' => '7 Weeks',
        'price' => 450000,
        'image_style' => 'img-2',
        'category_id' => $category->id,
    ])->assertOk()
        ->assertJsonPath('data.title', 'API Laravel Course Updated');

    $this->withToken($token)->deleteJson("/products/{$productId}")
        ->assertOk()
        ->assertJsonPath('message', 'Product deleted successfully.');

    $this->assertDatabaseMissing('courses', ['id' => $productId]);
});

test('product validation and authorization errors use assignment response codes', function () {
    $this->postJson('/products', [])->assertUnauthorized()
        ->assertJsonPath('status', 'error');

    $user = User::create([
        'name' => 'Tester',
        'email' => 'tester@example.com',
        'password' => Hash::make('password123'),
    ]);

    $token = app(\App\Services\JwtService::class)->generate($user);

    $this->withToken($token)->postJson('/products', [
        'title' => 'No',
        'price' => -10,
    ])->assertBadRequest()
        ->assertJsonPath('status', 'error')
        ->assertJsonStructure(['errors']);
});

test('advanced query endpoints return aggregation and transaction detail', function () {
    $category = Category::create([
        'name' => 'Web Development',
        'slug' => 'web-development',
    ]);

    $instructor = User::create([
        'name' => 'Instructor',
        'email' => 'instructor@example.com',
        'password' => Hash::make('password123'),
        'role' => 'instructor',
    ]);

    $student = User::create([
        'name' => 'Student',
        'email' => 'student@example.com',
        'password' => Hash::make('password123'),
        'role' => 'student',
    ]);

    $course = Course::create([
        'title' => 'Full Stack Basics',
        'description' => 'Learn full stack foundations with Laravel.',
        'level' => 'Beginner',
        'duration' => '4 Weeks',
        'price' => 250000,
        'image_style' => 'img-3',
        'category_id' => $category->id,
        'instructor_id' => $instructor->id,
    ]);

    Transaction::create([
        'invoice_number' => 'INV-TEST-001',
        'user_id' => $student->id,
        'course_id' => $course->id,
        'quantity' => 1,
        'total_price' => $course->price,
        'status' => 'paid',
    ]);

    $this->getJson('/instructors/course-count')
        ->assertOk()
        ->assertJsonPath('data.0.name', 'Instructor')
        ->assertJsonPath('data.0.course_count', 1);

    $this->getJson('/transactions/detail')
        ->assertOk()
        ->assertJsonPath('data.0.user_name', 'Student')
        ->assertJsonPath('data.0.product_title', 'Full Stack Basics')
        ->assertJsonPath('data.0.category_name', 'Web Development');
});
