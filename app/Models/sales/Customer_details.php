<?php

namespace App\Models\sales;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Customer_details extends Model
{
    use HasFactory;
    use SoftDeletes;


    public $table = 'customer_details';

    public $fillable = [
        'customer_id',
        'invoice_id',
        'work_order_id',
        'treasury_details_id',
        'cash_balance_credit',
        'cash_balance_debit',
        'payment_type_id',
        'bank_id',
        'bank_details_id',
        'note',
        'flag',
        'creator_id',
        'date',

    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_treasury_details()
    {
        return $this->belongsTo('App\Models\sales\Treasury_details','treasury_details_id');
    }
    
    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }

    public function get_payment_type()
    {
        return $this->belongsTo('App\Models\accounting\Payment_type','payment_type_id');
    }
    public function get_workOrder()
    {
        return $this->belongsTo('App\Models\CRM\WorkOrder','work_order_id');
        
    }

    public function get_invoice_details()
    {
        return $this->hasMany('App\Models\accounting\Invoice_details','invoice_id','invoice_id');
    }

    public function get_invoice()
    {
        return $this->belongsTo('App\Models\accounting\Invoice','invoice_id');
    }

}
