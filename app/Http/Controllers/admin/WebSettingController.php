<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use PgSql\Lob;

class WebSettingController extends Controller
{
    public function titleAndLogo(){
        //fetch
        $webData = Logo::where('id',1)->first();
        $data['webData'] = $webData; 
        return view('admin.web-settings.title-logo',$data);
    }
    public function titleAndLogoUpdate(Request $request){

        $titleandlogo = Logo::find(1);

        $validator = Validator::make($request->all(),[

            'title' => 'required',
            'description' => 'required|max:100',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }else {

            $titleandlogo->title = $request->title;
            $titleandlogo->description = $request->description;
            $titleandlogo->save();

            $oldImage = $titleandlogo->image;
            
            // store image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extarray = explode('.',$tempImage->name);
                $ext = last($extarray);

                // change img name by category
                $newImageName = $titleandlogo->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                // generate thumbnail
                $dPath = public_path().'/uploads/logo/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(64, 64);
                // $img->fit(512, 512, function ($constraint) {
                //     $constraint->upsize();
                // });
                $img->save($dPath);

                $titleandlogo->image = $newImageName;
                $titleandlogo->save();

                //delete old image when update
                File::delete(public_path().'/uploads/logo/'.$oldImage);
            }
            //message
            session()->flash('success','Data Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Data Updated Successfully'
            ]);
            
        }
    }
    public function faviconUpdate(Request $request){
        $validated = $request->validate([
            'favicon' => 'mimes:png,jpg,jpeg',
        ]);

        //catch input data from form
        $faviconImage = $request->file('favicon');

            $fileName = hexdec(uniqid()) . '.' . $faviconImage->extension();
            $path = public_path('uploads/favicon/' . $fileName );
            $image = Image::make($faviconImage);
            $image->save($path);
            $faviconImagePath = 'uploads/favicon/' . $fileName;

            //previous delete
            $logo = Logo::find(1);
            if(File::exists($logo->favicon)){
                File::delete($logo->favicon);
            }
            $logo->delete();
            //new insert
            $logo->favicon = $faviconImagePath;
            $logo->save();
        //message
        session()->flash('success','Favicon Uploaded Successfully');
        return redirect()->back();

    }
}
