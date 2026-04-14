<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Fabric;
use App\Repositories\BaseRepository;

/**
 * Class FabricRepository
 * @package App\Repositories\CRM
 * @version April 27, 2024, 9:51 am EET
*/

class FabricRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'fabric_source_id'
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
        return Fabric::class;
    }
}
