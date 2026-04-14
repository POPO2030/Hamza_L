<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Fabric_source
 * @package App\Models\CRM
 * @version April 27, 2024, 9:36 am EET
 *
 * @property string $name
 */
class Fabric_source extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'fabric_sources';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'creator_id',
        'updated_by',
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
        'name' => 'required|min:2|max:50|unique:fabric_sources'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    public function get_fabrices()
    {
        return $this->hasMany(Fabric::class,'fabric_source_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }
    
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }
}
