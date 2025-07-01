<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'             => $this->faker->sentence(3),
            'isbn'              => $this->faker->unique()->isbn13(),
            'short_description' => $this->faker->optional()->paragraph(),
            'long_description'  => $this->faker->optional()->paragraphs(3, true),
            'page_count'        => $this->faker->numberBetween(100, 600),
            'published_date'    => $this->faker->date(),
            'status'            => 'PUBLISH',
            'thumbnail_url'     => $this->faker->imageUrl(200, 300, 'books'),
        ];
    }
}
