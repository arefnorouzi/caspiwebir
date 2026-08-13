<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Lesson::first();
        if (! $model) {
            $courses = Course::get(['id', 'name']);
            foreach ($courses as $course) {
                $items = [
                    ['name' => fake()->company, 'course_id' => $course->id, 'user_id' => 2, 'lesson_time' => rand(5, 59).':' . rand(2, 58) , 'free' => true, 'demo_link' => 'https://www.aparat.com/v/w89z670'],
                    ['name' => fake()->company, 'course_id' => $course->id, 'user_id' => 2, 'lesson_time' => rand(5, 59).':' . rand(2, 58), 'free' => true],
                    ['name' => fake()->company, 'course_id' => $course->id, 'user_id' => 2, 'lesson_time' => rand(5, 59).':' . rand(2, 58), 'free' => false],
                    ['name' => fake()->company, 'course_id' => $course->id, 'user_id' => 2, 'lesson_time' => rand(5, 59).':' . rand(2, 58), 'free' => false],
                    ['name' => fake()->company, 'course_id' => $course->id, 'user_id' => 2, 'lesson_time' => rand(5, 59).':' . rand(2, 58), 'free' => false],
                ];
                foreach ($items as $item) {
                    Lesson::create($item);
                }
            }

        }
    }
}
