<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_StockTransfer;
use App\Repositories\BaseRepository;

/**
 * Class Inv_StockTransferRepository
 * @package App\Repositories\inventory
 * @version July 7, 2023, 12:48 pm +03
*/

class Inv_StockTransferRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serial',
        'store_out',
        'store_in',
        'comment',
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
        return Inv_StockTransfer::class;
    }
}
