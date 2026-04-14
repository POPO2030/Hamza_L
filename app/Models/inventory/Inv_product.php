<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;
/**
 * Class Inv_product
 * @package App\Models\inventory
 * @version July 21, 2023, 10:19 am UTC
 *
 * @property string $name
 * @property integer $category_id
 * @property integer $product_request
 */
class Inv_product extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_products';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'system_code',
        'manual_code',
        'product_price',
        'category_id',
        'description_id',
        'product_request',
        'brand_id',
        'size_id',
        'weight_id',
        'final_product_id',
        'creator_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'category_id' => 'integer',
        'product_request' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'name' => 'required|min:2|max:200|unique:inv_products',
        'category_id' => 'required'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:200',
        'category_id' => 'required'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        // return $date->format('Y-m-d H:i:s');
        return $date->format('Y-m-d');
    }

    public function invproduct_category()
    {
        return $this->belongsTo(Inv_category::class,'category_id');
    }

    public function get_size()
    {
        return $this->belongsTo(Size::class,'size_id');
    }
    public function get_weight()
    {
        return $this->belongsTo(Weight::class,'weight_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }

    public function product_color()
    {
        return $this->belongsTomany(Color::class,'product_colors','product_id');
    }
    public function get_units()
    {
        return $this->belongsTomany(Inv_unit::class,'inv__product_units','product_id','unit_id')
        ->withPivot('product_id', 'unit_id','unitcontent');
        
    }
    public function get_inv_product_unit()
    {
        return $this->hasMany(Inv_ProductUnit::class,'product_id');
    }

    public function get_brands()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }
    // public function get_images()
    // {
    //     return $this->belongsToMany(image::class,  'product_colors', 'product_id', 'color_id');
        

    // }
    public function get_product_color()
    {
        return $this->hasOne(product_color::class, 'id');
    }

    public function get_product_description()
    {
        return $this->belongsTo(Inv_productd_description::class,'description_id');
    }
    public function get_finalproduct()
    {
        return $this->belongsTo('App\Models\inventory\final_product','final_product_id');
    }

}
