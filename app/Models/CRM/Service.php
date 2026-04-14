<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Service
 * @package App\Models\CRM
 * @version April 14, 2023, 9:54 pm UTC
 *
 * @property string $name
 * @property integer $service_category_id
 */
class Service extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'services';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'service_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'service_category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:services',
        'service_category_id' => 'required'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50',
        'service_category_id' => 'required'
    ];
    public function get_category()
    {
        return $this->belongsTo(ServiceCategory::class,'service_category_id');
    }
    
}
