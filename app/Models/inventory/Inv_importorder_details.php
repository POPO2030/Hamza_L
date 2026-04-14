<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_importorder_details extends Model
{
    use HasFactory;

    public $fillable = [
        'invimport_id',
        'product_id',
        'unit_id',
        'quantity',
        'store_id',
        'product_price',
        'total_product_price',
        // 'final_product_size_id',
        'created_at',
        'updated_at'
    ];

    

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

    public function get_size_finalproducts()
    {
        return $this->belongsTo('App\Models\CRM\Size_finalproduct','final_product_size_id');
    }

    public function get_return()
    {
        return $this->hasMany(Inv_importorder_details_return::class,'invimport_id','invimport_id');
    }

}
