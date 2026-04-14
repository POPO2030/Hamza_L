<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Size_finalproduct
 * @package App\Models\CRM
 * @version September 30, 2023, 10:15 am EET
 *
 * @property string $name
 */
class Size_finalproduct extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'size_finalproducts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'size_category',
        'creator_id',
        'updated_by'
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
        'name' => 'required|min:1|max:50'
    ];

    public static $rules_updates = [
        'name' => 'required|min:1|max:50'
    ];

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','creator_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }

    public function get_size_category()
    {
        return $this->belongsTo(Category_size_product::class,'size_category');
    }
}
