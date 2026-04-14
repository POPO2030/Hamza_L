<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Reservation;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Reservation::$rules;
        
        return $rules;
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'يجب اختيار اسم العميل',
            'product_id.required' => 'يجب اختيار الصنف',
            'initial_product_count.required' => 'يجب ادخال العدد المبدئي للوجبة',
            'reservation_date.required' => 'يجب اختيار تاريخ الحجز',
        ];
    }
}
