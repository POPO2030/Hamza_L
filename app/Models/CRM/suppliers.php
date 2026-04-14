<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class suppliers
 * @package App\Models\CRM
 * @version August 8, 2023, 4:13 pm UTC
 *
 * @property string $name
 * @property integer $phone
 */
class suppliers extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'suppliers';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'phone',
        'creator_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:suppliers'
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
}
