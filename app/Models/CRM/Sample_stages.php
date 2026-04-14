<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sample_stages extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'sample_stages';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'sample_id',
        'service_item_satge_id',
        'status',
        'flag'
    ];

    public function get_samples_service()
    {
        return $this->belongsToMany(ServiceItem::class,'service_item_satges','id','service_item_id','service_item_satge_id','id');
    }
}

