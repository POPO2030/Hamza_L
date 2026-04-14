<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_ProductUnit extends Model
{
    use HasFactory;
    public $fillable = [
        'product_id',
        'unit_id',
        'unitcontent',
    ];

    public function get_product()
    {
        return $this->belongsTo(Inv_product::class,'product_id');
    }
    public function get_unit()
    {
        return $this->belongsTo(Inv_unit::class,'unit_id');
    }
}
