<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript to build your first website.',
                'level' => 'Beginner',
                'duration' => '6 Weeks',
                'price' => 199000,
                'image_style' => 'img-1',
            ],
            [
                'title' => 'Advanced JavaScript Techniques',
                'description' => 'Dive deep into JavaScript concepts like asynchronous programming, closures, and ES6 features.',
                'level' => 'Intermediate',
                'duration' => '8 Weeks',
                'price' => 299000,
                'image_style' => 'img-2',
            ],
            [
                'title' => 'Responsive Design Mastery',
                'description' => 'Master the art of creating websites that adapt to different screen sizes and devices.',
                'level' => 'Beginner',
                'duration' => '4 Weeks',
                'price' => 149000,
                'image_style' => 'img-3',
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['title' => $course['title']],
                $course
            );
        }
    }
}
