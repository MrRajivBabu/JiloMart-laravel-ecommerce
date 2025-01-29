<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class SubCategoryController extends Controller
{

    public function index(){

        //fetch sub category with join category
        // join('table_where_primary_key','foreign_key','primary_key')
        //select('table_where_foreign_key.*','table_name2.name as new_name')
        $subCategories = DB::table('sub_categories')
        ->join('categories','sub_categories.category_id','categories.id')
        ->select('sub_categories.*','categories.name as Category_name')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.sub_category.list',compact('subCategories'));
    }

    public function create(){
        //fetch category
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create',$data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()) {

            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;
            $subCategory->showHome = $request->showHome;
            $subCategory->save();

            session()->flash('success','Sub Category Created Successfully');

            return response([
                'status' => true,
                'message' => 'Sub Category Created Successfully',

            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($subCategoryId, Request $request){

        $subCategory = SubCategory::find($subCategoryId);
        if (empty($subCategory)) {
            //if not data
            session()->flash('error','Record Not Found');
            return redirect()->route('sub-category.index');

        }

        //fetch category and sub category
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit',$data);
    }

    public function update($subCategoryId, Request $request){

        $subCategory = SubCategory::find($subCategoryId);
        if (empty($subCategory)) {
            //if not data
            session()->flash('error','Record Not Found');
            return response([
                'status'=>false,
                'notFound'=>true
            ]);
            //return redirect()->route('sub-category.index');

        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id.',id',
            'category' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;
            $subCategory->showHome = $request->showHome;
            $subCategory->save();

            session()->flash('success','Sub Category Updated Successfully');

            return response([
                'status' => true,
                'message' => 'Sub Category Updated Successfully',

            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy($id, Request $request){
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            //if not data
            session()->flash('error','Record Not Found');
            return response([
                'status'=>false,
                'notFound'=>true
            ]);
            //return redirect()->route('sub-category.index');

        }
        $subCategory->delete();
        session()->flash('success','Sub Category Deleted Successfully');

        return response([
            'status' => true,
            'message' => 'Sub Category Deleted Successfully',

        ]);

    }
}
