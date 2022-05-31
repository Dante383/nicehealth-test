<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\Response;
use App\Http\Resources\SubscriptionResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        return SubscriptionResource::collection(Subscription::all());
    }

    public function store (SubscriptionRequest $request)
    {
        try {
            $subscription = new Subscription;
            $subscription->fill($request->validated())->save();

            return new SubscriptionResource($subscription);
        } catch(\Exception $exception) {
            throw new HttpException(400, "Invalid data - {$exception->getMessage()}");
        }
    }
}
