<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Customer
 * @package App\Models\CRM
 * @version April 14, 2023, 10:53 pm UTC
 *
 * @property string $name
 * @property string $phone
 * @property string $mobile
 * @property string $address
 * @property string $email
 */
class Customer extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customers';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'phone',
        'mobile',
        'address',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'mobile' => 'string',
        'address' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:customers',
        'phone' => 'required|min:7|max:12|unique:customers'
    ];

    public static $rules_update = [
        'name' => 'required|min:2|max:50',
        'phone' => 'required|min:7|max:12'
    ];


}
