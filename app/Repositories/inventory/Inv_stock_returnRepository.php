<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_stock_return;
use App\Repositories\BaseRepository;

/**
 * Class Inv_stock_returnRepository
 * @package App\Repositories\inventory
 * @version August 23, 2023, 1:37 pm EET
*/

class Inv_stock_returnRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date_out',
        'comment',
        'customer_id',
        'supplier_id',
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
        return Inv_stock_return::class;
    }
}
