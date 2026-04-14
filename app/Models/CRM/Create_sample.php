<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Create_sample
 * @package App\Models\CRM
 * @version September 4, 2023, 11:23 am EET
 *
 * @property integer $sample_id
 * @property integer $stage_id
 * @property integer $product_id
 * @property number $ratio
 * @property integer $degree
 * @property number $water
 * @property integer $time
 * @property number $ph
 * @property string $note
 * @property integer $flag
 */
class Create_sample extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'create_samples';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'sample_id',
        'stage_id',
        'service_item_id',
        'product_id',
        'ratio',
        'degree',
        'water',
        'time',
        'ph',
        'note',
        'flag',
        'rec_index'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sample_id' => 'integer',
        'stage_id' => 'integer',
        'service_item_id' => 'integer',
        'product_id' => 'integer',
        'ratio' => 'double',
        'degree' => 'integer',
        'water' => 'double',
        'time' => 'integer',
        'ph' => 'double',
        'note' => 'string',
        'flag' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sample_id' => 'required',

    ];

    public function get_serial()
    {
        return $this->belongsTo(LabSample::class,'sample_id');
    }

    public function get_stage()
    {
        return $this->belongsTo(Stage::class,'stage_id');
    }
    public function get_product()
    {
        return $this->belongsTo('App\Models\inventory\InvProduct','product_id');
    }
    public function get_service_item()
    {
        return $this->belongsTo(ServiceItem::class,'service_item_id');
    }
    public function get_sample_stage()
    {
        return $this->belongsToMany(ServiceItemSatge::class,'sample_stages','sample_id','service_item_satge_id');
    }
    
}
