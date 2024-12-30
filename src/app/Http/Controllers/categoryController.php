<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
    * Get all categories
    * @OA\Get(
    *    path="/api/categories",
    *    summary="Get all categories",
    *    tags={"categories"},
    *    description="Get all categories",
    *    operationId="indexCategories",
    *    @OA\Response(
    *       response=200,
    *       description="Success",
    *       @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Category", ref="#/components/schemas/Product"))
    *   )
    * )
     */
    public function index()
    {
        $category = \Cache::remember('categories_with_products', 30, function () {
            return Category::with('products')->get();
        });
        return response()->json($category);
    }

    /**
     * Create a new category
     * @OA\Post(
     *   path="/api/categories",
     *   summary="Create a new category",
     *   tags={"categories"},
     *   operationId="storeCategory",
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Category")
     *   ),
     *   @OA\Response(
     *      response=201,
     *      description="Created",
     *      @OA\JsonContent(ref="#/components/schemas/Category")
     *   ),
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        //Clear the cache
        \Cache::forget('categories_with_products');
        return response()->json($category, 201);
    }

    /**
     * Update a category
     * @OA\Put(
     *  path="/api/categories/{id}",
     *  summary="Update a category",
     *  tags={"categories"},
     *  operationId="updateCategory",
     *  @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of category to update",
     *     required=true,
     *     @OA\Schema(
     *        type="integer",
     *        format="int64"
     *    )
     * ),
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(ref="#/components/schemas/Category")
     * ),
     * @OA\Response(
     *   response=200,
     *   description="Success",
     *   @OA\JsonContent(ref="#/components/schemas/Category")
     *  ),
     * )
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $category->update($validated);
        //Clear the cache
        \Cache::forget('categories_with_products');
        \Cache::forget("category_{$category->id}_with_products");

        return response()->json($category);
    }

    /**
     * Get a category by id
     * @OA\Get(
     *  path="/api/categories/{id}",
     *  summary="Get a category by id",
     *  tags={"categories"},
     *  operationId="showCategory",
     *  @OA\Parameter(
     *    name="id",
     *    in="path",
     *    description="ID of the category",
     *    required=true,
     *    @OA\Schema(
     *      type="integer",
     *      format="int64"
     *   )
     * ),
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\JsonContent(ref="#/components/schemas/Category", ref="#/components/schemas/Product")
     * ),
     * )
     */
    public function show(Category $category)
    {
        $category = \Cache::remember("category_{$category->id}_with_products", 30, function () use ($category) {
            return $category->load('products');
        });

        return response()->json($category);
    }

    /**
     * Delete a category
     * @OA\Delete(
     * path="/api/categories/{id}",
     * summary="Delete a category",
     * tags={"categories"},
     * operationId="destroyCategory",
     * @OA\Parameter(
     *  name="id",
     *  in="path",
     *  description="ID of the category",
     *  required=true,
     *  @OA\Schema(
     *   type="integer",
     *   format="int64"
     *  )
     * ),
     * @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Category deleted successfully."))
     * ),
     * )
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }
}
