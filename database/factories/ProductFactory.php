<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

use Str;
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Category List
     * 
     * @var array
     */
    private $category = ['music','gaming','peripherals','accessories','consumable','hardware'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => Str::random(10),
            "description" => $this->faker->sentence(),
            "category" => $this->category[rand(0,5)],
        ];
    }
}
