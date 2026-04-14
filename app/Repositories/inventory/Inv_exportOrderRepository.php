<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_exportOrder;
use App\Repositories\BaseRepository;

/**
 * Class Inv_exportOrderRepository
 * @package App\Repositories\inventory
 * @version August 3, 2023, 9:49 am UTC
*/

class Inv_exportOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serial',
        'date_out',
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
        return Inv_exportOrder::class;
    }
}
