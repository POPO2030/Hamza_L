<?php

namespace App\Http\Requests\accounting;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\accounting\Accounting_cost;

class UpdateAccounting_costRequest extends FormRequest
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
        $rules = Accounting_cost::$rules;
        
        return $rules;
    }
}
