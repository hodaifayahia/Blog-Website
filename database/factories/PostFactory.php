<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titel = $this->faker->realText();
        return [
            'title' => $titel, // Random title
            'slug' => Str::slug($titel), // Random slug
            'body' => fake()->realText(100), // Random body text
            'thumbnail' => $this->faker->imageUrl(800, 600, 'nature', true), // Random image URL for thumbnail
            'active' => fake()->boolean, // Random active status (true/false)
            'published_at' => fake()->dateTime, // Random published_at date within this year
            'user_id' => 1, // Assuming user exists and you want to link a user
        ];
    }
}
