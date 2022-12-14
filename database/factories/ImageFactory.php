<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'cursos/' . $this->faker->image('public/storage/cursos', 600, 400, null, false),
        ];
        /*return [
            'url' => 'cursos/' . $this->faker->image(storage_path('cursos'), 600, 400, null, false),
        ];*/
    }
}
