<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Create_sample;
use App\Repositories\BaseRepository;

/**
 * Class Create_sampleRepository
 * @package App\Repositories\CRM
 * @version September 4, 2023, 11:23 am EET
*/

class Create_sampleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sample_id',
        'stage_id',
        'product_id',
        'ratio',
        'degree',
        'water',
        'time',
        'ph',
        'note',
        'flag'
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
        return Create_sample::class;
    }
}
