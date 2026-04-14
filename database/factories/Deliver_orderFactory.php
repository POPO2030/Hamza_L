<?php

namespace Database\Factories;

use App\Models\CRM\Deliver_order;
use Illuminate\Database\Eloquent\Factories\Factory;

class Deliver_orderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deliver_order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'work_order_id' => $this->faker->randomDigitNotNull,
        'product_id' => $this->faker->randomDigitNotNull,
        'package_number' => $this->faker->randomDigitNotNull,
        'count' => $this->faker->randomDigitNotNull,
        'total' => $this->faker->randomDigitNotNull,
        'receipt_id' => $this->faker->randomDigitNotNull,
        'receive_id' => $this->faker->randomDigitNotNull,
        'customer_id' => $this->faker->randomDigitNotNull,
        'barcode' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
