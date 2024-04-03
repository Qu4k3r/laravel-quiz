<?php

namespace Database\Factories;

use App\Enums\Themes;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Theme>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid,
            'title' => Themes::getRandom()->value
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function createAll(bool $persist = false): static
    {
        $sequence = $this->sequence(
            ['title' => 'SQL'],
            ['title' => 'Laravel'],
            ['title' => 'Javascript'],
        );

        if ($persist) {
            $sequence->count(3)->create();
            return $sequence;
        }
        return $sequence->count(3);
    }
}
