<?php

namespace App\Models\inventory;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CRM\Model_name;
use App\Models\CRM\Customer;
use App\Models\CRM\Stage;
use App\Models\sales\Final_product_requset;

/**
 * Class Inv_exportOrder
 * @package App\Models\inventory
 * @version August 3, 2023, 9:49 am UTC
 *
 * @property string $serial
 * @property string $date_out
 * @property string $comment
 * @property integer $user_id
 * @property integer $updated_by
 */
class Inv_exportOrder extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inv_export_orders';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'manual_id',
        'work_order_id',
        'customer_id',
        'washing_type', // نوع الغسلة
        'style_code', //  كود القصة
        'washing_weight', // وزن الغسلة
        'wash_color', // لون الغسلة
        'stage_id', // مرحلة الانتاج
        'date_out',
        'comment',
        'user_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'serial' => 'string',
        'date_out' =>  'date:Y-m-d',
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
        'date_out' => 'required'
    ];
   

    public function get_user()
    {
        return $this->belongsTo('App\Models\User','user_id')->withDefault([
            'name' => 'بدون مستلم'
        ]);
    }

    public function get_user_update()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }
    
    public function get_model()
    {
        return $this->belongsTo(Model_name::class,'model_id');
    }
    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function get_stage()
    {
        return $this->belongsTo(Stage::class,'stage_id');
    }

    public function invproduct_category()
    {
        return $this->belongsTo(Inv_category::class,'product_category_id');
    }
    public function get_Final_product_requset()
    {
        return $this->belongsTo(Final_product_requset::class,'final_product_request_id');
    }
}
