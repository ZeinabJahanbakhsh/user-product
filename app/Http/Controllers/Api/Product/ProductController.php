<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
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

        $product = Product::forceCreate([
            'name'      => $request->input('name'),
            'price'     => $request->integer('price'),
            'inventory' => $request->input('inventory'),
        ]);

        Redis::set('store_product_' . $product->id, $product);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $product
        ], ResponseAlias::HTTP_CREATED);
    }


    public function show(Product $product): JsonResponse
    {
        Redis::set('show_product_' . $product->id, $product);
        $cachedProduct = Redis::get('show_product_' . $product->id);

        //fetch data from Redis
        if (isset($cachedProduct)) {
            $dataProduct = json_decode($cachedProduct, FALSE);

            return response()->json([
                'message' => __('messages.show_success'),
                'data'    => $dataProduct,
            ], ResponseAlias::HTTP_OK);
        }

        //fetch data from DB
        $dataProduct = Redis::set('show_product_' . $product->id, $product);

        return response()->json([
            'message' => __('messages.show_success'),
            'data'    => $product,
        ], ResponseAlias::HTTP_OK);
    }


    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $request->validated();
        Redis::del('store_product_' . $product->id);

        $product->forceFill([
            'name'      => $request->input('name'),
            'price'     => $request->integer('price'),
            'inventory' => $request->input('inventory'),
        ])->save();

        Redis::set('update_product_' . $product->id, $product);

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $product
        ]);
    }


    public function destroy(Product $product): JsonResponse
    {
        Redis::del('store_product_' . $product->id);
        Redis::del('update_product_' . $product->id);

        $product->delete();
        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
