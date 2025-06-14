<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Brands;

class BrandsController extends Controller
{
    public function index(){
        $brands = Brands::orderBy('created_at', 'desc')->get();
        return view('admin.brands.list',compact('brands'));
    }
    public function create(){
        return view('admin.Brands.create');
    }
    public function store(Request $request){
        //form validation
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands',
        ]);

        if ($validator->passes()) {
            //store data
            $brands = new Brands();
            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->status = $request->status;
            $brands->save();

            //message
            session()->flash('success','Brand Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Brand Added Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($brandId, Request $request){
        //check if in server or not
        $brand = Brands::find($brandId);
        if (empty($brand)) {
            return redirect()->route('brands.index');
        }
        return view('admin.brands.edit',compact('brand'));
    } 
    public function update($brandId, Request $request){

        //check if in server or not
        $brand = Brands::find($brandId);
        if (empty($brand)) {
        return response()->json([
                'status'=> false,
                'notFound'=> true,
                'message'=> 'category not found'
        ]);
        }
        //form validation
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
        ]);

        if ($validator->passes()) {
            //store data
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $oldImage = $brand->image;

            //message
            session()->flash('success','Brand Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Brand Updated Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy($brandId, Request $request){
        
        $brand = Brands::find($brandId);
        if (empty($brand)) {
            session()->flash('error','Brand Not Found');
            return response()->json([
                'status' => true,
                'message' => 'Brand Not Found',
            ]);
        }
        $brand->delete();
        //message
        session()->flash('success','Brand Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Brand Deleted Successfully',
        ]);
    }

}

