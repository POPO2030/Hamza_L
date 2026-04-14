<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_stockOutDetails extends Model
{
    use HasFactory;
    public $fillable = [
        'product_id',
        'supplier_id',
        'height',
        'width',
        'item_serial',
        'type',
        'store_id',
         'stock_control_id',
        'invStockOut_id',
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

    public function get_control_stock()
    {
        return $this->hasMany(Inv_stockControl::class, 'invStock_id' ,'invStockOut_id');
    }


    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

    public function get_stock_out()
    {
        return $this->belongsTo(Inv_stockOut::class,'invStockOut_id');
    }


}
