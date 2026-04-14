<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security_deliver extends Model
{
    use HasFactory;

    public $fillable = [
        'deliver_order_id',
        'package_number',
        'count',
        'total',
        'barcode'
    ];

    protected $casts = [
        'deliver_order_id' => 'integer',
        'package_number' => 'integer',
        'count' => 'integer',
        'total' => 'integer',
        'barcode' => 'string',
    ];

    public static $rules = [
        'barcode' => 'required|array|min:1'
    ];

     public static $rules_update = [

        'barcode' => 'required|array|min:1'
    ];

    public function messages()
    {
        return [
            'barcode.required' => 'يجب ادخال الباركود ',
        ];
    }

}
