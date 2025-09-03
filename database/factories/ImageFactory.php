<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Productos: de 1 a 10
        $fileName = $this->faker->numberBetween(1, 10) . '.jpg';

        return [
            'path' => "img/products/{$fileName}",
        ];
    }

    /**
     * Estado para imágenes de usuarios
     */
    public function user() 
    {
        // Usuarios: de 1P a 5P
        $fileName = $this->faker->numberBetween(1, 5) . 'P.jpg';

        return $this->state([
            'path' => "img/users/{$fileName}",
        ]);
    }
}