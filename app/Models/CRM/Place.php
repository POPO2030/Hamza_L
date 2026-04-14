<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Place
 * @package App\Models\CRM
 * @version May 4, 2023, 11:11 am UTC
 *
 * @property string $name
 */
class Place extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'places';
    

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
        'name' => 'required|unique:places|min:2|max:50'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

}
