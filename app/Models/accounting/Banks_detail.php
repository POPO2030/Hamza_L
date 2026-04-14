<?php

namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Banks_detail extends Model
{
    use HasFactory;

    public $table = 'banks_details';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'bank_id',
        'customer_id',
        'supplier_id',
        'date_in',
        'date_entitlment',
        'check_no',
        'deposit',
        'spend',
        'img',
        'status',
        'updated_by',
        'creator_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bank_id'=> 'integer',
        'customer_id'=> 'integer',
        'supplier_id'=> 'integer',
        // 'date_in'=> 'date',
        // 'date_entitlment'=> 'date',
        'check_no'=> 'string',
        'deposit'=> 'double',
        'spend'=> 'double',
        'img'=> 'string',
        'status'=> 'string',
     
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }

    public function get_bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }

    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

}
