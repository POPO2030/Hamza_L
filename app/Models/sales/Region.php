<?php

namespace App\Models\sales;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Region
 * @package App\Models\sales
 * @version March 24, 2024, 12:51 pm EET
 *
 * @property string $name
 */
class Region extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'regions';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'creator_id',
        'updated_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'creator_id' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:regions'
    ];

    public static $rules_update = [
        'name' => 'required|min:2|max:50',
    ];

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }
    
}
