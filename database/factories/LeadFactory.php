<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => fake()->randomNumber(5, true),
            'status' => 1,
            'username' => fake()->unique()->randomNumber('5', true),
            'ftd' => 1,
            'country' => fake()->country(),
            'source' => fake()->text(50),
            'lead_agent_id' => User::where('role', 'agent')->get()->random()->id,
            'team_id' => Team::all()->random()->id,
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
        ];
    }
}
