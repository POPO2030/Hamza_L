<?php

namespace App\Http\Requests\sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\sales\Final_product_requset;

class UpdateFinal_product_requsetRequest extends FormRequest
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
        $rules = Final_product_requset::$rules;
        
        return $rules;
    }
}
