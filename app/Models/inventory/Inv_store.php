<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_store
 * @package App\Models\inventory
 * @version July 21, 2023, 10:05 am UTC
 *
 * @property string $name
 */
class Inv_store extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_stores';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'category_id',
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
        'name' => 'required|min:2|max:50|unique:inv_stores'
    ];
    public static $rules_update = [
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

    public function get_category()
    {
        return $this->belongsTo(Inv_category::class,'category_id');
    }
    
}
