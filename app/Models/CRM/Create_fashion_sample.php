<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Create_fashion_sample extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $fillable = [
        'sample_id',
        'stage_id',
        'service_item_id',
        'product_id',
        'ratio',
        'resolution',
        'power',
        'time',
        'note',
        'flag',
        'rec_index'
    ];


public function get_serial()
    {
        return $this->belongsTo(LabSample::class,'sample_id');
    }

    public function get_stage()
    {
        return $this->belongsTo(Stage::class,'stage_id');
    }
    public function get_product()
    {
        return $this->belongsTo('App\Models\inventory\InvProduct','product_id');
    }
    public function get_service_item()
    {
        return $this->belongsTo(ServiceItem::class,'service_item_id');
    }
    public function get_sample_stage()
    {
        return $this->belongsToMany(ServiceItemSatge::class,'sample_stages','sample_id','service_item_satge_id');
    }

}
