<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Voting;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateFactory extends Factory
{
    protected $model = Candidate::class;

    public function definition(): array
    {
        return [
            'voting_id' => Voting::factory(),
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
        ];
    }
}
