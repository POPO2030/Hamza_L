<?php

namespace App\Repositories\sales;

use App\Models\sales\Treasury;
use App\Repositories\BaseRepository;

/**
 * Class TreasuryRepository
 * @package App\Repositories\sales
 * @version March 20, 2024, 1:01 pm EET
*/

class TreasuryRepository extends BaseRepository
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
        return Treasury::class;
    }
}
