<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_exportOrder_details extends Model
{
    use HasFactory;
    public $fillable = [
        'inv_export_id',
        'supplier_id',
        'product_id',
        'supplier_id',
        'unit_id',
        'quantity',
        'required_quantity',
        'store_id',
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

    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

    public function get_color()
    {
        return $this->belongsTo(Color::class,'product_color');
    }
    public function product_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }

    public function get_control_stock()
    {
        return $this->hasMany(Inv_controlStock::class, 'invimport_export_id', 'inv_export_id')
        ->where('flag', 2);
    }
    
    public function product_supplier()
    {
        // return $this->hasMany(Inv_controlStock::class,'product_id','product_id')
        // ->where('flag', 1)->whereColumn('supplier_id', 'supplier_id')->distinct();
        return $this->hasMany(Inv_controlStock::class,'product_id','product_id')->where('flag', 1)->orWhere('flag', 5)->distinct();
   
    }

}
