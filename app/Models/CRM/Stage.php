<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Stage
 * @package App\Models\CRM
 * @version April 14, 2023, 9:59 pm UTC
 *
 * @property string $name
 */
class Stage extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'stages';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name','stage_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:stages'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    public function get_activity()
    {
        return $this->hasMany(Activity::class,'owner_stage_id');
    }

    public function get_category()
    {
        return $this->belongsTo('App\Models\CRM\satge_category','stage_category_id');
    }

    public function get_shift_activity_day()
{
    return $this->hasMany(Activity::class, 'owner_stage_id')
        ->where('status', 'closed')
        ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 07:00:00')
        ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 19:00:00')
        ->select('id', 'work_order_id', 'owner_stage_id');
}

public function get_shift_activity_night()
{
    // To handle the 7 PM to 7 AM shift, we need to split the conditions into two parts.
    return $this->hasMany(Activity::class, 'owner_stage_id')
       
        ->where(function($query) {
            // Conditions for the previous day's night shift (7 PM to 11:59 PM)
            $query->where('status', 'closed')
                ->where('updated_at', '>=', date("Y-m-d", strtotime("-1 day")).' 19:01:00')
                ->where('updated_at', '<=', date("Y-m-d", strtotime("-1 day")).' 23:59:59');
        })
        ->orWhere(function($query) {
            // Conditions for the current day's early morning shift (12:00 AM to 7 AM)
            $query->where('status', 'closed')
            ->where('updated_at', '>=', date("Y-m-d").' 00:00:00')
            ->where('updated_at', '<=', date("Y-m-d").' 06:59:59');
        })
        ->select('id', 'work_order_id', 'owner_stage_id');
}


        
    
}
