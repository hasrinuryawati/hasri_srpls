<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return "masuk?";
        try {
            $data = Image::all();
            return response()->json([
                "success" => 1,
                "message" => "Show data success",
                "data"    => ImageResource::collection($data)
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
                'name'   => 'required|string',
                'file'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'enable' => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }

            $getImage = $request->file('file');
            $filePath = 'public/images/';
            $fileNameOriginal = $getImage->getClientOriginalName();
            $fullName = str_replace(' ', '', $fileNameOriginal);
            // $fileName = pathinfo($fullName, PATHINFO_FILENAME);

            $getData = Image::where('file', $filePath.$fullName)->first();
            if ($getData) {
                $cekImageInStorage = Storage::exists($getData->file);
                    if ($cekImageInStorage) {
                        Storage::delete($getData->file);
                    }
            }

            $getImage->storeAs($filePath, $fullName);
            $image = new Image();
            $image->name = $request->name;
            $image->file = $filePath.$fullName;
            $image->enable = $request->enable;
            $image->save();

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
    public function detail(Image $image)
    {
        return response()->json([
            "success" => 1,
            "message" => "Detail Image",
            "data"    => new ImageResource($image)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        // return $image;
        try {
            $validator = Validator::make($request->all(),[
                'name'   => 'required|string',
                'enable' => 'required|boolean',
                'file'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => $validator->messages()->all(),
                ], 422);
            }

            $getName = $request->name;
            $getEnable = $request->enable;
            $getImage = $request->file('file');
            $filePath = 'public/images/';
            $fileNameOriginal = $getImage->getClientOriginalName();
            $fullName = str_replace(' ', '', $fileNameOriginal);
            // $fileName = pathinfo($fullName, PATHINFO_FILENAME);

            $getData = Image::where('file', $filePath.$fullName)->first();
            if ($getData) {
                $cekImageInStorage = Storage::exists($getData->file);
                    if ($cekImageInStorage) {
                        Storage::delete($getData->file);
                    }
            }

            $getImage->storeAs($filePath, $fullName);

            $image->name = $request->name;
            $image->file = $filePath.$fullName;
            $image->enable = $request->enable;
            $image->save();

            
            return response()->json([
                "success" => 1,
                "message" => "Update success",
                "data"    => new ImageResource($image)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return response()->json([
            "success" => 1,
            "message" => "Delete success",
        ], 200);
    }
}
