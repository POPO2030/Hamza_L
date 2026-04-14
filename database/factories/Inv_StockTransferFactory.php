<?php

namespace Database\Factories;

use App\Models\inventory\Inv_StockTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

class Inv_StockTransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inv_StockTransfer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serial' => $this->faker->word,
        'store_out' => $this->faker->randomDigitNotNull,
        'store_in' => $this->faker->randomDigitNotNull,
        'comment' => $this->faker->text,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
