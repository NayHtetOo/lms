<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'course_section_id' => CourseSection::factory(),
            'exam_name' => fake()->sentence(),
            'start_date_time' => fake()->dateTime('now',null),  //->format('d-m-Y H:i:s'),
            'end_date_time' => fake()->dateTime('now',null),    //->format('d-m-Y H:i:s'),
            'description' => fake()->paragraph(),
            'duration' => fake()->numberBetween(30,300)
        ];
    }
}
