<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Fabric
 * @package App\Models\CRM
 * @version April 27, 2024, 9:51 am EET
 *
 * @property string $name
 * @property integer $fabric_source_id
 */
class Fabric extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'fabrics';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'fabric_source_id',
        'creator_id',
        'updated_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'fabric_source_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:fabrics'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50'
    ];

    public function get_fabric_source()
    {
        return $this->belongsTo(Fabric_source::class,'fabric_source_id');
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
