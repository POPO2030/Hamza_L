<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Inv_importOrder
 * @package App\Models\inventory
 * @version August 1, 2023, 9:13 pm UTC
 *
 * @property string $serial
 * @property string $date_in
 * @property string $comment
 * @property integer $user_id
 * @property integer $updated_by
 */
class Inv_importOrder extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_import_orders';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'date_in',
        'comment',
        'supplier_id',
        'product_category_id',
        'original_invoice_img',
        'user_id',
        'updated_by',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'serial' => 'string',
        // 'date_in' => 'date:Y-m-d H:i:s',
        'date_in' => 'date:Y-m-d',
        'comment' => 'string',
        'user_id' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date_in' => 'required',
        'supplier_id' => 'required',
    ];


    public function get_supplier()
    {
        return $this->belongsTo('App\Models\CRM\suppliers','supplier_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }

    public function invproduct_category()
    {
        return $this->belongsTo(Inv_category::class,'product_category_id');
    }
}
