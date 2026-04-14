<?php

namespace App\Repositories\accounting;

use App\Models\accounting\Payment_type;
use App\Repositories\BaseRepository;

/**
 * Class Payment_typeRepository
 * @package App\Repositories\accounting
 * @version July 8, 2024, 2:32 pm EEST
*/

class Payment_typeRepository extends BaseRepository
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
        return Payment_type::class;
    }
}
