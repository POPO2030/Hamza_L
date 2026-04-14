<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\WorkOrder;

class CreateWorkOrderRequest extends FormRequest
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
        return WorkOrder::$rules;
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'يجب اختيار اسم العميل',
            'receive_receipt_id.required' => ' يجب اختيار رقم اذن الاضافة',
            'product_id.required' => 'يجب اختيار الصنف',
            // 'color_thread.required' => 'يجب ادخال لون الخيط',
            'initial_product_count.required' => 'يجب ادخال العدد المبدئي للوجبة',
            // 'product_count.required' => 'يجب ادخال العدد النهائى للوجبة',
            // 'product_weight.required' => 'يجب ادخال الوزن النهائى للوجبة',
            // 'place_id.required' => 'يجب اختيار مكان الوجبة ',
            // 'service_item_id.required' => 'يجب اختيار خدمة واحدة على الاقل ',
        ];
    }
}
