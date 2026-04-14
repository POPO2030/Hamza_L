<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_stockOut;
use App\Repositories\BaseRepository;

/**
 * Class Inv_stockOutRepository
 * @package App\Repositories\inventory
 * @version July 23, 2023, 12:22 pm UTC
*/

class Inv_stockOutRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serial',
        'date_out',
        'comment',
        'customer_id',
        'user_id'
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
        return Inv_stockOut::class;
    }
}
