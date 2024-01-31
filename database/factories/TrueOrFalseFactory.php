<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrueOrFalse>
 */
class TrueOrFalseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'question_no' => fake()->numberBetween(1,10),
            'question' =>  fake()->sentence(),
            'answer' => fake()->boolean(),
            'mark'=> fake()->numberBetween(1,30)
        ];
    }
}
