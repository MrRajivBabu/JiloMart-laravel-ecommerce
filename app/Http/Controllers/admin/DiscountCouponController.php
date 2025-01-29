<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCouponController extends Controller
{
    public function index(Request $request){
        //fetch data
        $discountCoupons = DiscountCoupon::orderBy('created_at', 'desc')->get();

        $data['discountCoupons'] = $discountCoupons;
        return view('admin.discount.list',$data);
    }

    public function create(){
        return view('admin.discount.create');
    }

    public function store(Request $request){
        date_default_timezone_set("Asia/Dhaka"); //timezone set
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);
        if ($validator->passes()) {

            //starting date must be greater than current date
            if (!empty($request->starts_at)) {
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);

                if ($startAt->lte($now) == true) {

                    return response()->json([
                        'status' => false,
                        'errors' => ['starts_at' => 'Start Date Can Not Less Than Current Date Time']
                    ]);
                }
            }

            //expiry date must be greater than starting date
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expireAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);

                if ($expireAt->gte($startAt) == false) {

                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'Expiry Date Must Be Greater Than Starting Date']
                    ]);
                }
            }

            
            //store data
            $discountCoupon = new DiscountCoupon();
            $discountCoupon->code = $request->code;
            $discountCoupon->name = $request->name;
            $discountCoupon->description = $request->description;
            $discountCoupon->max_uses = $request->max_uses;
            $discountCoupon->max_uses_user = $request->max_uses_user;
            $discountCoupon->type = $request->type;
            $discountCoupon->discount_amount = $request->discount_amount;
            $discountCoupon->min_amount = $request->min_amount;
            $discountCoupon->status = $request->status;
            $discountCoupon->starts_at = $request->starts_at;
            $discountCoupon->expires_at = $request->expires_at;
            $discountCoupon->save();

            session()->flash('success', 'Discount Coupon Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Discount Coupon Added Successfully'
            ]);
            
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request, $id){

        $coupon = DiscountCoupon::find($id);
        if ($coupon == null) {
            session()->flash('error','Record Not found');
            return redirect()->route('discount.index');
        }
        $data['coupon'] = $coupon;

        return view('admin.discount.edit',$data);
    }

    public function update(Request $request, $id){
        date_default_timezone_set("Asia/Dhaka"); //timezone set
        $discountCoupon = DiscountCoupon::find($id);//change

        //change
        if ($discountCoupon == null) {
            session()->flash('error','Record Not found');
            return response()->json([
                'status' => true,
               
            ]);
        }

        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);
        if ($validator->passes()) {


            //expiry date must be greater than starting date
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expireAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);

                if ($expireAt->gte($startAt) == false) {

                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'Expiry Date Must Be Greater Than Starting Date']
                    ]);
                }
            }

            
            //store data
            //$discountCoupon = new DiscountCoupon();//change
            $discountCoupon->code = $request->code;
            $discountCoupon->name = $request->name;
            $discountCoupon->description = $request->description;
            $discountCoupon->max_uses = $request->max_uses;
            $discountCoupon->max_uses_user = $request->max_uses_user;
            $discountCoupon->type = $request->type;
            $discountCoupon->discount_amount = $request->discount_amount;
            $discountCoupon->min_amount = $request->min_amount;
            $discountCoupon->status = $request->status;
            $discountCoupon->starts_at = $request->starts_at;
            $discountCoupon->expires_at = $request->expires_at;
            $discountCoupon->save();

            session()->flash('success', 'Discount Coupon Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Discount Coupon Updated Successfully'
            ]);
            
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Request $request, $id){

        $coupon = DiscountCoupon::find($id);

        if ($coupon == null) {
            session()->flash('error','Record Not found');
            return response()->json([
                'status' => true,
            ]);
        }

        $coupon->delete();

        session()->flash('success','Discount Coupon Deleted Successfully');
            return response()->json([
                'status' => true,
            ]);

    }
}