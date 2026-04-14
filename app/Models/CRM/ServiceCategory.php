<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ServiceCategory
 * @package App\Models\CRM
 * @version April 14, 2023, 9:51 pm UTC
 *
 * @property string $name
 */
class ServiceCategory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'service_categories';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:service_categories'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    
}
