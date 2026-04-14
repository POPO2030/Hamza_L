<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class invImportOrders_returns
 * @package App\Models\inventory
 * @version August 22, 2023, 11:40 am EET
 *
 * @property string $date_out
 * @property string $comment
 * @property integer $customer_id
 * @property integer $supplier_id
 * @property integer $user_id
 * @property integer $updated_by
 */
class invImportOrders_returns extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_import_orders_returns';
    

    protected $dates = ['deleted_at'];

    public $fillable = [
        'invimport_id_return',            //id= الاب المرتجع
        'date_out',
        'comment',
        'product_category_id',
        'supplier_id',
        'user_id',
        'updated_by',
        'invimport_id'                  // id = اذن الاستلام
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_out'  => 'date:Y-m-d',
        'comment' => 'string',
        'customer_id' => 'integer',
        'supplier_id' => 'integer',
        'user_id' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'date_out' => 'required',
        // 'customer_id' => 'required',
        // 'supplier_id' => 'required',
        // 'updated_by' => 'exit'
    ];
    public function get_customer()
    {
        return $this->belongsTo('App\Models\CRM\Customer','customer_id');
    }
    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }

    public function invproduct_category()
    {
        return $this->belongsTo(Inv_category::class,'product_category_id');
    }

    public function get_details() 
    {
        return $this->hasMany(Inv_importorder_details_return::class,'invimport_id_return');
    }
}
