<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        try {
            $data = Category::all();
            return response()->json([
                "success" => 1,
                "message" => "Show data success",
                "data"    => CategoryResource::collection($data)
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'enable' => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            Category::create($request->all());
            return response()->json([
                "success" => 1,
                "message" => "Create success",
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
        
    }
    
    /**
    * Display the specified resource.
    */
    public function detail(Category $category)
    {
        return response()->json([
            "success" => 1,
            "message" => "Detail category",
            "data"    => new CategoryResource($category)
        ], 200);
            
    }
    
    public function update(Request $request, Category $category)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'enable' => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            $category->name   = $request->name;
            $category->enable = $request->enable;
            $category->save();

            return response()->json([
                "success" => 1,
                "message" => "Update success",
                "data"    => new CategoryResource($category)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            "success" => 1,
            "message" => "Delete success",
        ], 200);
    }
}
