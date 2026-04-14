<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Deliver_order;
use App\Repositories\BaseRepository;

/**
 * Class Deliver_orderRepository
 * @package App\Repositories\CRM
 * @version May 18, 2023, 10:21 am +03
*/

class Deliver_orderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'work_order_id',
        'product_id',
        'package_number',
        'count',
        'total',
        'receipt_id',
        'receive_id',
        'customer_id',
        'barcode',
        'status'
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
        return Deliver_order::class;
    }
}
