<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product\Product;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ProductController extends Controller
{

    public function index(): JsonResponse
    {
        $products = Product::paginate('10', ['*'], 'page')->all();
        return response()->json([
            'message' => __('messages.index_success'),
            'data'    => $products
        ], ResponseAlias::HTTP_OK);
    }


    public function store(StoreProductRequest $request): JsonResponse
    {
        $request->validated();

        $products = Product::forceCreate([
            'name'      => $request->input('name'),
            'price'     => $request->integer('price'),
            'inventory' => $request->input('inventory'),
        ]);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $products
        ], ResponseAlias::HTTP_CREATED);
    }


    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $product
        ], ResponseAlias::HTTP_OK);
    }


    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $request->validated();

        $product->forceFill([
            'name'      => $request->input('name'),
            'price'     => $request->integer('price'),
            'inventory' => $request->input('inventory'),
        ])->save();

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $product
        ]);
    }


    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }



}
