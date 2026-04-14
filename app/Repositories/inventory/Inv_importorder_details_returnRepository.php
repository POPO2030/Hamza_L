<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_importorder_details_return;
use App\Repositories\BaseRepository;

/**
 * Class Inv_importorder_details_returnRepository
 * @package App\Repositories\inventory
 * @version August 22, 2023, 12:12 pm EET
*/

class Inv_importorder_details_returnRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'invimport_id',
        'product_id',
        'unit_id',
        'quantity',
        'store_id'
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
        return Inv_importorder_details_return::class;
    }
}
