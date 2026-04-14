<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Weight;
use App\Repositories\BaseRepository;

/**
 * Class WeightRepository
 * @package App\Repositories\inventory
 * @version August 19, 2023, 1:06 pm EET
*/

class WeightRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Weight::class;
    }
}
