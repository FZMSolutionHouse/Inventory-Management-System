<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class additem extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'itemName' => 'required|max:100|string',
            'requisition_id' => 'nullable|max:100|string',
            'category' => 'required|max:100|string',
            'category_type' => 'nullable|array',
            'category_type.*' => 'in:Fix,Consumable',
            'location' => 'nullable|max:100|string',
            'quantity' => 'required|integer|min:0',
            'minimumStock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'issue' => 'nullable|max:255|string',
            'supplier' => 'required|max:100|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            // Item Name messages
            'itemName.required' => 'Please enter a valid item name',
            'itemName.max' => 'Item name cannot be longer than 100 characters',
            'itemName.string' => 'Item name must be text',

            // Requisition ID messages
            'requisition_id.max' => 'Requisition ID cannot be longer than 100 characters',
            'requisition_id.string' => 'Requisition ID must be text',

            // Category messages
            'category.required' => 'Please enter a valid category',
            'category.max' => 'Category cannot be longer than 100 characters',
            'category.string' => 'Category must be text',

            // Category Type messages
            'category_type.array' => 'Category type must be an array',
            'category_type.*.in' => 'Category type must be either Fix or Consumable',

            // Location messages
            'location.max' => 'Location cannot be longer than 100 characters',
            'location.string' => 'Location must be text',

            // Quantity messages
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be a whole number',
            'quantity.min' => 'Quantity cannot be negative',

            // Minimum Stock messages
            'minimumStock.required' => 'Minimum stock is required',
            'minimumStock.integer' => 'Minimum stock must be a whole number',
            'minimumStock.min' => 'Minimum stock cannot be negative',

            // Price messages
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a valid number',
            'price.min' => 'Price cannot be negative',

            // Issue messages
            'issue.max' => 'Issue description cannot be longer than 255 characters',
            'issue.string' => 'Issue must be text',

            // Supplier messages
            'supplier.required' => 'Supplier is required',
            'supplier.max' => 'Supplier name cannot be longer than 100 characters',
            'supplier.string' => 'Supplier name must be text',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure category_type is always an array, even if empty
        if (!$this->has('category_type')) {
            $this->merge(['category_type' => []]);
        }
    }
}