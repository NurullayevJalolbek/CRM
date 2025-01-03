<?php

namespace Database\Factories;

use App\Models\Subject;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjectId = FactoryHelper::getRandomModelId(Subject::class);

        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'number' => $this->faker->phoneNumber,
            'subject_id' => $subjectId,
        ];
    }
}
