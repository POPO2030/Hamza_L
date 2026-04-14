<?php

namespace App\Repositories\CRM;

use App\Models\CRM\WorkOrder;
use App\Repositories\BaseRepository;

/**
 * Class WorkOrderRepository
 * @package App\Repositories\CRM
 * @version April 20, 2023, 11:48 pm UTC
*/

class WorkOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'creator_id',
        'creator_team_id',
        'closed_by_id',
        'closed_team_id',
        'status',
        'customer_id',
        'receive_receipt_id',
        'product_id',
        'product_count'
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
        return WorkOrder::class;
    }
}
