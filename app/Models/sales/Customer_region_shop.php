<?php

namespace App\Models\sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_region_shop extends Model
{
    use HasFactory;

    public $fillable = [
        'customer_id',
        'region_id',
        'shop_id',
    ];



}
