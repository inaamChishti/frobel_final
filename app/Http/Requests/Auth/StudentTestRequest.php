<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StudentTestRequest extends FormRequest
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
            'family_id' => ['required'],
            'student_name' => ['required'],
            'subject' => ['required'],
            'book' => ['required'],
            'test_no' => ['required'],
            'attempt' => ['required'],
            'date' => ['required'],
            'percentage' => ['required'],
            'status' => ['required'],
            'updated_by' => ['required'],
        ];
    }
}
