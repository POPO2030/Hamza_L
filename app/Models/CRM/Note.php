<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'notes';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'creator_id',
        'creator_team_id',
        'note',
        'work_order_id',
        'updated_by',
        'updated_by_team',
    ];


    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }

    public function get_team()
    {
        return $this->belongsTo('App\Models\CRM\Team','creator_team_id');
    }
}
