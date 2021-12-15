<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = \App\Models\Product::class;
    
    public function definition()
    {
        return [
            'products_name' =>$this->faker->userName(),
            'manufacturer' => $this->faker->company(),
            'price' => $this->faker->randomNumber(3),
            'stock' => $this->faker->randomNumber(2),
            'status' => $this->faker->numberBetween(1, 2),
            'update_at' => $this->faker->unique()->dateTimeThisMonth($max = 'now', $timezone = 'Asia/Tokyo'),
            'created_at' => $this->faker->unique()->dateTimeBetween($startDate = '-5 days', $endDate = 'now', $timezone = 'Asia/Tokyo')
        ];
    }
}
