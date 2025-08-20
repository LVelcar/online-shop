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
        // Imágenes de productos con nombre único
        $fileName = uniqid() . '.jpg';

        return [
            'path'=> "img/products/{$fileName}",
        ];
    }

    /**
     * Estado para imágenes de usuarios
     */
    public function user() 
    {
        $fileName = uniqid() . '.jpg';

        return $this->state([
            'path' => "img/users/{$fileName}",
        ]);
    }
}
