<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
        return [
            'paid_from' => 'required',
            'paid_to' => 'required',
            'paid' => 'required',
            'paid_up_to_date' => 'nullable',
            'package' => 'required|string',
            // 'collector' => 'string',
            'balance' => 'nullable|string',
            'comment' => 'nullable|min:2|max:5000',
            // 'payment_method' => 'required'
        ];
    }
}
