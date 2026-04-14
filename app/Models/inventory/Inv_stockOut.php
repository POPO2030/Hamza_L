<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CRM\Model_name;

/**
 * Class Inv_stockOut
 * @package App\Models\inventory
 * @version July 23, 2023, 12:22 pm UTC
 *
 * @property string $serial
 * @property string $date_out
 * @property string $comment
 * @property integer $customer_id
 * @property integer $user_id
 */
class Inv_stockOut extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_stock_outs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'date_out',
        'comment',
        'customer_id',
        'user_id',
        'updated_by',
        'model_name_id',
        'cloth_request_id',
        'spend_to'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'serial' => 'string',
        'date_out' => 'date:Y-m-d',
        'comment' => 'string',
        'customer_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date_out' => 'required',
        'customer_id' => 'required'
    ];

    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }

    public function get_spendto()
    {
        return $this->belongsTo('App\Models\CRM\Customer','spend_to', 'id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }
    public function get_model_name()
    {
        return $this->belongsTo(Model_name::class,'model_name_id');
    }

    ####################################################
    public function get_store()
    {
        return $this->belongsTo(Inv_store::class,'store_id');
    }

    public function get_inv_stockin()
    {
        return $this->belongsTo('App\Models\inventory\Inv_stockIn','invStock_id');
    }
    public function get_product()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }

    public function get_stock_out_details()
    {
        return $this->hasMany(Inv_stockOutDetails::class,'invStockOut_id','id');
    }

    public function get_control_stock_to()
    {
        return $this->hasMany(Inv_stockOutDetails::class,'invStockOut_id','invStock_id');
    }
}
