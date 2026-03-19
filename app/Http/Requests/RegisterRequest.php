<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:student,teacher',
            // 'interest_ids' => 'required_if:role,student|array',
            'interest_ids' => 'nullable|array',
            'interest_ids.*' => 'exists:interests,id',
        ];
    }

    public function messages()
    {
        return [
            // 'interest_ids.required_if' => 'The interests field is required when role is student.',
            'interest_ids.array' => 'The selected interests is invalid.',
            'interest_ids.*.exists' => 'The selected interests is invalid.',
        ];
    }
}
