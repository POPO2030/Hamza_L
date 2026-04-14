<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_store;
use App\Repositories\BaseRepository;

/**
 * Class Inv_storeRepository
 * @package App\Repositories\inventory
 * @version July 21, 2023, 10:05 am UTC
*/

class Inv_storeRepository extends BaseRepository
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
        return Inv_store::class;
    }
}
