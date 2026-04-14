<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_StockTransfer
 * @package App\Models\inventory
 * @version July 7, 2023, 12:48 pm +03
 *
 * @property string $serial
 * @property integer $store_out
 * @property integer $store_in
 * @property string $comment
 * @property integer $user_id
 */
class Inv_StockTransfer extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv__stock_transfers';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        // 'serial',
        'store_out',
        'store_in',
        'comment',
        'status',
        'user_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'serial' => 'string',
        'store_out' => 'integer',
        'store_in' => 'integer',
        'comment' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'store_out' => 'required',
        'store_in' => 'required'
    ];

    public function get_product()
    {
        return $this->belongsTo(InvProduct::class,'product_id');
    }
    public function get_unit()
    {
        return $this->belongsTo(InvUnit::class,'unit_id');
    }
    public function get_store_in()
    {
        return $this->belongsTo(Inv_store::class,'store_in');
    }
    public function get_store_out()
    {
        return $this->belongsTo(Inv_store::class,'store_out');
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
