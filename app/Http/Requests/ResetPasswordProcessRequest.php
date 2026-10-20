<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordProcessRequest extends FormRequest
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
        return [
            'email'        => 'required|email|exists:users,email',
            'token'        => 'required',
            'new_password' => 'required|min:5|confirmed',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required'         => 'Email is required.',
            'email.email'            => 'Invalid email address format.',
            'email.exists'           => 'This email is not registered in our system.',
            'token.required'         => 'Token is required.',
            'new_password.required'  => 'Password is required.',
            'new_password.min'       => 'Password must be at least 5 characters.',
            'new_password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
