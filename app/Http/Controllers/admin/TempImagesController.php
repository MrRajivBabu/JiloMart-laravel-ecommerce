<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;

use Image;

class TempImagesController extends Controller
{
    public function create(Request $request){
        $image = $request->image;

        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            //where image store
            $image->move(public_path().'/temp',$newName);


            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'message' => 'Image Uploaded Successfully'
            ]);
        }
    }
}
