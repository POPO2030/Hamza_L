<?php

namespace App\Models\CRM;

use Spatie\Activitylog\Models\Activity as BaseActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ActivityLog extends BaseActivity
{
    // Define the causer relationship
    // public function causer(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'causer_id');
    // }
    public function get_user()
    {
        return $this->belongsTo('App\Models\User','causer_id');
    }
}