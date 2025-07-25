<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password'=> 'required'
        ]);
        if ($validator->passes()) {

            //check admin data
            if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))) {

                //admin role check
                $admin = Auth::guard('admin')->user();
                if ($admin->role == 2) {
                    return redirect()->route('admin.dashboard');
                }else{
                    //if he is a user then session destroy and go back
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','You are not authorised to access admin panel');
                }



            }else{

                return redirect()->route('admin.login')->with('error','Email/Password is incorrect');
            }

        } else {
            //if not
            return redirect()->route('admin.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }

    }


}
