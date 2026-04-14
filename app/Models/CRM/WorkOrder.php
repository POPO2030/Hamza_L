<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
/**
 * Class WorkOrder
 * @package App\Models\CRM
 * @version April 20, 2023, 11:48 pm UTC
 *
 * @property integer $creator_id
 * @property integer $creator_team_id
 * @property integer $closed_by_id
 * @property integer $closed_team_id
 * @property string $status
 * @property integer $customer_id
 * @property integer $receive_receipt_id
 * @property integer $product_id
 * @property integer $product_count
 */
class WorkOrder extends Model
{
    use SoftDeletes;

    use HasFactory;
    use LogsActivity;

    public $table = 'work_orders';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'creator_id',
        'creator_team_id',
        'closed_by_id',
        'closed_team_id',
        'status',
        'customer_id',
        'receive_receipt_id',
        'product_id',
        'color_thread',
        'initial_product_count',
        'product_count',
        'product_weight',
        'receivable_id',
        'place_id',
        'barcode',
        'is_production',
        'priority',
        'fabric_id',
        'fabric_source_id',
        'weight_piece',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'creator_id' => 'integer',
        'creator_team_id' => 'integer',
        'closed_by_id' => 'integer',
        'closed_team_id' => 'integer',
        'status' => 'string',
        'customer_id' => 'integer',
        'receive_receipt_id' => 'integer',
        'product_id' => 'integer',
        'color_thread' => 'string',
        'initial_product_count' => 'integer',
        'product_count' => 'integer',
        'product_weight' => 'integer',
        'receivable_id' => 'integer',
        'place_id' => 'integer',
        'service_item_id' =>'integer',
        'fabric_id' =>'integer',
        'fabric_source_id' =>'integer',
        'weight_piece' =>'double',
        // 'created_at' => 'date:Y-m-d H:i:s',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_id' => 'required',
        'receive_receipt_id' => 'required',
        'product_id' => 'required',
        'initial_product_count' => 'required',
        'receivable_id' => 'required',
        // 'service_item_id' => 'required|array|min:1'
    ];

     public static $rules_update = [

        'customer_id' => 'required',
        'receive_receipt_id' => 'required',
        'product_id' => 'required',
        'initial_product_count' => 'required',
        // 'place_id' => 'required',
        // 'product_count' => 'required',
        // 'product_weight' => 'required',
        'receivable_id' => 'required',
        // 'service_item_id' => 'required|array|min:1'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function get_products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }
    public function get_closer()
    {
        return $this->belongsTo('App\Models\User','closed_by_id');
    }
    public function get_work_order_stage()
    {
        return $this->belongsToMany(ServiceItemSatge::class,'work_order_stages','work_order_id','service_item_satge_id');
    }
    public function get_receivables()
    {
        return $this->belongsTo(Receivable::class,'receivable_id');
    }
    public function get_places()
    {
        return $this->belongsTo(Place::class,'place_id');
    }

    public function get_ReceiveReceipt()
    {
        return $this->belongsTo(ReceiveReceipt::class,'receive_receipt_id');
    }

    public function get_ServiceItem()
    {
        return $this->belongsTo(ServiceItem::class,'service_item_id');
    }
    public function get_note()
    {
        return $this->hasMany(Note::class,'work_order_id');
    }
    public function get_activity()
    {
        return $this->hasMany(Activity::class,'work_order_id');
    }
    public function get_deliver_order()
    {
        return $this->hasMany(Deliver_order::class,'work_order_id');
    }

    public function get_stage()
    {
        return $this->hasMany(Work_order_stage::class,'work_order_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function get_stage_open()
    {
        return $this->hasMany(Work_order_stage::class,'work_order_id')
        ->where('status','open')
        ->select('id','work_order_id','service_item_satge_id');
    }
    public function get_open_activity()
    {
        return $this->hasOne(Activity::class,'work_order_id')->where('status','open');
    }
    public function get_closed_activity()
    {
        return $this->hasOne(Activity::class,'work_order_id')->where('status','closed')->latest('created_at');
    }

    public function get_fabric_source()
    {
        return $this->belongsTo(Fabric_source::class,'fabric_source_id');
    }

    public function get_fabric()
    {
        return $this->belongsTo(Fabric::class,'fabric_id');
    }

   

}



