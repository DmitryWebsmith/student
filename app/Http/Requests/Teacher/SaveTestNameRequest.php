<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class SaveTestNameRequest extends FormRequest
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
            'category_id' => [
                "required",
                "numeric",
            ],
            'name' => [
                "required",
                "string",
            ],
        ];
    }
}
