<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Product::all();
            return response()->json([
                "success" => 1,
                "message" => "Show data success",
                "data"    => ProductResource::collection($data)
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
                'name'        => 'required|string',
                'description' => 'required|string',
                'enable'      => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            Product::create($request->all());
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
    public function detail(Product $product)
    {
        return response()->json([
            "success" => 1,
            "message" => "Detail product",
            "data"    => new ProductResource($product)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name'        => 'required|string',
                'description' => 'required|string',
                'enable'      => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            $product->name        = $request->name;
            $product->description = $request->description;
            $product->enable      = $request->enable;
            $product->save();

            return response()->json([
                "success" => 1,
                "message" => "Update success",
                "data"    => new ProductResource($product)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            "success" => 1,
            "message" => "Delete success",
        ], 200);
    }
}
