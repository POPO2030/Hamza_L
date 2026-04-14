<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Color_code
 * @package App\Models\inventory
 * @version April 2, 2024, 8:04 am EET
 *
 * @property string $name
 */
class Color_code extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'color_codes';
    

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
        'name' => 'required|min:1|max:50|unique:color_codes',
    ];

    public static $rules_updates = [
        'name' => 'required|min:1|max:50',
    ];

    
}
