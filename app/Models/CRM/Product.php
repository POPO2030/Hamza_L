<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Product
 * @package App\Models\CRM
 * @version April 14, 2023, 9:49 pm UTC
 *
 * @property string $name
 * @property integer $category_id
 */
class Product extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'products';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:products',
        'category_id' => 'required'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50',
        'category_id' => 'required'
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class,'category_id');
    }
}
