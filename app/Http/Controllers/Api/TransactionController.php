<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Response;
use App\Http\Resources\TransactionResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        return TransactionResource::collection(Transaction::all());
    }

    public function store (TransactionRequest $request)
    {
        try {
            $transaction = new Transaction;
            $transaction->fill($request->validated())->save();

            return new TransactionResource($transaction);
        } catch(\Exception $exception) {
            throw new HttpException(400, "Invalid data - {$exception->getMessage()}");
        }
    }
}
