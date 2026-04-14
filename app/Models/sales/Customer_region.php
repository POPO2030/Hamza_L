<?php

namespace App\Models\sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Customer;
use App\Models\sales\Customer_shop;

class Customer_region extends Model
{
    use HasFactory;

    public $fillable = [
        'customer_id',
        'region_id',
    ];

    
    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }

    public function get_region()
    {
        return $this->belongsTo('App\Models\sales\Region','region_id');
    }

    public function get_shop()
    {
        return $this->belongsTo('App\Models\sales\Shop','region_id')->select('id','name','address','region_id');
    }

    public function get_customer_shop() /////////
    {
        return $this->hasMany(Customer_shop::class,'customer_region_id', 'id');
    }

}
