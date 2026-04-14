<?php

namespace App\Repositories\CRM;

use App\Models\CRM\satge_category;
use App\Repositories\BaseRepository;

/**
 * Class satge_categoryRepository
 * @package App\Repositories\CRM
 * @version July 20, 2023, 1:06 pm EET
*/

class satge_categoryRepository extends BaseRepository
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
        return satge_category::class;
    }
}
