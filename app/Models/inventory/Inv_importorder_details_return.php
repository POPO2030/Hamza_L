<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_importorder_details_return
 * @package App\Models\inventory
 * @version August 22, 2023, 12:12 pm EET
 *
 * @property integer $invimport_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $quantity
 * @property integer $store_id
 */
class Inv_importorder_details_return extends Model
{

    use HasFactory;

    public $table = 'inv_importorder_details_returns';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'invimport_id_return',
        'product_id',
        'unit_id',
        'quantity',
        'store_id',
        'invimport_id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'invimport_id' => 'integer',
        'product_id' => 'integer',
        'unit_id' => 'integer',
        'quantity' => 'integer',
        'store_id' => 'integer',
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
 
    public function get_product()
    {
        return $this->belongsTo(Inv_product::class,'product_id');
    }
    public function get_unit()
    {
        return $this->belongsTo(Inv_unit::class,'unit_id');
    }
    public function get_store()
    {
        return $this->belongsTo(Inv_store::class,'store_id');
    }
    
    public function product_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }

    public function get_return()
    {
        return $this->hasMany(Inv_importorder_details::class,'invimport_id','invimport_id');
    }
    
}
