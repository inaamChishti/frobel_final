<?php

namespace App\Http\Requests\Auth\Admission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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

            // 'first_name_1' => 'required|string|min:2|max:30',
            // 'surname_1' => 'required|string|min:2|max:30',
            // 'dob_1' => 'required',
            // 'gender_1' => 'required',
            // 'hours_1' => 'nullable|integer',
            // 'years_in_school_1' => 'nullable|integer',

            // 'guardian_name' => 'required|string|min:2|max:30',
            // 'guardian_email' => 'nullable|email',
            // 'guardian_mobile' => 'required',
            // 'guardian_address' => 'required|min:5|max:300',
            // 'guardian_telephone' => 'nullable',

            // 'kin_name' => 'nullable|string|min:2|max:30',
            // // 'kin_email' => 'nullable|email',
            // // 'kin_mobile' => 'nullable|integer',
            // 'kin_address' => 'nullable|min:5|max:300',

            // 'fee_detail' => 'required|string',
            // // 'paid' => 'required',
            // // 'paid_up_to_date' => 'required',
            // 'payment_method' => 'required|string',
            // 'medical_condition' => 'nullable|min:2|max:5000',
            // 'comment' => 'nullable|min:5|max:5000',
            // 'guardian_email' => 'required',
            // // 'guardian_postalCode' => 'required',
            // 'payment_method' => 'required',
        ];
    }
}
 