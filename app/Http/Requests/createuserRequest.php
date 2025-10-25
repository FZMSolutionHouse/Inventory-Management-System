<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createuserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

/**
 * Get the validation rule that apply to the request.
 * @return array<string, \Illumiate\Contracts\validation\ValidationRule|array|string>
*/

  // In app/Http/Requests/createuserRequest.php

public function rules(): array
{
    return [
        'name' => 'required|max:22',
        'email' => 'required|email|max:255|unique:createuser,email',
        'password' => [
            'required',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
        // The correction is on this line:
        'roles' => 'required|array', 
    ];
}

    public function messages()
    {
        return[
            'name.required' => 'Please enter your full name.',
            'name.max' => 'Full name cannot be longer than 22 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Please use a different email.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'roles.required' => 'Role is required.',
            ];
    }
}
