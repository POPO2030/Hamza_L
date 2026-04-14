<?php

namespace App\Models\sales;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_details extends Model
{
    use HasFactory;
    // use SoftDeletes;


    public $table = 'supplier_details';

    public $fillable = [
        'supplier_id',
        'treasury_details_id',
        'cash_balance_credit',
        'cash_balance_debit',
        'payment_type_id',
        'bank_id',
        'bank_details_id',
        'note',
        'flag',
        'creator_id',
        'invimport_id'
    ];

    public function get_treasury_details()
    {
        return $this->belongsTo('App\Models\sales\Treasury_details','treasury_details_id');
    }

    public function get_payment_type()
    {
        return $this->belongsTo('App\Models\accounting\Payment_type','payment_type_id');
    }

}
