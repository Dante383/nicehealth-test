<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'status' => 'required|boolean',
            'subscription_id' => 'required|exists:subscriptions,id'
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
            'amount.numeric' => 'Amount has to be a number.',
            'amount.required' => 'Please fill in the transaction\'s amount.',
            'status.required' => 'Please fill in the transaction\'s status.',
            'status.boolean' => 'Status has to be either 0 or 1.',
            'subscription_id.required' => 'Please fill in the subscription\'s ID.',
            'subscription_id.exists' => 'Subscription with that ID doesn\'t exist.'
        ];
    }

}