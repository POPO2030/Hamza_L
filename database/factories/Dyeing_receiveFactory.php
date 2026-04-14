<?php

namespace Database\Factories;

use App\Models\CRM\Dyeing_receive;
use Illuminate\Database\Eloquent\Factories\Factory;

class Dyeing_receiveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dyeing_receive::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->word,
        'customer_id' => $this->faker->randomDigitNotNull,
        'model' => $this->faker->word,
        'cloth_name' => $this->faker->word,
        'product_name' => $this->faker->word,
        'product_id' => $this->faker->randomDigitNotNull,
        'quantity' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
