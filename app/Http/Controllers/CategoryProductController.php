<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class CategoryProductController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        try {
            $data = CategoryProduct::all();
            return response()->json([
                "success" => 1,
                "message" => "Show data success",
                "data"    => $data
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'category_id' => 'required|integer',
                'product_id'  => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            // check double data
            $data = CategoryProduct::where([['product_id', $request->product_id],['category_id',$request->category_id]])->get();
            if ($data != '[]') {
                return response()->json([
                    'success' => 0,
                    'message' => "Data already exists",
                ], 200);
            }
            
            CategoryProduct::create($request->all());
            return response()->json([
                "success" => 1,
                "message" => "Create success",
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "success" => 0,
                "message" => "Id desn't match",
            ], 200);
        }
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Product $product, Category $category)
    {
        try {
            $validator = Validator::make($request->all(),[
                'category_id' => 'required|integer',
                'product_id'  => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            $categoryProduct = CategoryProduct::where([['product_id', $product->id],['category_id', $category->id]])->first();
            if ($categoryProduct) {
                // check double data
                $data = CategoryProduct::where([['product_id', $request->product_id],['category_id',$request->category_id]])->get();
                if ($data != '[]') {
                    return response()->json([
                        'success' => 0,
                        'message' => "Data already exists",
                    ], 200);
                }
                
                // Update
                CategoryProduct::where([['product_id', $product->id],['category_id', $category->id]])
                ->update([
                    'product_id' => $request->product_id,
                    'category_id' => $request->category_id
                ]);
                
                return response()->json([
                    "success" => 1,
                    "message" => "Update success",
                ]);
            }
            
            return response()->json([
                "success" => 0,
                "message" => "Data not found",
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "success" => 0,
                "message" => "Id desn't match",
            ], 200);
        }
    }
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Product $product, Category $category)
    {
        try {
            $categoryProduct = CategoryProduct::where([['product_id', $product->id],['category_id', $category->id]])->first();
            if ($categoryProduct) {
                $product  = Product::find($product->id);
                $category = Category::find($category->id);
                $product->category()->detach($category);
                return response()->json([
                    "success" => 1,
                    "message" => "Delete success",
                ], 200);
            }
            return response()->json([
                "success" => 0,
                "message" => "Data not found",
            ], 404);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "success" => 0,
                "message" => "Data not found",
            ], 404);
        }
    }
}
