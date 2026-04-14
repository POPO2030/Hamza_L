<?php

namespace App\Repositories\CRM;

use App\Models\CRM\suppliers;
use App\Repositories\BaseRepository;

/**
 * Class suppliersRepository
 * @package App\Repositories\CRM
 * @version August 8, 2023, 4:13 pm UTC
*/

class suppliersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone'
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
        return suppliers::class;
    }
}
