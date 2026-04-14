<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_stockInDetails extends Model
{
    use HasFactory;
    public $fillable = [
        'invStockIn_id',
        'product_id',
        'quantity',
        'total_lengths',
        'store_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d'
    ];

    public function get_store()
    {
        return $this->belongsTo(Inv_store::class,'store_id');
    }
    public function get_product()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }
    public function get_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }
    
    public function get_Inv_stockOutDetails()
    {
        return $this->belongsTo(Inv_stockOutDetails::class,'product_id');
    }

    public function get_invstock_in()
    {
        return $this->belongsTo(Inv_stockIn::class,'invStockIn_id');
    }

    // public function get_inv_stockControl()
    // {
    //     return $this->hasMany('App\Models\inventory\Inv_stockControl','product_id','product_id');
    //     // ->whereColumn('product_id', 'product_id');
    // }
}
