<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_productd_description
 * @package App\Models\inventory
 * @version November 15, 2023, 10:51 am EET
 *
 * @property string $name
 */
class Inv_productd_description extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_productd_descriptions';
    

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
        'name' => 'required|min:2|max:50|unique:inv_productd_descriptions',
    ];

    public static $rules_updates = [
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
