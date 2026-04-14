<?php

namespace App\Repositories\CRM;

use App\Models\CRM\ReceiveReceipt;
use App\Repositories\BaseRepository;

/**
 * Class ReceiveReceiptRepository
 * @package App\Repositories\CRM
 * @version April 14, 2023, 11:00 pm UTC
*/

class ReceiveReceiptRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'model',
        'brand',
        'img',
        'initial_weight',
        'initial_count',
        'final_weight',
        'final_count',
        'product_id'
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
        return ReceiveReceipt::class;
    }
}
