<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_category
 * @package App\Models\inventory
 * @version July 21, 2023, 10:11 am UTC
 *
 * @property string $name
 */
class Inv_category extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_categories';
    

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
        'name' => 'required|min:2|max:50|unique:inv_categories'
    ];
    public static $rules_uppdate = [
        'name' => 'required|min:2|max:50'
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
