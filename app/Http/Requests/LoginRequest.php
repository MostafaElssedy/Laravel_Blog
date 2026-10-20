<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $isEmail = filter_var($this->input('login_id'), FILTER_VALIDATE_EMAIL);

        return [
            'login_id' => $isEmail
                ? 'required|email|exists:users,email'
                : 'required|exists:users,username',
            'password' => 'required|min:5',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $isEmail = filter_var($this->input('login_id'), FILTER_VALIDATE_EMAIL);

        return [
            'login_id.required' => $isEmail ? 'Email is required.' : 'Email or Username is required.',
            'login_id.email'    => 'Invalid email address format.',
            'login_id.exists'   => $isEmail
                ? 'This email is not registered in our system.'
                : 'This username is not registered in our system.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 5 characters.',
        ];
    }
}
