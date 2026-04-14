<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class FinalDeliver extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'final_deliver_details';
    

    // protected $dates = ['deleted_at'];


     public $fillable = [
        'deliver_order_id',
        'package_number',
        'count',
        'total',
        'weight',
        'final_deliver_order_id',
        'flag_inovice',
        'created_at',
        'creator_id',
        'updated_by',
        'updated_at'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_deliver_order()
    {
        return $this->belongsTo(Deliver_order::class,'deliver_order_id');
    }
    public function get_receivable_name()
    {
        return $this->belongsTo(Receivable::class,'receivable_id');
    }

}
