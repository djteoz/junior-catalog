<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $perPage = (int) $request->input('per_page', 12);
        $perPage = max(5, min(50, $perPage));

        return ProductResource::collection($query->paginate($perPage));
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return (new ProductResource($product->load('category')))->response()->setStatusCode(201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);
        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($request->validated());

        return new ProductResource($product->load('category'));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();

        return response()->json(null, 204);
    }
}
