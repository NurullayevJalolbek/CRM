<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Subject;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjectId = FactoryHelper::getRandomModelId(Subject::class);
        $groupId = FactoryHelper::getRandomModelId(Group::class);

        return [
            'name' => fake()->name,
            'number' => $this->faker->phoneNumber,
            'parent_name' => $this->faker->name,
            'archived_at'=>  $this->faker->dateTimeBetween('2023-02-01', 'now'),
            'parent_number' => $this->faker->phoneNumber,
            'started_date' => $this->faker->dateTimeBetween('2023-02-01', 'now'),
            'subject_id' => 1,
            'created_at' => $this->faker->dateTimeBetween('2023-02-01', 'now'),
            'status' => $this->faker->randomElement(['active', 'archive', 'passive']),
            'notes' => $this->faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        ];
    }
}
