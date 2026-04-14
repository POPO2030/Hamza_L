<?php

namespace App\Repositories\accounting;

use App\Models\accounting\Accounting_cost;
use App\Repositories\BaseRepository;

/**
 * Class Accounting_costRepository
 * @package App\Repositories\accounting
 * @version July 2, 2024, 2:32 pm EEST
*/

class Accounting_costRepository extends BaseRepository
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
        return Accounting_cost::class;
    }
}
