<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_stock_return_details extends Model
{
    use HasFactory;
    public $table = 'inv_stock_return_details';

    public $fillable = [
        'invStockIn_id_return',
        'product_id',
        'item_serial',
        'height',
        'width',
        'type',
        'inv_stock_in_id',
        'store_id',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'created_at' => 'date:Y-m-d'
    ];
    public function product_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }
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

    public function get_invstock_in()
    {
        return $this->belongsTo(Inv_stockIn::class,'inv_stock_in_id');
    }
}
