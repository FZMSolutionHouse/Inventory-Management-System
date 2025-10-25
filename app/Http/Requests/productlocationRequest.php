<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productlocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'product_name' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'Please enter a name',
        'name.string' => 'Please enter a valid name',

        'product_name.required' => 'Please enter a product name',
        'product_name.string' => 'Please enter a valid product name',

        'description.required' => 'Please enter a description',
        'description.string' => 'Please enter a valid description',
          
        'longitude.required' => 'Please enter longitude',
        'longitude.numeric' => 'Please enter a valid longitude',
        'longitude.between' => 'Longitude must be between -180 and 180',

        'latitude.required' => 'Please enter latitude',
        'latitude.numeric' => 'Please enter a valid latitude',
        'latitude.between' => 'Latitude must be between -90 and 90',
    ];
}
}
