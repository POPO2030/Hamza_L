<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliver_order_details extends Model
{
    use HasFactory;

    public $fillable = [
        'deliver_order_id',
        'package_number',
        'count',
        'total',
        'weight',
        'barcode',
        'creator_id',
        'updated_by',
        'delivered_package'

    ];

    public function get_order()
    {
        return $this->belongsTo(Deliver_order::class,'deliver_order_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }

}
