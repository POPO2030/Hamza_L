<?php

namespace App\Repositories\inventory;

use App\Models\inventory\final_product;
use App\Repositories\BaseRepository;

/**
 * Class final_productRepository
 * @package App\Repositories\inventory
 * @version August 17, 2023, 1:56 pm EET
*/

class final_productRepository extends BaseRepository
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
        return final_product::class;
    }
}
