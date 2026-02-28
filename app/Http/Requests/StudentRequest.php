<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $student = $this->route('student');
        $studentId = is_object($student) ? $student->id : $student;

        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'student_number' => [
                'required',
                'digits:10',
                Rule::unique('students', 'student_number')
                    ->where(fn ($query) => $query->where('course_id', $this->input('course_id')))
                    ->ignore($studentId),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }
}
