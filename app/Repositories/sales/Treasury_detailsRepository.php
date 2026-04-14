<?php

namespace App\Repositories\sales;

use App\Models\sales\Treasury_details;
use App\Repositories\BaseRepository;

/**
 * Class Treasury_detailsRepository
 * @package App\Repositories\sales
 * @version March 20, 2024, 1:29 pm EET
*/

class Treasury_detailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'treasury_id',
        'treasury_journal',
        'credit',
        'credit_details',
        'debit',
        'debit_details'
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
        return Treasury_details::class;
    }
}
