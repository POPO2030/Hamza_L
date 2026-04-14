<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Fabric_source;
use App\Repositories\BaseRepository;

/**
 * Class Fabric_sourceRepository
 * @package App\Repositories\CRM
 * @version April 27, 2024, 9:36 am EET
*/

class Fabric_sourceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return Fabric_source::class;
    }
}
