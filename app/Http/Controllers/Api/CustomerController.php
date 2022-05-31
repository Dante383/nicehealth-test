<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Response;
use App\Http\Resources\CustomerResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    public function store (CustomerRequest $request)
    {
        try {
            $customer = new Customer;
            $customer->fill($request->validated())->save();

            return new CustomerResource($customer);
        } catch(\Exception $exception) {
            throw new HttpException(400, "Invalid data - {$exception->getMessage()}");
        }
    }
}
