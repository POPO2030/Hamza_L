<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Color
 * @package App\Models\inventory
 * @version August 10, 2023, 10:35 am EET
 *
 * @property string $name
 */
class Color extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'colors';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        // 'name',
        'color_code_id',
        'colorCategory_id',
    ];



    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'name' => 'required|max:50|unique:colors'
        'color_code_id' => 'required|max:50',
        'colorCategory_id' => 'required|max:50'
    ];
    public static $rules_uppdate = [
        'color_code_id' => 'required',
        'colorCategory_id' => 'required'
    ];

    public function invcolor_category()
    {
        return $this->belongsTo(Color_category::class,'colorCategory_id');
    }
    public function product_color_cloth()
    {
        return $this->belongsToMany(Inv_product::class,'product_colors','color_id','product_id')
        ->where('category_id', 1);
    }

    public function product_color_product()
    {
        return $this->belongsToMany(Inv_product::class,'product_colors','color_id','product_id')
        ->where('category_id', '<>' , 1);
    }

    public function get_color_code()
    {
        return $this->belongsTo(Color_code::class,'color_code_id');
    }
}
