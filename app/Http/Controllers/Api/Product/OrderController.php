<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product\Order;
use App\Models\Product\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $order = Order::paginate('10', ['*'], 'page')->all();
        return response()->json([
            'message' => __('messages.index_success'),
            'data'    => $order
        ], ResponseAlias::HTTP_OK);
    }


    public function store(StoreOrderRequest $request): JsonResponse
    {
        $request->validated();

        $order = Order::forceCreate([
            'count'       => $request->input('count'),
            'total_price' => $request->integer('total_price'),
            'products'    => $request->input('products'),
        ]);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $order
        ], ResponseAlias::HTTP_CREATED);
    }


    public function show(Order $order): JsonResponse
    {
        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $order
        ], ResponseAlias::HTTP_OK);
    }


    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $request->validated();

        $order->forceFill([
            'count'       => $request->input('count'),
            'total_price' => $request->integer('total_price'),
            'products'    => $request->input('products'),
        ])->save();

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $order
        ]);
    }


    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
