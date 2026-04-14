<?php

namespace Database\Factories;

use App\Models\CRM\Create_sample;
use Illuminate\Database\Eloquent\Factories\Factory;

class Create_sampleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Create_sample::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sample_id' => $this->faker->randomDigitNotNull,
        'stage_id' => $this->faker->randomDigitNotNull,
        'product_id' => $this->faker->randomDigitNotNull,
        'ratio' => $this->faker->word,
        'degree' => $this->faker->randomDigitNotNull,
        'water' => $this->faker->word,
        'time' => $this->faker->randomDigitNotNull,
        'ph' => $this->faker->word,
        'note' => $this->faker->word,
        'flag' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
