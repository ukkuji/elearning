<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    private const CACHE_KEY = 'products.index';

    public function index(): JsonResponse
    {
        $products = Cache::remember(self::CACHE_KEY, now()->addSeconds(45), function () {
            return Course::query()
                ->with(['category:id,name', 'instructor:id,name,email'])
                ->latest()
                ->get();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Products loaded successfully.',
            'cached' => Cache::has(self::CACHE_KEY),
            'data' => $products,
        ]);
    }

    public function show(Course $product): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Product loaded successfully.',
            'data' => $product->load(['category:id,name', 'instructor:id,name,email']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $product = Course::create($this->validated($request));
        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request, Course $product): JsonResponse
    {
        $product->update($this->validated($request));
        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
            'data' => $product->refresh(),
        ]);
    }

    public function destroy(Course $product): JsonResponse
    {
        $product->delete();
        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully.',
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:120'],
            'description' => ['required', 'string', 'min:10', 'max:700'],
            'level' => ['required', 'string', 'max:60'],
            'duration' => ['required', 'string', 'max:60'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'image_style' => ['sometimes', 'string', 'in:img-1,img-2,img-3'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'instructor_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);
    }
}
