<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_stock_return
 * @package App\Models\inventory
 * @version August 23, 2023, 1:37 pm EET
 *
 * @property string $date_out
 * @property string $comment
 * @property integer $customer_id
 * @property integer $supplier_id
 * @property integer $user_id
 * @property integer $updated_by
 */
class Inv_stock_return extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_stock_returns';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'date_out',
        'comment',
        'customer_id',
        'supplier_id',
        'user_id',
        'inv_stock_in_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_out' => 'date:Y-m-d',
        'comment' => 'string',
        'customer_id' => 'integer',
        'supplier_id' => 'integer',
        'user_id' => 'integer',
        'user_id' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'date_out' => 'required'
    ];

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }


    public function get_stock_return_details()
    {
        return $this->hasMany(Inv_stock_return_details::class,'invStockIn_id_return','id');
    }
    public function get_inv_stock_in_details()
    {
        return $this->hasMany('App\Models\inventory\Inv_stockInDetails','invStockIn_id','inv_stock_in_id');
    }
}
