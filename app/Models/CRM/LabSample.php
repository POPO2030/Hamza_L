<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

/**
 * Class LabSample
 * @package App\Models\CRM
 * @version August 13, 2023, 12:20 pm EET
 *
 * @property integer $customer_id
 * @property integer $product_id
 * @property string $serial
 * @property integer $count
 * @property string $status
 */
class LabSample extends Model
{

    use SoftDeletes;

    use HasFactory;

    public $table = 'lab_samples';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'creator_id',
        'creator_team_id',
        'closed_by_id',
        'closed_team_id',
        'customer_id',
        'product_id',
        'serial',
        'count',
        'sample_original_count',
        'img',
        'status',
        'note',
        'receivable_name',
        'date_progressing',
        'date_finish',
        'date_deliver',
        'fabric_id',
        'fabric_source_id',

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
        'customer_id' => 'integer',
        'product_id' => 'integer',
        'serial' => 'string',
        'count' => 'integer',
        'sample_original_count' => 'integer',
        'img' => 'string',
        'status' => 'string',
        'note' => 'string',
        'receivable_name' => 'string',
        'fabric_id' =>'integer',
        'fabric_source_id' =>'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_id' => 'required',
        'product_id' => 'required',
    ];



    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function get_products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_samples_stage()
    {
        return $this->belongsToMany(ServiceItemSatge::class,'sample_stages','sample_id','service_item_satge_id');
    }
    public function get_activities()
    {
        return $this->hasOne(LabActivity::class,'sample_id')->where('sample_stage_id',52)->where('status','open') ->orWhere('status', 'checked')
        ->orWhere('status', 'progressing');
    }
    public function get_activity()
    {
        return $this->hasMany(LabActivity::class,'sample_id')->where('sample_stage_id',53)->where('status','open')->orWhere('status', 'finish');
    }

    public function get_activity_for_deliver()
    {
        return $this->hasOne(LabActivity::class,'sample_id')->where('sample_stage_id',53)->Where('status', 'closed');
    }

    public function get_activity_for_wait_deliver()
    {
        return $this->hasOne(LabActivity::class,'sample_id')->where('sample_stage_id',53)->Where('status', 'finish');
    }

    public function get_activity_for_tab_index()
    {
        return $this->hasOne(LabActivity::class,'sample_id')->where('sample_stage_id',52)->where('status','closed');
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

