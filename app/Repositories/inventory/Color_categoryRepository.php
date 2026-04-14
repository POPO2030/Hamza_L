<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Color_category;
use App\Repositories\BaseRepository;

/**
 * Class Color_categoryRepository
 * @package App\Repositories\inventory
 * @version August 20, 2023, 11:28 am EET
*/

class Color_categoryRepository extends BaseRepository
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
        return Color_category::class;
    }
}
