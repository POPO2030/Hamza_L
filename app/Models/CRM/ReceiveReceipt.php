<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Class ReceiveReceipt
 * @package App\Models\CRM
 * @version April 14, 2023, 11:00 pm UTC
 *
 * @property string $model
 * @property string $brand
 * @property string $img
 * @property number $initial_weight
 * @property number $initial_count
 * @property number $final_weight
 * @property number $final_count
 * @property integer $product_id
 */
class ReceiveReceipt extends Model
{
    use SoftDeletes;

    use HasFactory;
    use LogsActivity;

    public $table = 'receive_receipts';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'model',
        'brand',
        'branch',
        'img',
        'initial_weight',
        'initial_count',
        'final_weight',
        'final_count',
        'product_id',
        'product_type',
        'customer_id',
        'status',
        'is_workOreder',
        'receivable_id',
        'creator_id',
        'updated_by',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'model' => 'string',
        'brand' => 'string',
        'img' => 'string',
        'initial_weight' => 'double',
        'initial_count' => 'double',
        'final_weight' => 'double',
        'final_count' => 'double',
        'product_id' => 'integer',
        // 'created_at' => 'date:Y-m-d H:i:s',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'model' => 'min:2|max:50',
 
  
    ];
    public static $rules_update = [
        // 'model' => 'min:2|max:50',
        // 'brand' => 'required|min:2|max:50'
    ];

    
    public function get_product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function work_order()
    {
        return $this->hasMany(WorkOrder::class,'receive_receipt_id');
    }

    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function get_receivables()
    {
        return $this->belongsTo(Receivable::class,'receivable_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function get_work_order()
    {
        return $this->hasMany(WorkOrder::class,'receive_receipt_id')->where('status','open');
    }

    public function get_work_orders_for_deliver_for_details()
    {
        return $this->hasMany(WorkOrder::class, 'receive_receipt_id')
                    ->select('receive_receipt_id', 'work_orders.id', 'work_orders.status', 'work_orders.product_count', 'work_orders.product_weight')
                    ->leftJoin('deliver_orders', 'work_orders.id', '=', 'deliver_orders.work_order_id')
                    ->leftJoin('deliver_order_details', 'deliver_orders.id', '=', 'deliver_order_details.deliver_order_id')
                    ->selectRaw('SUM(deliver_order_details.total) as total_sum')
                    ->groupBy('work_orders.id', 'receive_receipt_id', 'work_orders.status', 'work_orders.product_count', 'work_orders.product_weight');

    }

}
