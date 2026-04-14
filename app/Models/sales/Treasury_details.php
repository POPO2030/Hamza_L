<?php

namespace App\Models\sales;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

class Treasury_details extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'treasury_details';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'treasury_id',
        'treasury_journal',
        'credit',
        'debit',
        'date',
        'payment_type_id',
        'details',
        'bank_id',
        'creator_id',
        'updated_by',
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'treasury_id' => 'integer',
        'treasury_journal' => 'string',
        'credit' => 'string',
        'debit' => 'string',
        'details' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];



    public function get_treasury()
    {
        return $this->belongsTo('App\Models\sales\Treasury','treasury_id');
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function get_payment_type()
    {
        return $this->belongsTo('App\Models\accounting\Payment_type','payment_type_id');
    }

    public function get_customer_details()
    {
        return $this->belongsTo('App\Models\sales\Customer_details','id','treasury_details_id');
    }
    public function get_banks()
    {
        return $this->belongsTo('App\Models\accounting\Bank','bank_id');
    }
}
