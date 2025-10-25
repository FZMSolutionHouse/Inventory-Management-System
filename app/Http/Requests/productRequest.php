<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'detail'=>'required|string|max:255',
        ];
    }

       public function messages(): array
    {
        return [
            'name.required'=>'Please enter a Name',
            'name.string'=>'invalid Name Use Character',
            'name.max'=>'ERROR Length is too High',
            'detail.required'=>'Please enter a Detail',
            'detail.string'=>'invalid Detail Use Character',
            'detail.max'=>'ERROR Length is too High',
        ];
    }

}
