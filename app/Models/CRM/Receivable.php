<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Receivable
 * @package App\Models\CRM
 * @version May 4, 2023, 11:59 am UTC
 *
 * @property string $name
 * @property string $phone
 */
class Receivable extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'receivables';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:receivables|min:2|max:50',
        // 'phone' => 'required|min:7|max:12'
    ];

    public static $rules_update = [
        'name' => 'required|min:2|max:50',
    ];
}
