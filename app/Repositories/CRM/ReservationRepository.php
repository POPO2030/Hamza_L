<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Reservation;
use App\Repositories\BaseRepository;

/**
 * Class ReservationRepository
 * @package App\Repositories\CRM
 * @version May 20, 2023, 3:55 pm +03
*/

class ReservationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'product_id',
        'product_count',
        'reservation_date',
        'status'
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
        return Reservation::class;
    }
}
