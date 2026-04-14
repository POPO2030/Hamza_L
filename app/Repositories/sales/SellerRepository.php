<?php

namespace App\Repositories\sales;

use App\Models\sales\Seller;
use App\Repositories\BaseRepository;

/**
 * Class SellerRepository
 * @package App\Repositories\sales
 * @version March 23, 2024, 1:50 pm EET
*/

class SellerRepository extends BaseRepository
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
        return Seller::class;
    }
}
