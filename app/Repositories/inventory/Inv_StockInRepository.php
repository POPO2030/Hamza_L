<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_stockIn;
use App\Repositories\BaseRepository;

/**
 * Class Inv_stockInRepository
 * @package App\Repositories\inventory
 * @version July 21, 2023, 9:55 pm UTC
*/

class Inv_stockInRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serial',
        'date_in',
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
        return Inv_stockIn::class;
    }
}
