<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Dyeing_receive;
use App\Repositories\BaseRepository;

/**
 * Class Dyeing_receiveRepository
 * @package App\Repositories\CRM
 * @version February 22, 2024, 2:47 pm EET
*/

class Dyeing_receiveRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_name',
        'customer_id',
        'model',
        'cloth_name',
        'product_name',
        'product_id',
        'quantity'
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
        return Dyeing_receive::class;
    }
}
