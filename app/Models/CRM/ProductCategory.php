<?php

namespace App\Models\CRM;


use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ProductCategory
 * @package App\Models\CRM
 * @version April 14, 2023, 9:47 pm UTC
 *
 * @property string $name
 */
class ProductCategory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'product_categories';
    

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
        'name' => 'required|min:2|max:50|unique:product_categories'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    
}
