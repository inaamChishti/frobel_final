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
            'family_id' => ['required', 'integer'],
            'student_name' => ['required'],
            'subject' => ['nullable'],
            'book' => ['nullable', 'string', 'max:255'],
            'test_no' => ['nullable', 'string', 'max:255'],
            'attempt' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'percentage' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:255'],
            'tutor_updated_by' => ['nullable', 'string', 'max:255']
        ];
    }
}
