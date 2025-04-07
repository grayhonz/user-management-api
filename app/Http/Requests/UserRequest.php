<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
        ];

        if ($this->isMethod('POST')) {
            $rules['email'] = 'required|email|unique:users,email';
        } else if ($this->isMethod('PUT')) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ];
        }

        return $rules;
    }
}