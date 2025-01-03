<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjectId = FactoryHelper::getRandomModelId(Subject::class);
        $userId = FactoryHelper::getRandomModelId(User::class);

        return [
            'name' => fake()->word,
            'started_date' => fake()->date(),
            'price' => fake()->randomElement([400000, 500000, 600000, 300000]),
            'subject_id' => $subjectId,
            'user_id' => $userId,
        ];
    }
}
