<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class SaveTextAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_id' => [
                "required",
                "numeric",
            ],
            'answer_id' => [
                "required",
                "numeric",
            ],
            'answer' => [
                "required",
                "string",
            ],
        ];
    }
}
