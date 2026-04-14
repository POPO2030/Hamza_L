<?php

namespace App\Models\sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_shop extends Model
{
    use HasFactory;
    public $fillable = [
        'customer_region_id',
        'shop_id',
    ];

    public function get_shop()
    {
        return $this->belongsTo('App\Models\sales\Shop','shop_id')->select('id','name','address','region_id');
    }
}
