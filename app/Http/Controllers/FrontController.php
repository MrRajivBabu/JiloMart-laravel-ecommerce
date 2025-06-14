<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Page;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FrontController extends Controller
{
    public function index(){

        $featuredProducts = Product::where('is_featured','Yes')
            ->where('status',1)
            ->get();
        $data['featuredProducts'] = $featuredProducts;

        $newArrivals = Product::orderBy('id','DESC')
            ->where('status',1)
            ->limit(8)
            ->get();
        $data['newArrivals'] = $newArrivals;

        $exploreProducts = Product::orderBy('id','ASC')
            ->where('status',1)
            ->limit(8)
            ->get();
        $data['exploreProducts'] = $exploreProducts;

        return view('front.home',$data);
    }

    public function addToWishlist(Request $request){

        //first check user loged in or not 
        if (Auth::check() == false) {

            //now after login back to current page
            session(['url.intended' => url()->previous()]);

            return response()->json([
                'status' => false,
            ]);
        }

        //insert wishlist data
        $user = Auth::user();

        Wishlist::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $request->id,
            ],
            [
                'user_id' => $user->id,
                'product_id' => $request->id,
            ]
        );
        //sweet alert
        Alert::success('Added To Wishlist.', '');

        session()->flash('success','Added to wishlist.');
        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist',
        ]);

    }

    public function page($slug){
        $page = Page::where('slug',$slug)->first();
        if ($page == null) {
            abort(404);
        }
        
        $data['page'] = $page;
        return view('front.page',$data);
    }

    public function contactUs(){
        return view('front.contact');
    }

    public function processContactUs(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->passes()) {
            //send mail here
            $mailData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
                'subject' => 'You have recieved a contact email'
            ];
            $admin = User::where('role',2)->first();
            Mail::to($admin->email)->send(new ContactMail($mailData));

            Alert::success('Email Sent Successfully.', '');
            return response()->json([
                'status' => true,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function blogs(){
        return view('front.blogs');
    }
    public function aboutUs(){
        return view('front.about');
    }
}
