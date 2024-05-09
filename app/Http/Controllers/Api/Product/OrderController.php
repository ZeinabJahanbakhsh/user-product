<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product\Order;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        /*
         * It works
        $orders = Product::all()->toArray();
        cache()->putMany((array)'put_many_orders', $orders);
        */

        /*
         * It works
        $orders = Order::get();
        cache()->put('put_orders', $orders);
        */

        $orders = Cache::remember('order_list', 60, function () {
            return Order::all();
        });

        return response()->json([
            'message' => __('messages.index_success'),
            'data'    => $orders
        ], ResponseAlias::HTTP_OK);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $request->validated();

        $order = Order::forceCreate([
            'count'       => $request->input('count'),
            'total_price' => $request->integer('total_price'),
            'products'    => $request->input('products'),
        ]);

        cache()->put('order_store_' . $order->id, $order);
        $orderCache = cache()->get('order_store_' . $order->id);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $orderCache
        ], ResponseAlias::HTTP_CREATED);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function show(Order $order): JsonResponse
    {
        if (
            Cache::get('order_store_' . $order->id)
            || Cache::get('order_update_' . $order->id)
            || Cache::get('order_show_' . $order->id)
        ) {
            cache()->put('order_show_' . $order->id, $order);
            $orderCache = cache()->get('order_show_' . $order->id);

            return response()->json([
                'message' => __('messages.store_success'),
                'data'    => $orderCache
            ], ResponseAlias::HTTP_OK);
        }


        $orderCache = null;
        Cache::remember('order_show_' . $order->id, 60, function () use (&$order, &$orderCache) {
            $orderCache = $order;
        });

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $orderCache
        ], ResponseAlias::HTTP_OK);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $request->validated();

        if ($request->integer('count') <= 0) {
            $order->delete();
            return response()->json([
                'message' => __('messages.rejected_order'),
            ]);
        }

        Cache::forget('order_store_' . $order->id);
        Cache::forget('order_show_' . $order->id);
        Cache::forget('order_update_' . $order->id);

        $order->forceFill([
            'count'       => $request->integer('count'),
            'total_price' => $request->integer('total_price'),
            'products'    => $request->input('products'),
        ])->save();

        cache()->put('order_update_' . $order->id, $order);
        $orderCache = cache()->get('order_update_' . $order->id);

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $orderCache
        ]);
    }


    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        Cache::forget('order_store_' . $order->id);
        Cache::forget('order_show_' . $order->id);
        Cache::forget('order_update_' . $order->id);

        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
