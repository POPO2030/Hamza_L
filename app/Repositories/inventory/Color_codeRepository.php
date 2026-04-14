<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Color_code;
use App\Repositories\BaseRepository;

/**
 * Class Color_codeRepository
 * @package App\Repositories\inventory
 * @version April 2, 2024, 8:04 am EET
*/

class Color_codeRepository extends BaseRepository
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
        return Color_code::class;
    }
}
