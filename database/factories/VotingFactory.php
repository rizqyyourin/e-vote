<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Voting;
use Illuminate\Database\Eloquent\Factories\Factory;

class VotingFactory extends Factory
{
    protected $model = Voting::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'admin_id' => User::factory()->create(['role' => 'admin'])->id,
            'status' => 'draft',
            'starts_at' => null,
            'ends_at' => null,
        ];
    }

    public function active(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'starts_at' => now()->subHours(1),
            ];
        });
    }

    public function finished(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'finished',
                'starts_at' => now()->subHours(2),
                'ends_at' => now()->subMinutes(30),
            ];
        });
    }
}
