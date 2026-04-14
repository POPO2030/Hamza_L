<?php

namespace App\Repositories\CRM;

use App\Models\CRM\ServiceItem;
use App\Repositories\BaseRepository;

/**
 * Class ServiceItemRepository
 * @package App\Repositories\CRM
 * @version April 14, 2023, 9:56 pm UTC
*/

class ServiceItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'service_id'
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
        return ServiceItem::class;
    }
}
