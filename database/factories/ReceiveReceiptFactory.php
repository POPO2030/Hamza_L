<?php

namespace Database\Factories;

use App\Models\CRM\ReceiveReceipt;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiveReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReceiveReceipt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => $this->faker->word,
        'brand' => $this->faker->word,
        'img' => $this->faker->word,
        'initial_weight' => $this->faker->word,
        'initial_count' => $this->faker->word,
        'final_weight' => $this->faker->word,
        'final_count' => $this->faker->word,
        'product_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
