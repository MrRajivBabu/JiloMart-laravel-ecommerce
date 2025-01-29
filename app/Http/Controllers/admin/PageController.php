<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use DOMDocument;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PageController extends Controller
{
    public function index(Request $request){
        $pages = Page::orderBy('created_at', 'desc')->get();

        $data['pages'] = $pages;
        return view('admin.pages.list',$data);
    }

    public function create(){
        return view('admin.pages.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:pages',
        ]);
        if ($validator->fails()) {
           return response()->json([
            'status' => false,
            'errors' => $validator->errors()
           ]);

        }else{

            $page = new Page;
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->save();

            $message = 'Page Created Successfully';
            session()->flash('success',$message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }
        
    }

    public function edit($id){
        $page = Page::find($id);
        if($page==null){
            session()->flash('error','Page Not Found');
            return redirect()->route('pages.index');
        }
        $data['page'] = $page;

        return view('admin.pages.edit',$data);
    }

    public function update(Request $request, $id){

        $page = Page::find($id);

        if ($page == null) {
            session()->flash('error','Page anot Found');
            return redirect()->route('pages.index');
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,'.$page->id.',id',
        ]);
        if ($validator->fails()) {
           return response()->json([
            'status' => false,
            'errors' => $validator->errors()
           ]);

        }else{


            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->save();

            $message = 'Page Updated Successfully';
            session()->flash('success',$message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }
        
    }
    

    public function destroy($id){
        $page = Page::find($id);

        if ($page == null) {
            session()->flash('error','Page anot Found');
            return redirect()->route('pages.index');
        }

        $page->delete();
        $message = 'Page Deleted Successfully';
        session()->flash('error',$message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
