<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Team
 * @package App\Models\CRM
 * @version April 15, 2023, 1:20 am UTC
 *
 * @property string $name
 */
class Team extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'teams';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name'
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
        'name' => 'required|min:2|max:50|unique:teams'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    public function get_team()
    {
        return $this->belongsTo(User::class,'team_id');
    }

}
