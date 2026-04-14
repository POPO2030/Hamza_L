<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_importOrder;
use App\Repositories\BaseRepository;

/**
 * Class Inv_importOrderRepository
 * @package App\Repositories\inventory
 * @version August 1, 2023, 9:13 pm UTC
*/

class Inv_importOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serial',
        'date_in',
        'comment',
        'user_id',
        'updated_by'
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
        return Inv_importOrder::class;
    }
}
