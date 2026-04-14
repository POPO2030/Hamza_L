<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_productd_description;
use App\Repositories\BaseRepository;

/**
 * Class Inv_productd_descriptionRepository
 * @package App\Repositories\inventory
 * @version November 15, 2023, 10:51 am EET
*/

class Inv_productd_descriptionRepository extends BaseRepository
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
        return Inv_productd_description::class;
    }
}
