<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Model_name;

class Inv_controlStock extends Model
{
    use HasFactory;
    public $fillable = [
        'invimport_export_id',
        // 'customer_id',
        'product_id',  
        'supplier_id',  
        'unit_id',
        'quantity_out',  
        'quantity_in',  
        'store_id',
        'flag',
        'work_order_id',
        'created_at',
        'updated_at'
    ];


    public function get_product_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }
    public function get_unit()
    {
        return $this->belongsTo(Inv_unit::class,'unit_id');
    }
    public function get_store()
    {
        return $this->belongsTo(Inv_store::class,'store_id');
    }

    public function get_model()
    {
        return $this->belongsTo(Model_name::class,'model_id');
    }

    public function get_store_in()
    {
        return $this->belongsTo(Inv_store::class,'store_in');
    }
    public function get_store_out()
    {
        return $this->belongsTo(Inv_store::class,'store_out');
    }

    public function get_unit_content()
    {
        return $this->hasMany(Inv_ProductUnit::class,'product_id','product_id');
    }

    public function get_Inv_importOrder()
    {
        return $this->belongsTo(Inv_importOrder::class,'invimport_export_id');
    }
    
    public function get_Inv_exportOrder()
    {
        return $this->belongsTo(Inv_exportOrder::class,'invimport_export_id');
    }

    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }
}
