<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionRequest extends FormRequest
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
            // 'joining_date' => 'required',
            // 'family_status' => 'required',


            // 'surname' => 'required|max:30',
            // 'dob' => 'required',
            // 'gender' => 'required',
            // 'years_in_school' => 'nullable',

            // 'guardian_name' => 'required|string|min:2|max:30',
            // 'guardian_email' => 'nullable|email|unique:guardians,email',
            // 'guardian_mobile' => 'required',
            // 'guardian_telephone' => 'nullable',
            // 'guardian_address' => 'required|min:5|max:300',

            // 'kin_name' => 'nullable|string|min:2|max:30',
            // 'kin_email' => 'nullable|email|unique:kin,email',
            // 'kin_mobile' => 'nullable',
            // 'kin_address' => 'nullable|min:5|max:300',
            // 'fee_detail' => 'required|string',
            // 'payment_method' => 'required|string',
            // 'comment' => 'nullable|min:5|max:5000',
            // 'paid_up_to_date' => 'required',
            // 'paid' => 'required|integer',


        ];
    }
}
