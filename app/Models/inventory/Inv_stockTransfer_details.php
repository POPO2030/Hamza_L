<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Inv_stockTransfer_details extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'inv_stock_transfer_details';
    
    protected $dates = ['deleted_at'];


    public $fillable = [
        'inv_stock_transfer_id',
        'product_id',
        'unit_id',
        'quantity',
        'supplier_id',
        'store_id',
    ];

    public function get_product_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }

    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }
}
