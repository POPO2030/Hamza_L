<?php

namespace Database\Factories;

use App\Models\CRM\Dyeing_receive_web;
use Illuminate\Database\Eloquent\Factories\Factory;

class Dyeing_receive_webFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dyeing_receive_web::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => $this->faker->word,
        'model' => $this->faker->word,
        'product_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
