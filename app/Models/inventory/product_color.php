<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_color extends Model
{
    use HasFactory;
    public $fillable = [
        'product_id',
        'color_id',
    ];

    public function get_product()
    {
        return $this->belongsTo('App\Models\inventory\Inv_product','product_id');
    }

    public function get_cloth_name()
    {
        return $this->belongsTo('App\Models\inventory\Inv_product','id');
    }

    public function get_color()
    {
        return $this->belongsTo('App\Models\inventory\Color','color_id');
    }

    public function get_color_categories()
    {
        return $this->belongsTo('App\Models\inventory\Color_category','color_id');
    }
    
    public function get_color_code()
    {
        return $this->belongsTo('App\Models\inventory\Color_code','color_id');
    }

    public function get_unit()
    {
        return $this->belongsTo('App\Models\inventory\Inv_ProductUnit','product_id');
    }
    public function get_all_unit()
    {
        return $this->hasMany('App\Models\inventory\Inv_ProductUnit','product_id','product_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\inventory\image', 'product_colors_id', 'id');
    }


    public function get_image()
    {
        return $this->hasOne(image::class, 'product_colors_id', 'id');
    }


    public function get_Inv_importOrder_details()
    {
        return $this->hasMany('App\Models\inventory\Inv_importorder_details', 'product_id','id');
    }
}
