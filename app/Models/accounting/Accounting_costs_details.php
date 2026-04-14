<?php

namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inventory\product_color;
use App\Models\inventory\Inv_unit;

class Accounting_costs_details extends Model
{
    use HasFactory;
    public $table = 'accounting_costs_details';

    public $fillable = [
        'accounting_costs_id',
        'product_id',
        'unit_id',
        'average_cost',
        'product_quantity',
    ];

    public function get_unit()
    {
        return $this->belongsTo(Inv_unit::class,'unit_id');
    }
    public function product_color()
    {
        return $this->belongsTo(product_color::class,'product_id');
    }
}
