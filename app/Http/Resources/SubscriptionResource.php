<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CustomerResource;
use App\Models\Product;
use App\Models\Customer;
use App\Component\Billing\DueDateCalculator;
use Carbon\Carbon;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => new CustomerResource(Customer::findOrFail($this->customer_id)),
            'product' => new ProductResource(Product::findOrFail($this->product_id)),
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'due_date' => (new DueDateCalculator)->nextDueDate($this->created_at, Carbon::now())
        ];
    }
}
