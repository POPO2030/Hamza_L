<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;


class LabActivity extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'lab_activities';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'creator_id',
        'creator_team_id',
        'sample_stage_id',
        'closed_by_id',
        'closed_team_id',
        'status',
        'sample_id',
        'receive_name',
        'note',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }

    public function get_team()
    {
        return $this->belongsTo('App\Models\CRM\Team','creator_team_id');
    }
    public function get_owner()
    {
        return $this->belongsTo('App\Models\CRM\Stage','sample_stage_id');
    }
    public function get_user_closed()
    {
        return $this->belongsTo('App\Models\User','closed_by_id');
    }

    public function get_team_closed()
    {
        return $this->belongsTo('App\Models\CRM\Team','closed_team_id');
    }

    public function get_sample()
    {
        return $this->belongsTo('App\Models\CRM\LabSample','sample_id');
    }
}
