<?php

namespace App\Models\accounting;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

/**
 * Class Invoice
 * @package App\Models\accounting
 * @version January 23, 2025, 8:54 am EET
 *
 * @property integer $customer_id
 * @property double $amount_original
 * @property double $amount_edit
 * @property double $amount_net
 * @property integer $creator_id
 */
class Invoice extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'invoices';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer_id',
        'calculation_method',
        'amount_original',
        'amount_minus',
        // 'amount_Increase',
        'tax',
        'discount_notice',
        // 'branch',
        'amount_net',
        'comment',
        'creator_id',
        'date',
        'season',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'amount_original' => 'double',
        'amount_minus' => 'double',
        // 'amount_Increase' => 'double',
        'tax' => 'double',
        'discount_notice' => 'double',
        // 'branch' => 'integer',
        'amount_net' => 'double',
        'comment' => 'string',
        'creator_id' => 'integer',
        'date' => 'date',
    ];

    // public function getBranchNameAttribute()
    // {
    //     return $this->branch == 1 ? 'جسر السويس' : ($this->branch == 2 ? 'بلقس' : 'غير معروف');
    // }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }
    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }

    public function get_invoice_details()
    {
        return $this->hasMany('App\Models\accounting\Invoice_details','invoice_id');
    }

    public function get_invoice_services()
    {
        return $this->hasMany('App\Models\accounting\Invoice_service_prices','invoice_id');
    }


    public static $rules = [
        
    ];

    
}
