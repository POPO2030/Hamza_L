<?php

namespace App\Models\sales;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Treasury
 * @package App\Models\sales
 * @version March 20, 2024, 1:01 pm EET
 *
 * @property string $name
 */
class Treasury extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'treasuries';
    

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
        'name' => 'required|min:2|max:50|unique:treasuries'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    
}
