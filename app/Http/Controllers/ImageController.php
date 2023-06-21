<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                'name'   => '',
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
            $extension = $getImage->getClientOriginalExtension();
            $fileName = strtotime("now").Str::random(10);
            $fullname = $fileName.'.'.$extension;

            $getData = Image::where('name', $fullname)->first();
            if ($getData) {
                $cekImageInStorage = Storage::exists($getData->file);
                    if ($cekImageInStorage) {
                        Storage::delete($getData->file);
                    }
            }

            $getImage->storeAs($filePath, $fullname);
            $image = new Image();
            $image->name = $fileName;
            $image->file = $filePath.$fullname;
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
