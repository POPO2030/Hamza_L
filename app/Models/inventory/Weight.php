<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Weight
 * @package App\Models\inventory
 * @version August 19, 2023, 1:06 pm EET
 *
 * @property string $name
 */
class Weight extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'weights';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'creator_id',
        'updated_by'
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
        'name' => 'required|max:50|unique:weights'
    ];
    public static $rules_updates = [
        'name' => 'required|max:50'
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
