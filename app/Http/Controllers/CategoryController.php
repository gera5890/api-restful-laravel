<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::included()
                        ->filter()
                        ->sort()
                        ->get();
        return response()->json(CategoryResource::collection($category), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json(CategoryResource::make($category), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->included()->first();
        return response()->json(CategoryResource::make($category), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json(CategoryResource::make($category), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
