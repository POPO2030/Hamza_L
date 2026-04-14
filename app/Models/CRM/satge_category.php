<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class satge_category
 * @package App\Models\CRM
 * @version July 20, 2023, 1:06 pm EET
 *
 * @property string $name
 */
class satge_category extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'satge_categories';
    

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
        'name' => 'required|min:2|max:50|unique:satge_categories'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    public function get_stage()
    {
        return $this->hasMany(Stage::class,'stage_category_id');
    }
}
