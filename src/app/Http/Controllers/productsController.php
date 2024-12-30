<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    /**
    * Get all products
    * @OA\Info(
    *     title="Laravel E-commerce API",
    *     version="1.0",
    *     description="This is an API for a simple e-commerce application built with Laravel",
    * ),
    * @OAS\SecurityRequirement( 
    * securityScheme="bearerAuth", 
    * )
    * @OA\Get(
    *    path="/api/products",
    *    summary="Get all products",
    *    tags={"products"},
    *    description="Get all products",
    *    operationId="indexProducts",
    *    @OA\Response(
    *       response=200,
    *       description="Success",
    *       @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
    *   )
    * )
    */
    public function index()
    {
        $products = \Cache::remember('products_with_category', 30, function () {
            return Products::with('category')->get();
        });
    
        return response()->json($products);
    }

    public function store(StoreProductRequest $request)
    {
        //Validate if the request have image
        if($request->hasFile('image')){
            $product['image'] = $request->file('image')->store('public/products');
        }
        $product = Products::create($request->validated());

        //Clear the cache
        \Cache::forget('products_with_category');

        return response()->json($product->load('category'), 201);
    }

    /**
     * Update a product
     * @OA\Put(
     *  path="/api/products/{id}",
     *  summary="Update a product",
     *  tags={"products"},
     *  operationId="updateProduct",
     *  @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of the product",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *        format="int64"
     *    )
     * ),
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(ref="#/components/schemas/Product")
     * ),
     * @OA\Response(
     *   response=200,
     *   description="Success",
     *   @OA\JsonContent(ref="#/components/schemas/Product")
     *  ),
     * )
     */
    public function update(UpdateProductRequest $request, Products $product)
    {

        try {
            $validated = $request->validated();

            if ($request->hasFile('image')) {
                if ($product->image) {
                    \Storage::delete($product->image);
                }
                $validated['image'] = $request->file('image')->store('public/products');
            }

            $product->update($validated);

            \Cache::forget('products_with_category');

            return response()->json($product->load('category'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Errores de validación:', $e->errors());
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }


    /**
     * Get a product by id
     * @OA\Get(
     *  path="/api/products/{id}",
     *  summary="Get a product by id",
     *  tags={"products"},
     *  operationId="showProduct",
     *  @OA\Parameter(
     *    name="id",
     *    in="path",
     *    description="ID of the product",
     *    required=true,
     *    @OA\Schema(
     *      type="integer",
     *      format="int64"
     *   )
     * ),
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\JsonContent(ref="#/components/schemas/Product")
     * ),
     * )
     */
    public function show(Products $product)
    {
        $productData = \Cache::remember("product_{$product->id}_with_category", 30, function () use ($product) {
            return $product->load('category');
        });
    
        return response()->json($productData);
    }

    /**
     * Delete a product
     * @OA\Delete(
     * path="/api/products/{id}",
     * summary="Delete a product",
     * tags={"products"},
     * operationId="destroyProduct",
     * @OA\Parameter(
     *  name="id",
     *  in="path",
     *  description="ID of the product",
     *  required=true,
     *  @OA\Schema(
     *   type="integer",
     *   format="int64"
     *  )
     * ),
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Product deleted successfully."))
     * ),
     * )
     */
    public function destroy(Products $product)
    {
        if($product->image){
            \Storage::delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }

    /**
     * Get a random product
     * @OA\Get(
     *  path="/api/products/random",
     *  summary="Get a random product",
     *  tags={"products"},
     *  operationId="showRandomProduct",
     *  @OA\Response(
     *   response=200,
     *   description="Success",
     *   @OA\JsonContent(ref="#/components/schemas/Product")
     *  ),
     * )
     */
    public function showRandomProduct()
    {
        $randomProduct = Products::inRandomOrder()->first();

        if (!$randomProduct) {
            return response()->json(['message' => 'No product found'], 404);
        }

        $productData = \Cache::remember("product_{$randomProduct->id}_random", 30, function () use ($randomProduct) {
            return $randomProduct->load('category');
        });

        return response()->json($productData);
    }
}
