<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TempImage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class AuthController extends Controller
{
    public function login(){
        return view('front.account.login');
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {

            //check data
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                //if login from another intended url user return to that url
                if (session()->has('url.intended')) {

                    return redirect(session()->get('url.intended'));
                }

                return redirect()->route('profile')
                ->with('success','You Logged In Successfully');

            }else{
                //session()->flash('error','Either Email/Password Is Incorrect');
                return redirect()->route('login')
                ->withInput($request->only('email'))
                ->with('error','Either Email/Password Is Incorrect');
            }

        }else{
            return redirect()->route('login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function register(){
        return view('front.account.register');
    }

    public function processRegister(Request $request){
        //check data valid or not
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'username' => 'required|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);
        if ($validator->passes()) {

            //send data
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','You Have Been Registered Successfully');

            return response()->json([
                'status' => true,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function profile(){
        $user = Auth::user();
        //fetch user details
        $userDetail = User::where('id',Auth::user()->id)->first();
        //fetch orders
        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();

        //fetch country data.
        $countries = Country::orderBy('name','ASC')->get();
        //fetch user address
        $userAddress = CustomerAddress::where('user_id',$user->id)->first();

        // //fetch user country
        $userCountry = CustomerAddress::select('customer_addresses.*','countries.name as countryName')
                ->where('user_id',$user->id)
                ->leftJoin('countries','countries.id','customer_addresses.country_id')//join for get country name
                ->first();

       
        $data['orders'] = $orders;
        $data['userDetail'] = $userDetail;
        $data['countries'] = $countries;
        $data['userAddress'] = $userAddress;
        $data['userCountry'] = $userCountry;
        
        return view('front.account.profile',$data);
    }

    public function orderView($id){

        $order = Order::find($id);
        $orderItems = OrderItem::where('order_id',$id)->get();

        //make some data with point
        $subTotal = number_format($order->subtotal,2);
        $discount = number_format($order->discount,2);
        $shipping = number_format($order->shipping,2);
        $grandTotal = number_format($order->grand_total,2);
        
        return response()->json([
            'status' => true,
            'order' => $order,
            'subTotal' => $subTotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'grandTotal' => $grandTotal,
            'orderItems' => $orderItems,
        ]);
    }

    public function userDetailUpdate(Request $request){
        //fetch user id
        $userId = Auth::user()->id;
        //form validate
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
        ]);
        if ($validator->passes()) {
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            // update user image
            $oldImage = $user->image;
            
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extarray = explode('.',$tempImage->name);
                $ext = last($extarray);

                // change img name by User
                $newImageName = $user->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                // generate thumbnail
                $dPath = public_path().'/uploads/user/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(64, 64);
                $img->fit(70, 70, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);

                $user->image = $newImageName;
                $user->save();

                //delete old image when update
                File::delete(public_path().'/uploads/user/'.$oldImage);

            }
            // update user image


            return response()->json([
                'status' => true,
                'message' => 'Profile Details Updated'
            ]);
            
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function UpdatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
            'old_password' => 'required',
        ]);
        if ($validator->passes()) {
           
            //fetch user id and pssword
            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            //check if input old password not match with db
            if (!Hash::check($request->old_password,$user->password)) {
                
                return response()->json([
                    'status' => 'not_match',
                ]);
            }else{
                //if input old password match, then submit new password to db
                User::where('id',$user->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);
                //sweet alert
                Alert::success('Password Updated.', '');
                
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

    public function addressUpdate(Request $request){
        //fetch user id
        $userId = Auth::user()->id;
        //form validate
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:4',
            'last_name' => 'required',
            'email' => 'required|email',
            'apartment' => 'required',
            'country_id' => 'required',
            'address' => 'required|min:15',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->passes()) {
            CustomerAddress::updateOrCreate(
                ['user_id' => $userId],
                [
                    'user_id' => $userId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'country_id' => $request->country_id,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Profile Details Updated'
            ]);
            
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    
    public function logout(){
        Auth::logout();
        return redirect()->route('login')
        ->with('success','You Logged Out Successfully');
    }

    public function wishlist(){
        //fetch wishlist data
        $wishlistItems = Wishlist::where('user_id',Auth::user()->id)->with('product')->get();

        $data['wishlistItems'] = $wishlistItems;
        return view('front.account.wishlist',$data);
    }

    public function removeWishlistItem(Request $request){
        //fetch wishlist item by id
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();

        if ($wishlist == null) {
            Alert::error('Item Already removed.', '');
            return response()->json([
                'status' => true
            ]);
        }else{
            //now delete item
            Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->delete();
            Alert::success('Item removed Successfully.', '');
            return response()->json([
                'status' => true
            ]);
        }
    }

    public function forgetPassword(){
        return view('front.account.forget-password');
    }

    public function processForgetPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ]);
        if ($validator->passes()) {
          //send reset password link work start
          $token = Str::random(60);
          //delete previous from table atfirst
          DB::table('password_reset_tokens')->where('email',$request->email)->delete();  
          //send to table
          DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
          ]);
          //fetch user
          $user = User::where('email', $request->email)->first();
          //send mail now
          $formData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have requested to reset password'
          ];
          Mail::to($request->email)->send(new ResetPasswordEmail($formData));

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
    public function resetPassword($token){
        $tokenExist = DB::table('password_reset_tokens')->where('token',$token)->first();
        if ($tokenExist == null) {

            Alert::error('Invalid Request, Please try again!', '');
            return redirect()->route('forgetPassword');
        }
        $data['token'] = $token;
        return view('front.account.reset-password',$data);
    }

    public function processResetPassword(Request $request){
        $token = $request->token;
        $tokenExist = DB::table('password_reset_tokens')->where('token',$token)->first();
        if ($tokenExist == null) {

            Alert::error('Invalid Request, Please try again!', '');
            return redirect()->route('forgetPassword');
        }
        //fetch
        $user = User::where('email',$tokenExist->email)->first();
        //check
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->passes()) {
            //update
            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            //after reset password delete token
            DB::table('password_reset_tokens')->where('email',$user->email)->delete(); 

            Alert::success('Your Password Changed Successfully', '');
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


}
