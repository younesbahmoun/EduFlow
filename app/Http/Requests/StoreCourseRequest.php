<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Mime\Message;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'teacher';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'interest_ids' => 'nullable|array',
            'interest_ids.*' => 'exists:interests,id',
        ];
    }

    public function messages()
    {
        return [
            'interest_ids.array' => 'The selected interest is invalid.',
            'interest_ids.*.exists' => 'The selected interest is invalid.',
        ];
    }
}
