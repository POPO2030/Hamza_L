<?php

namespace App\Models\accounting;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Payment_type
 * @package App\Models\accounting
 * @version July 8, 2024, 2:32 pm EEST
 *
 * @property string $name
 */
class Payment_type extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payment_types';
    

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
        
    ];

    
}
