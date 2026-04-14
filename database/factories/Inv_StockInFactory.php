<?php

namespace Database\Factories;

use App\Models\inventory\Inv_StockIn;
use Illuminate\Database\Eloquent\Factories\Factory;

class Inv_StockInFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inv_StockIn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serial' => $this->faker->word,
        'date_in' => $this->faker->word,
        'comment' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
