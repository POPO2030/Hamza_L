<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Stage;
use App\Repositories\BaseRepository;

/**
 * Class StageRepository
 * @package App\Repositories\CRM
 * @version April 14, 2023, 9:59 pm UTC
*/

class StageRepository extends BaseRepository
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
        return Stage::class;
    }
}
