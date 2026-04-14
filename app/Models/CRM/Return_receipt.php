<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

/**
 * Class Return_receipt
 * @package App\Models\inventory
 * @version July 16, 2023, 11:20 am +03
 *
 * @property string $model
 * @property string $brand
 * @property string $img
 * @property number $initial_count
 * @property number $final_weight
 * @property number $final_count
 * @property integer $product_id
 * @property integer $customer_id
 * @property integer $receivable_id
 * @property string $note
 */
class Return_receipt extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'return_receipts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'model',
        'brand',
        'img',
        'initial_count',
        'final_weight',
        'final_count',
        'product_id',
        'customer_id',
        'receivable_id',
        'workOrder_id',
        'note',
        'status',
        'creator_id',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'model' => 'string',
        'brand' => 'string',
        'initial_count' => 'double',
        'final_weight' => 'double',
        'final_count' => 'double',
        'product_id' => 'integer',
        'customer_id' => 'integer',
        'receivable_id' => 'integer',
        'workOrder_id' => 'integer',
        'status' => 'string',
        'creator_id' => 'integer',
        'updated_by' => 'integer',
        // 'created_at' => 'date:Y-m-d H:i:s',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'initial_count' => 'required|min:2|max:50'
    ];

    public function get_product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function get_receivables()
    {
        return $this->belongsTo(Receivable::class,'receivable_id');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
