<?php

namespace App\Models\accounting;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bank
 * @package App\Models\accounting
 * @version October 3, 2024, 1:51 pm EET
 *
 * @property string $name
 * @property number $amount
 */
class Bank extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'banks';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'amount' => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
