<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class SaveTestQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'test_id' => [
                "required",
                "numeric",
            ],
            'question_id' => [
                "required",
                "numeric",
            ],
            'test_question' => [
                "required",
                "string",
            ],
        ];
    }
}
