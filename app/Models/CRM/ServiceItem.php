<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ServiceItem
 * @package App\Models\CRM
 * @version April 14, 2023, 9:56 pm UTC
 *
 * @property string $name
 * @property number $price
 * @property integer $service_id
 */
class ServiceItem extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'service_items';
    

    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'name',
        'price',
        'money',
        'service_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'price' => 'double',
        'money' => 'double',
        'service_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:2|max:50|unique:service_items',
        // 'price' => 'required',
        'service_id' => 'required'
    ];
    public static $rules_update = [
        'name' => 'required|min:2|max:50',
        // 'price' => 'required',
        'service_id' => 'required'
    ];
    public function get_category()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
    public function get_stage()
    {
        return $this->belongsToMany(Stage::class, 'service_item_satges', 'service_item_id', 'satge_id')->withTimestamps();
    }
    public function get_stages()
    {
        return $this->hasMany(ServiceItemSatge::class,'service_item_id')->select('id','service_item_id');
    }
    
}
