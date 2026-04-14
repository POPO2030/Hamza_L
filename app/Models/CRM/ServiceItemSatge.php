<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceItemSatge extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'service_item_satges';

    public $fillable = [
        'satge_id',
        'service_item_id'
    ];

    public function get_stage()
    {
        return $this->belongsTo(Stage::class,'satge_id');
    }
    public function get_service_item()
    {
        return $this->belongsTo(ServiceItem::class,'service_item_id');
    }
    public function get_activity()
    {
        return $this->hasMany(Activity::class,'owner_stage_id')->where('status','closed');
    }
}
