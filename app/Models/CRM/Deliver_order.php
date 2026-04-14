<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

/**
 * Class Deliver_order
 * @package App\Models\CRM
 * @version May 18, 2023, 10:21 am +03
 *
 * @property integer $work_order_id
 * @property integer $product_id
 * @property integer $package_number
 * @property integer $count
 * @property integer $total
 * @property integer $receipt_id
 * @property integer $receive_id
 * @property integer $customer_id
 * @property string $barcode
 */
class Deliver_order extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'deliver_orders';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'work_order_id',
        'product_id',
        'product_type',
        'receipt_id',
        'receive_id',
        'customer_id',
        'status'
    ];

    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'work_order_id' => 'integer',
        'product_id' => 'integer',
        'receipt_id' => 'integer',
        'receive_id' => 'integer',
        'customer_id' => 'integer',
        // 'created_at' => 'date:Y-m-d H:i:s',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'work_order_id' => 'required',
        'product_id' => 'required',
        'receipt_id' => 'required',
        'receive_id' => 'required',
        'customer_id' => 'required',

    ];

    public function get_details()
    {
        return $this->hasMany(Deliver_order_details::class,'deliver_order_id');
    }
    public function get_final_deliver()
    {
        return $this->hasMany(FinalDeliver::class,'deliver_order_id');
    }
    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function get_products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function get_receivable()
    {
        return $this->belongsTo(Receivable::class,'receive_id');
    }
    public function get_count_product()
    {
        return $this->belongsTo(WorkOrder::class,'work_order_id');
    }

// -------------------------------------التغليف صباحا ومساءا-------------------------------------------
    public function get_details_dashboard()
    {
        return $this->hasMany(Deliver_order_details::class,'deliver_order_id')
        ->select('id','deliver_order_id','total')
        ;
    }
//   ----------------------------------------------------------------------------------------------------  
    public function get_final_deliver_dashboard()
    {
        return $this->hasMany(FinalDeliver::class,'deliver_order_id')
        ->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 07:00:00')
        ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 19:00:00')
        ->select('id','deliver_order_id','total')
        ;
    }
    
    public function get_final_deliver_dashboard_night()
    {
        return $this->hasMany(FinalDeliver::class,'deliver_order_id')
        ->where(function($query) {
            $query->where('created_at', '>=', date("Y-m-d", strtotime("-1 day")).' 19:01:00')
            ->where('created_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
            })
            ->orWhere(function($query) {
            $query->where('created_at', '>=', date("Y-m-d").' 00:00:00')
            ->where('created_at', '<=', date("Y-m-d").' 06:59:59');
            })
        ->select('id','deliver_order_id','total')
        ;
    }

    public function get_work_order_stage()
    {
        return $this->hasMany(Work_order_stage::class,'work_order_id','work_order_id');
    }

    public function get_work_order()
    {
        return $this->belongsTo(WorkOrder::class,'work_order_id')->select('id','product_count','receive_receipt_id');
    }

    public function get_receive_receipt()
    {
        return $this->belongsTo(ReceiveReceipt::class,'receipt_id');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_final_deliver_report()
    {
        return $this->hasOne(FinalDeliver::class,'deliver_order_id')
        ->select(\DB::raw('id,deliver_order_id,final_deliver_order_id,receivable_id,flag_inovice,sum(package_number) as sum_package_number,sum(total) as sum_total,created_at'))
        ->groupBy('deliver_order_id');
    }
    
}
