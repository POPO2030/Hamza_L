<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;

/**
 * Class Dyeing_receive
 * @package App\Models\CRM
 * @version February 22, 2024, 2:47 pm EET
 *
 * @property string $customer_name
 * @property integer $customer_id
 * @property string $model
 * @property string $cloth_name
 * @property string $product_name
 * @property integer $product_id
 * @property integer $quantity
 */
class Dyeing_receive extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'dyeing_receives';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'unique_key',
        'customer_name',
        'customer_id',
        'model',
        'cloth_name',
        'product_name',
        'product_color_id',
        'dyeing_requests_id',
        'quantity',
        'note_elsham1',
        'note_elsham2',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'unique_key'=>'string',
        'customer_name' => 'string',
        'customer_id' => 'integer',
        'model' => 'string',
        'cloth_name' => 'string',
        'product_name' => 'string',
        'product_color_id' => 'integer',
        'dyeing_requests_id' => 'integer',
        'quantity' => 'integer',
        'note_elsham1' => 'string',
        'note_elsham2' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
