<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('subscriptions')->where(fn ($query) => $query->where('customer_id', $this->customer_id))
            ],
            'active' => 'required|boolean'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer_id.required' => 'Please fill the customer\'s ID.',
            'product_id.required' => 'Please fill the product\'s ID.',
            'customer_id.exists' => 'Customer with that ID doesn\'t exist.',
            'product_id.exists' => 'Product with that ID doesn\'t exist.',
            'active.boolean' => '\'Active\' should be 0 or 1',
        ];
    }

}