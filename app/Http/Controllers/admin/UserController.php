<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDO;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::where('role',1)->latest()->get();

        $data['users'] = $users;
        return view('admin.users.list',$data);
    }

    public function create(Request $request) {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'mobile' => 'required',
            'password' => 'required|min:5',
        ]);
        if ($validator->passes()) {
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->role = $request->role;
            $user->save();

            session()->flash('success','User Created Successfully');
            return response()->json([
                'status' => true,
                'message' => "User Created Successfully",
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Request $request, $id) {
        $user = User::find($id);

        if ($user == null) {
            session()->flash('error','User Not Found');
            return redirect()->route('users.index');
        }
        $data['user'] = $user;
        return view('admin.users.edit',$data);
    }

    public function update(Request $request, $id) {

        $user = User::find($id);

        if ($user == null) {
            session()->flash('error','User Not Found');
            return redirect()->route('users.index');
        }


        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id.',id', //without own 
            'email' => 'required|email|unique:users,email,'.$id.',id', //without own
            'mobile' => 'required',
        ]);
        if ($validator->passes()) {

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->status = $request->status;
            //if password input fill up
            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            session()->flash('success','User Details Updated Successfully');
            return response()->json([
                'status' => true,
                'message' => "User Details Updated Successfully",
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function destroy($id){
        $user = User::find($id);
        if (empty($user)) {
            session()->flash('error','User Not Found');
            return response()->json([
                'status' => true,
                'message' => 'User Not Found',
            ]);
        }
        $user->delete();
        //message
        session()->flash('success','User Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'User Deleted Successfully',
        ]);
    }
}
