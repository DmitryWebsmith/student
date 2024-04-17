<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => [
                "required",
                "numeric",
            ],
            'first_name' => [
                "required",
                "string",
            ],
            'last_name' => [
                "required",
                "string",
            ],
            'email' => [
                "required",
                "string",
            ],
            'password' => [
                "required",
                "string",
            ],
        ];
    }
}
