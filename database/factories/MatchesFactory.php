<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matches>
 */
class MatchesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'team_id_home' => $this->faker->numberBetween(1, 10),
            'team_id_away' => $this->faker->numberBetween(1, 10),
            'location' => $this->faker->address,
            'cc' => $this->faker->word,
            'date' => $this->faker->date,
            'season_id' => $this->faker->numberBetween(1, 10),
            'score_home' => $this->faker->numberBetween(0, 10),
            'score_away' => $this->faker->numberBetween(0, 10),
            'winner_id' => $this->faker->numberBetween(1, 10),
            'result' => $this->faker->randomElement(['home_win', 'away_win', 'draw']),
        ];
    }
}
