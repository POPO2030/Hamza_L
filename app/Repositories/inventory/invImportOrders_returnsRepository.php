<?php

namespace App\Repositories\inventory;

use App\Models\inventory\invImportOrders_returns;
use App\Repositories\BaseRepository;

/**
 * Class invImportOrders_returnsRepository
 * @package App\Repositories\inventory
 * @version August 22, 2023, 11:40 am EET
*/

class invImportOrders_returnsRepository extends BaseRepository
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
        return invImportOrders_returns::class;
    }
}
