<?php

namespace App\Models\CRM;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTimeInterface;
/**
 * Class Reservation
 * @package App\Models\CRM
 * @version May 20, 2023, 3:55 pm +03
 *
 * @property integer $customer_id
 * @property integer $product_id
 * @property integer $product_count
 * @property string $reservation_date
 * @property string $status
 */
class Reservation extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'reservations';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer_id',
        'product_id',
        'model',
        'color_thread',
        'initial_product_count',
        'reservation_date',
        'receivable_id',
        'status',
        'note',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_id' => 'integer',
        'product_id' => 'integer',
        'initial_product_count' => 'integer',
        // 'reservation_date' => 'date:Y-m-d H:i:s',
        'status' => 'string',
        // 'created_at'=>'date:Y-m-d H:i:s',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_id' => 'required',
        'product_id' => 'required',
        'initial_product_count' => 'required',
        'reservation_date' => 'required',
    ];

    public function get_reservation_stage()
    {
        return $this->belongsToMany(ServiceItemSatge::class,'reservation_stages','reservation_id','service_item_satge_id');
    }

    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function get_products()
    {
        return $this->belongsTo(Product::class,'product_id');
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
