<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\BookRequest;
use Illuminate\Http\Response;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store (ProductRequest $request)
    {
        //try {
            $product = new Product;
            $product->fill($request->validated())->save();

            return new ProductResource($product);
        /*} catch(\Exception $exception) {
            throw new HttpException(400, "Invalid data - {$exception->getMessage()}");
        }*/
    }
}
