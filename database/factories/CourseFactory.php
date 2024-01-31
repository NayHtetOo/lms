<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_category_id' => CourseCategory::factory(),
            'course_name' => fake()->title(),
            'course_ID' => fake()->text(5),
            'from_date' => fake()->date('Y-m-d','now'),
            'to_date' => fake()->date('Y-m-d','now'),
            'visible' => fake()->boolean(),
            'description' => fake()->paragraph(),
        ];
    }
}
