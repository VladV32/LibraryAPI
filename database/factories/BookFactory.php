<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'publisher' => $this->faker->company,
            'author' => $this->faker->userName,
            'genre' => $this->faker->word,
            'publication_date' => $this->faker->date,
            'word_count' => $this->faker->numberBetween(10000, 100000),
            'price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}

