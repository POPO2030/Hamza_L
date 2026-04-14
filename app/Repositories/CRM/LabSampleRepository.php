<?php

namespace App\Repositories\CRM;

use App\Models\CRM\LabSample;
use App\Repositories\BaseRepository;

/**
 * Class LabSampleRepository
 * @package App\Repositories\CRM
 * @version August 13, 2023, 12:20 pm EET
*/

class LabSampleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'product_id',
        'serial',
        'count',
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
        return LabSample::class;
    }
}
