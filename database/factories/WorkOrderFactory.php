<?php

namespace Database\Factories;

use App\Models\CRM\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'creator_id' => $this->faker->randomDigitNotNull,
        'creator_team_id' => $this->faker->randomDigitNotNull,
        'closed_by_id' => $this->faker->randomDigitNotNull,
        'closed_team_id' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->word,
        'customer_id' => $this->faker->randomDigitNotNull,
        'receive_receipt_id' => $this->faker->randomDigitNotNull,
        'product_id' => $this->faker->randomDigitNotNull,
        'product_count' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
