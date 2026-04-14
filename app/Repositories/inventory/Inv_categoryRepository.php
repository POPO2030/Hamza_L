<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_category;
use App\Repositories\BaseRepository;

/**
 * Class Inv_categoryRepository
 * @package App\Repositories\inventory
 * @version July 21, 2023, 10:11 am UTC
*/

class Inv_categoryRepository extends BaseRepository
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
        return Inv_category::class;
    }
}
