<?php

namespace App\Models\accounting;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CRM\WorkOrder;
/**
 * Class Accounting_cost
 * @package App\Models\accounting
 * @version July 2, 2024, 2:32 pm EEST
 *
 * @property string $name
 */
class Accounting_cost extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'accounting_costs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'work_order_id',
        'model_price',
        'total_contract_quantity',
        'operating_expenses',
        'notes',
        'creator_id',
        'updated_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'work_order_id' => 'integer',
        'model_price' => 'double',
        'total_contract_quantity' => 'double',
        'operating_expenses' => 'double',
        'notes' => 'string',
        'creator_id' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function get_work_order()
    {
        return $this->belongsTo(WorkOrder::class,'work_order_id');
    }

    public function get_details()
    {
        return $this->hasMany(Accounting_costs_details::class,'accounting_costs_id');
    }
    
}
