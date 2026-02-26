<?php

namespace Database\Factories;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition()
    {
        return [
            'site_id' => \App\Models\Site::factory(),
            'user_id' => \App\Models\User::factory(),
            'visited_at' => $this->faker->dateTime(),
            'notes' => $this->faker->sentence(),
            'status' => 'draft',
        ];
    }
}