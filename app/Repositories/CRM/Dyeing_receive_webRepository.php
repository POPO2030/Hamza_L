<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Dyeing_receive;
use App\Repositories\BaseRepository;

/**
 * Class Dyeing_receive_webRepository
 * @package App\Repositories\CRM
 * @version February 29, 2024, 10:48 am EET
*/

class Dyeing_receive_webRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'model',
        'product_id'
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
