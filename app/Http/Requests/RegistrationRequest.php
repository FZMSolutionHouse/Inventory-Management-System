<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return [
         'fullname'=>'required|max:22',
         'email'=>'required|email|max:100|unique:registration,email',
         'password'=> 'required|min:8',
         'confirmedPassword'=>'required|same:password',
        ];
    }
    

    public function messages()
    {
        return [
            'fullname.required' => 'Please enter your full name.',
            'fullname.max' => 'Full name cannot be longer than 22 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Please use a different email.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'confirmedPassword.required' => 'Please confirm your password.',
            'confirmedPassword.same' => 'Password confirmation does not match the password.',
        ];
    }

  
}
