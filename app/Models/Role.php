<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Role
 * @package App\Models
 * @version April 27, 2023, 7:47 am UTC
 *
 * @property string $name
 * @property string $permissions
 */
class Role extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'roles';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'permissions'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'permissions' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:roles'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function getpermissionsAttribute($permissions){
        return json_decode($permissions,true);

    }
    
}
