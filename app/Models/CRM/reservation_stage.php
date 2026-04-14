<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class reservation_stage extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'reservation_stages';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'reservation_id',
        'service_item_satge_id',
    ];
}
