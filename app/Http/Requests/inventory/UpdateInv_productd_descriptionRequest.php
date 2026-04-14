<?php

namespace App\Http\Requests\inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\inventory\Inv_productd_description;

class UpdateInv_productd_descriptionRequest extends FormRequest
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
        $rules = Inv_productd_description::$rules_updates;
        
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'عفوآ...يجب ادخال وصف المنتج',
        ];
    }
}
