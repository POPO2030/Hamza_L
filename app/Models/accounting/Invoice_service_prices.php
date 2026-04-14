<?php

namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\ServiceItem;

class Invoice_service_prices extends Model
{

    use HasFactory;


     public $table = 'invoice_service_prices';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'invoice_id',
        'invoice_details_id',
        'final_deliver_order_id',
        'work_order_id',
        'service_item_id',
        'service_id',
        'service_price',
    ];

    public function get_service_item()
    {
        return $this->belongsTo(ServiceItem::class,'service_item_id');
    }
}
