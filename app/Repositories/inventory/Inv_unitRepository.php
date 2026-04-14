<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_unit;
use App\Repositories\BaseRepository;

/**
 * Class Inv_unitRepository
 * @package App\Repositories\inventory
 * @version July 21, 2023, 10:59 am UTC
*/

class Inv_unitRepository extends BaseRepository
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
        return Inv_unit::class;
    }
}
