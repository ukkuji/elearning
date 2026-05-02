<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $webCategory = Category::firstOrCreate(
            ['slug' => 'web-development'],
            ['name' => 'Web Development']
        );

        $designCategory = Category::firstOrCreate(
            ['slug' => 'ui-ux-design'],
            ['name' => 'UI/UX Design']
        );

        $instructor = User::firstOrCreate(
            ['email' => 'instructor@dibiedu.test'],
            [
                'name' => 'Dibi Instructor',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
            ]
        );

        if (! $instructor->password) {
            $instructor->forceFill([
                'password' => Hash::make('password123'),
                'role' => 'instructor',
            ])->save();
        }

        $student = User::firstOrCreate(
            ['email' => 'student@dibiedu.test'],
            [
                'name' => 'Dibi Student',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]
        );

        if (! $student->password) {
            $student->forceFill([
                'password' => Hash::make('password123'),
                'role' => 'student',
            ])->save();
        }

        Course::query()->whereNull('category_id')->update(['category_id' => $webCategory->id]);
        Course::query()->whereNull('instructor_id')->update(['instructor_id' => $instructor->id]);

        $designCourse = Course::firstOrCreate(
            ['title' => 'UI Design Starter Kit'],
            [
                'description' => 'Learn the basic process of designing clean interfaces for web applications.',
                'level' => 'Beginner',
                'duration' => '5 Weeks',
                'price' => 175000,
                'image_style' => 'img-2',
                'category_id' => $designCategory->id,
                'instructor_id' => $instructor->id,
            ]
        );

        Transaction::firstOrCreate(
            ['invoice_number' => 'INV-'.Str::upper(Str::random(8))],
            [
                'user_id' => $student->id,
                'course_id' => $designCourse->id,
                'quantity' => 1,
                'total_price' => $designCourse->price,
                'status' => 'paid',
            ]
        );
    }
}
