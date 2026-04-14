<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Size;
use App\Repositories\BaseRepository;

/**
 * Class SizeRepository
 * @package App\Repositories\inventory
 * @version August 19, 2023, 1:00 pm EET
*/

class SizeRepository extends BaseRepository
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
        return Size::class;
    }
}
