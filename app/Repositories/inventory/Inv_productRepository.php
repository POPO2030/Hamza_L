<?php

namespace App\Repositories\inventory;

use App\Models\inventory\Inv_product;
use App\Repositories\BaseRepository;

/**
 * Class Inv_productRepository
 * @package App\Repositories\inventory
 * @version July 21, 2023, 10:19 am UTC
*/

class Inv_productRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'category_id',
        'product_request'
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
        return Inv_product::class;
    }
}
