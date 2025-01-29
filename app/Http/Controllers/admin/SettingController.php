<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function showChangePasswordForm(){
        //fetch admin
        $admin = User::where('id',Auth::guard('admin')->user()->id)->first();
        $data['admin'] = $admin;
        return view('admin.change-password',$data);
    }

    public function processchangePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
            'current_password' => 'required',
        ]);
        //fetch admin
        $admin = User::where('id',Auth::guard('admin')->user()->id)->first();
        if ($validator->passes()) {
            //check current password right or not
            if (!Hash::check($request->current_password,$admin->password)) {
               session()->flash('error','Your Current Password Not Correct, Please Submit Currect One!'); 
               return response()->json([
                    'status' => true,
               ]);
            }else{
                //update password
                User::where('id',Auth::guard('admin')->user()->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);
                session()->flash('success','Password Successfully saved'); 
                return response()->json([
                    'status' => true,
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function adminImageUpload(Request $request){
        //fetch admin
        $admin = User::where('id',Auth::guard('admin')->user()->id)->first();

        // update admin image
        $oldImage = $admin->image;
            
        if (!empty($request->image_id)) {
            $tempImage = TempImage::find($request->image_id);
            $extarray = explode('.',$tempImage->name);
            $ext = last($extarray);

            // change img name by User
            $newImageName = $admin->id.'-'.time().'.'.$ext;
            $sPath = public_path().'/temp/'.$tempImage->name;
            // generate thumbnail
            $dPath = public_path().'/uploads/user/'.$newImageName;
            $img = Image::make($sPath);
            //$img->resize(64, 64);
            $img->fit(70, 70, function ($constraint) {
                $constraint->upsize();
            });
            $img->save($dPath);

            $admin->image = $newImageName;
            $admin->save();

            //delete old image when update
            File::delete(public_path().'/uploads/user/'.$oldImage);

        }
        // update user image
        return response()->json([
            'status' => true,
        ]);
    }
}
