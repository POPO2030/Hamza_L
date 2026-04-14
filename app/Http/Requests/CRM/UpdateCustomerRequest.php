<?php

namespace App\Http\Requests\CRM;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CRM\Customer;

class UpdateCustomerRequest extends FormRequest
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
        $rules_update = Customer::$rules_update;
        $rules_update['name'] = $rules_update['name'].",".$this->route("customer");$rules_update['phone'] = $rules_update['phone'].",".$this->route("customer");
        return $rules_update;
    }
}
