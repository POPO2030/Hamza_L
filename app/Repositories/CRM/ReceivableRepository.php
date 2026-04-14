<?php

namespace App\Repositories\CRM;

use App\Models\CRM\Receivable;
use App\Repositories\BaseRepository;

/**
 * Class ReceivableRepository
 * @package App\Repositories\CRM
 * @version May 4, 2023, 11:59 am UTC
*/

class ReceivableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone'
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
        return Receivable::class;
    }
}
