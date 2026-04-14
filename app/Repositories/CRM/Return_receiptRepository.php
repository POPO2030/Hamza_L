<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Return_receipt;
use App\Repositories\BaseRepository;

/**
 * Class Return_receiptRepository
 * @package App\Repositories\CRM
 * @version July 16, 2023, 11:20 am +03
*/

class Return_receiptRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'model',
        'brand',
        'img',
        'initial_count',
        'final_weight',
        'final_count',
        'product_id',
        'customer_id',
        'receivable_id',
        'workOrder_id',
        'note'
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
        return Return_receipt::class;
    }
}
