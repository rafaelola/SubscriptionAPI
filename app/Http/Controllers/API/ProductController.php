<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Products;
use App\Http\Requests\ProductCrud\CreateProductPosts;

class ProductController extends Controller
{
    /** Gets all product details
     * @return JsonResponse
     */
    public static function getAll(): JsonResponse
    {
        return response()->json(Products::all()->toArray(), 200);
    }
    
    
    /**
     * @param CreateProductPosts $request
     *
     * @return JsonResponse
     */
    public static function createProduct(CreateProductPosts $request): JsonResponse
    {
        $validated = Validator::make($request->all(), $request->rules(),
            $request->messages());
        if ($validated->fails()) {
            response()->json(['UnprocessableEntity:' => $request->messages()], 422);
        }
        
        
        $product = Products::create($validated->getData());
        return response()->json(['id' => $product->id], 201);
    }
}
