<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Place;
use App\Repositories\BaseRepository;

/**
 * Class PlaceRepository
 * @package App\Repositories\CRM
 * @version May 4, 2023, 11:11 am UTC
*/

class PlaceRepository extends BaseRepository
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
        return Place::class;
    }
}
