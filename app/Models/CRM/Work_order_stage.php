<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work_order_stage extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'work_order_stages';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'work_order_id',
        'service_item_satge_id',
        'status'
    ];

    public function get_work_order_stage()
    {
        return $this->belongsToMany(Stage::class,'service_item_satges','id','satge_id','service_item_satge_id','id');
    }
    public function get_work_order_service()
    {
        return $this->belongsToMany(ServiceItem::class,'service_item_satges','id','service_item_id','service_item_satge_id','id');
    }

    public function get_sevice_item_stage()
    {
        return $this->belongsTo(ServiceItemSatge::class,'service_item_satge_id');
    }
    public function get_work_order()
    {
        return $this->belongsTo('App\Models\CRM\WorkOrder','work_order_id')
        ->select('id','product_count');
    }

}
