<?php

namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Deliver_order;
use App\Models\CRM\FinalDeliver;
use App\Models\CRM\WorkOrder;

class Invoice_details extends Model
{
  
    use HasFactory;

    public $table = 'invoice_details';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'invoice_id',
        'final_deliver_order_id',
        'work_order_id',
        'piece_price',
        'total_qty',
        'total_kg',
        'total_amount',
        'date',
    ];

    
    public function get_invoice()
    {
        return $this->belongsTo('App\Models\accounting\Invoice','invoice_id');
    }

  
    // public function get_deliver_order()
    // {
    //     return $this->hasManyThrough(
    //         Deliver_order::class,   // Final destination model
    //         FinalDeliver::class,    // Intermediate model
    //         'final_deliver_order_id',                   // Foreign key on FinalDeliver (ID)
    //         'id',                   // Foreign key on Deliver_order (ID)
    //         'final_deliver_order_id', // Local key on Invoice_details
    //         'deliver_order_id'       // Local key on FinalDeliver
    //     );
    // }

    public function get_work_order()
    {
        return $this->belongsTo(WorkOrder::class,'work_order_id');
    }

    public function get_work_order_count()
    {
        return $this->belongsTo('App\Models\CRM\WorkOrder','work_order_id')
        ->select('id','product_count','product_weight');
        
    }

    public function get_invoice_services()
    {
        return $this->hasMany('App\Models\accounting\Invoice_service_prices','invoice_details_id');
    }
}
