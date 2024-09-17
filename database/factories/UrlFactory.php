<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UrlFactory extends Factory
{
    // El nombre del modelo que esta fábrica está creando
    protected $model = \App\Models\Url::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'original_url' => $this->faker->url(),
            'short_url' => Str::random(8), // Puedes ajustar la longitud si es necesario
        ];
    }
}
