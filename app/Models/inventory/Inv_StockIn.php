<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_stockIn
 * @package App\Models\inventory
 * @version July 21, 2023, 9:55 pm UTC
 *
 * @property string $serial
 * @property string $date_in
 * @property string $comment
 * @property integer $customer_id
 * @property integer $user_id
 */
class Inv_stockIn extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_stock_ins';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'date_in',
        'comment',
        'customer_id',
        'supplier_id',
        'user_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_in' => 'date:Y-m-d',
        'comment' => 'string',
        'customer_id' => 'integer',
        'supplier_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date_in' => 'required',
        'customer_id' => 'required',
        'supplier_id' => 'required',
    ];
    

    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }
    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

       public function get_inv_stockIndetails()
    {
        return $this->hasMany('App\Models\inventory\Inv_stockInDetails','invStockIn_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }


    
}
