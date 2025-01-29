<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class CategoryController extends Controller
{

    public function index(){
        // show category list
        // $categories = Category::latest()->paginate();
        // $categories = Category::all();
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.categories.list',compact('categories'));
    }



    public function create(){
        return view('admin.categories.create');
    }


    public function store(Request $request){
        //form validation
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {
            //store data
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();


            // store image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extarray = explode('.',$tempImage->name);
                $ext = last($extarray);

                // change img name by category
                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                // generate thumbnail
                $dPath = public_path().'/uploads/category/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(64, 64);
                $img->fit(512, 512, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();

            }

            //message
            session()->flash('success','Category Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category Added Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function edit($categoryId, Request $request){
        //check if in server or not
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect()->route('categories.index');
        }
        return view('admin.categories.edit',compact('category'));
    }


    public function update($categoryId, Request $request){

        //check if in server or not
        $category = Category::find($categoryId);
        if (empty($category)) {
           return response()->json([
                'status'=> false,
                'notFound'=> true,
                'message'=> 'category not found'
           ]);
        }
        //form validation
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);

        if ($validator->passes()) {
            //store data
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            $oldImage = $category->image;
            
            // store image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extarray = explode('.',$tempImage->name);
                $ext = last($extarray);

                // change img name by category
                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                // generate thumbnail
                $dPath = public_path().'/uploads/category/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(64, 64);
                $img->fit(512, 512, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();

                //delete old image when update
                File::delete(public_path().'/uploads/category/'.$oldImage);

            }

            //message
            session()->flash('success','Category Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category Updated Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function destroy($categoryId, Request $request){

        $category = Category::find($categoryId);
        if (empty($category)) {
            session()->flash('error','Category Not Found');
            return response()->json([
                'status' => true,
                'message' => 'Category Not Found',
            ]);
        }
        //delete image and data
        File::delete(public_path().'/uploads/category/'.$category->image);
        $category->delete();
        //message
        session()->flash('success','Category Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully',
        ]);
    }

}
