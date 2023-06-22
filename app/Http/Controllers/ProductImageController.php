<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    public function index()
    {
        try {
            $data = ProductImage::all();
            return response()->json([
                "success" => 1,
                "message" => "Show data success",
                "data"    => $data
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'product_id'  => 'required|integer',
                'image_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            // check double data
            $data = ProductImage::where([['product_id', $request->product_id],['image_id',$request->image_id]])->get();
            if ($data != '[]') {
                return response()->json([
                    'success' => 0,
                    'message' => "Data already exists",
                ], 200);
            }

            ProductImage::create($request->all());
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

    public function update(Request $request, Product $product, Image $image)
    {
        try {
            $validator = Validator::make($request->all(),[
                'product_id'  => 'required|integer',
                'image_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }
            
            $productImage = ProductImage::where([['product_id', $product->id],['image_id', $image->id]])->first();
            if ($productImage) {
                // check double data
                $data = ProductImage::where([['product_id', $request->product_id],['image_id',$request->image_id]])->get();
                if ($data != '[]') {
                    return response()->json([
                        'success' => 0,
                        'message' => "Data already exists",
                    ], 200);
                }
                
                // Update
                ProductImage::where([['product_id', $product->id],['image_id', $image->id]])
                ->update([
                    'product_id' => $request->product_id,
                    'image_id'   => $request->image_id
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

    public function destroy(Product $product, Image $image)
    {
        try {
            $productImage = ProductImage::where([['product_id', $product->id],['image_id', $image->id]])->first();
            if ($productImage) {
                $product  = Product::find($product->id);
                $image    = Image::find($image->id);
                $product->image()->detach($image);
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
