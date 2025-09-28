<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => fake()->randomNumber(4, true),
            'title' => fake()->text(100),
            'description' => fake()->text(500),
            'status' => StatusEnum::Pending,
            'priority' => PriorityEnum::Medium,
        ];
    }
}
