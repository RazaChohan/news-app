<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * @inheritdoc
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(5),
            'user_id' =>  User::pluck('id')[$this->faker->numberBetween(1,User::count()-1)]
        ];
    }
}
