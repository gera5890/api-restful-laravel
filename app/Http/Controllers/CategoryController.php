<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create category');
        $this->middleware('can:edit category');
        $this->middleware('can:delete category');
    }
    public function index()
    {
        $category = Category::included()
                        ->filter()
                        ->sort()
                        ->get();
        return response()->json(CategoryResource::collection($category), Response::HTTP_OK);
    }

    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $category = new Category([
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'],
                'user_id' => Auth::user()
            ]);
            DB::commit();
            return response()->json(CategoryResource::make($category), Response::HTTP_CREATED);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear categoria',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show(Category $category)
    {
        $category = $category->included()->first();
        return response()->json(CategoryResource::make($category), Response::HTTP_OK);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::beginTransaction();
        try {
            $category->update($request->validated());
            DB::commit();
            return response()->json(CategoryResource::make($category), Response::HTTP_OK);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => "Error al actualizar categoria",
                'error' => $e->getMessage()
            ]);
        }
    }
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();
            DB::commit();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => "Error al eliminar la categoria",
                'error' => $e->getMessage()
            ]);
        }
    }

}
