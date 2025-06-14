<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingCharge;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;



class CartController extends Controller
{
    public function addToCart(Request $request){

        $product = Product::find($request->id);


        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found.',
            ]);
        }
        // add product in cart
        if (Cart::count() > 0) {
           $cartContent = Cart::content();
           $productAlreadyExist = false;

           foreach ($cartContent as $item) {

            if ($item->id == $product->id) {
                $productAlreadyExist = true;
            }

           }
           if ($productAlreadyExist == false) {

            // Cart::add($product->id, $product->title, 1, $product->price,);//add
            Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'qty' => 1,
                'price' => $product->price,
                'options' => array('image' => $product->image),
                ));
            $status = true;
            $message ='Added In Cart.';
           }
           else{

            $status = false;
            $message ='Already Added In Cart.';//if added

           }

        }
        else{
            //cart is empty
            // Cart::add($product->id, $product->title, 1, $product->price,);
            Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'qty' => 1,
                'price' => $product->price,
                'options' => array('image' => $product->image),
                ));
            $status = true;
            $message ='Added In Cart.';

        }
        //message
        session()->flash('success',$message);

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);

    }

    public function addToCartFromSingle(Request $request){

        $product = Product::find($request->product_id);


        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found.',
            ]);
        }
        // add product in cart
        if (Cart::count() > 0) {
           $cartContent = Cart::content();
           $productAlreadyExist = false;

           foreach ($cartContent as $item) {

            if ($item->id == $product->id) {
                $productAlreadyExist = true;
            }

           }
           if ($productAlreadyExist == false) {

            // Cart::add($product->id, $product->title, 1, $product->price,);//add
            Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'qty' => $request->quantity_number, //quantity input
                'price' => $product->price,
                'options' => array('image' => $product->image),
                ));
            $status = true;
            $message ='Added In Cart.';
            Alert::success('Added To Cart.', '');
           }
           else{

            $status = false;
            $message ='Already Added In Cart.';//if added
            Alert::warning('Already Added In Cart.', '');

           }

        }
        else{
            //cart is empty
            // Cart::add($product->id, $product->title, 1, $product->price,);
            Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'qty' => $request->quantity_number, //quantity input
                'price' => $product->price,
                'options' => array('image' => $product->image),
                ));
            $status = true;
            $message ='Added In Cart.';
            Alert::success('Added To Cart.', '');

        }
        //message
        session()->flash('success',$message);

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }


    public function cart(){
        $cartContent = Cart::content();
        // dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('front.cart',$data);
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);
        //check if stock available or not
        if ($product->track_qty == 'Yes') {
            if ($product->qty >= $qty) {
                Cart::update($rowId,$qty);
                $message = 'Cart Updated Successfully';
                $status = true;
                session()->flash('success',$message);
            }else{
                $message = 'Requested Quantity('.$qty.') Not Available In Stock.';
                $status = false;
                session()->flash('error',$message);
            }
        }else{
            Cart::update($rowId,$qty);
            $message = 'Cart Updated Successfully';
            $status = true;
            session()->flash('success',$message);
        }


        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function removeCart(Request $request){



        $itemInfo = Cart::get($request->rowId);
        if ($itemInfo == null) {
            $errorMessage = 'Item Not Found In Cart';
            session()->flash('error',$errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
            ]);
        }

        Cart::remove($request->rowId);

        $successMessage = 'Item Removed From Cart Successfully';
            session()->flash('success',$successMessage);
            return response()->json([
                'status' => false,
                'message' => $successMessage,

            ]);
    }

    public function clearCart(){
        Cart::destroy();

    }

    public function checkout(){

        $discount = 0;

        //if cart empty redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('cart');
        }

        //if user is not logged in redirect to login page
        if (Auth::check() == false) {

            //if login user return to current url
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('login');
        }

        //step 6 - fetch customer address - show in checkout form
        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();

        session()->forget('url.intended');
        //fetch countrys
        $countries = Country::orderBy('name','ASC')->get();

        //discount//
        $subTotal = Cart::subtotal(2,'.','');
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }
        }
        //discount//

        //caculate shipping//
        if ($customerAddress != '') {
        $userCountry = $customerAddress->country_id;
        $shippingInfo = ShippingCharge::where('country_id',$userCountry)->first();
        $totalQty = 0;
        $totalShippingCharge = 0;
        $grandTotal = 0;
        foreach (Cart::content() as $item) {
            $totalQty += $item->qty;
        }
        $totalShippingCharge = $totalQty*$shippingInfo->amount;
        $grandTotal = ($subTotal-$discount)+$totalShippingCharge;
        }else{
            $grandTotal = ($subTotal-$discount);     
            $totalShippingCharge = 0;
        }

        $data['totalShippingCharge'] = $totalShippingCharge;
        $data['grandTotal'] = $grandTotal;
        //caculate shipping//




        $data['countries'] = $countries;
        $data['customerAddress'] = $customerAddress;
        $data['discount'] = $discount;

        return view('front.checkout',$data);
    }

    public function getOrderSummery(Request $request){

        //Apply Discount code//
        $subTotal = Cart::subtotal(2,'.','');
        $discount = 0;
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }
        }
        //Apply Discount code//

        if ($request->country_id > 0) {

           $subTotal = Cart::subtotal(2,'.','');
           $shippingInfo = ShippingCharge::where('country_id',$request->country_id)->first();
           $totalQty = 0;
           foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
           }
           //if selected country set shippin fee
           if ($shippingInfo != null) {

            $totalShippingCharge = $totalQty*$shippingInfo->amount;
            $grandTotal = ($subTotal-$discount)+$totalShippingCharge;

            return response()->json([
                'status' => true,
                'grandTotal' => number_format($grandTotal,2),
                'discount' =>  number_format($discount,2),
                'totalShippingCharge' => number_format($totalShippingCharge,2)
            ]);

           }else{
            //for selected country which not set shipping fee from admin
            $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();

            $totalShippingCharge = $totalQty*$shippingInfo->amount;
            $grandTotal = ($subTotal-$discount)+$totalShippingCharge;

            return response()->json([
                'status' => true,
                'grandTotal' => number_format($grandTotal,2),
                'discount' =>  number_format($discount,2),
                'totalShippingCharge' => number_format($totalShippingCharge,2)
            ]);
           }

        }else{
            //not select any country
            $subTotal = Cart::subtotal(2,'.','');
            $grandTotal = ($subTotal-$discount)+0;//change
            return response()->json([
                'status' => true,
                'grandTotal' => number_format($grandTotal,2),
                'discount' =>  number_format($discount,2),
                'totalShippingCharge' => number_format(0,2)
            ]);
        }
    }

    public function processCheckout(Request $request){
        //step 1 - apply validation
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:4',
            'last_name' => 'required',
            'email' => 'required|email',
            'last_name' => 'required',
            'country' => 'required',
            'address' => 'required|min:15',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the erors',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        };

        //step 2 - save user address
        //$customerAddress = CustomerAddress::find();

        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]
        );

        $totalShippingCharge = 0;
        $discount = 0;
        $subTotal = Cart::subtotal(2,'.','');

        //Apply Discount code//
        $discountCodeId = '';
        $couponCode = '';
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }
            $discountCodeId = $code->id;
            $couponCode = $code->code;
        }
        //Apply Discount code//


        //$grandTotal = $subTotal+$shipping; //remove grandtotal

        //calculate shipping//
        $shippingInfo = ShippingCharge::where('country_id',$request->country)->first();
        $totalQty = 0;
        foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
        }

        if ($shippingInfo != null) {

            $totalShippingCharge = $totalQty*$shippingInfo->amount;
            $grandTotal = ($subTotal-$discount)+$totalShippingCharge;

           }else{
            //for selected country which not set shipping fee from admin
            $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();

            $totalShippingCharge = $totalQty*$shippingInfo->amount;
            $grandTotal = ($subTotal-$discount)+$totalShippingCharge;

           }
        //calculate shipping//

        ////step 3 - store data in orders table
        //cod
        if ($request->payment == 'cod') {

            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $totalShippingCharge;
            $order->grand_total = $grandTotal;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->coupon_code = $couponCode;
            $order->coupon_code_id = $discountCodeId;
            $order->discount = $discount;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->country_id = $request->country;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->payment = $request->payment;
            $order->notes = $request->notes;
            $order->save();

            //step 4 - store order items in order items table
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price*$item->qty;
                $orderItem->image = $item->options->image;
                $orderItem->save();

                // update product stock
                $productData = Product::find($item->id);
                $currentQty = $productData->qty;
                $updateQty = $currentQty-$item->qty;
                $productData->qty = $updateQty;
                $productData->save();
            }

            //send email after order place
            orderEmail($order->id);

            session()->flash('success','You Have Successfully Placed Your Order');

            //after order do cart empty
            Cart::destroy();

            session()->forget('code');

            return response()->json([
                'message' => 'Order Saved Successfully',
                'status' => true,
                'orderId' => $order->id,
                'payment' => 'cod',
            ]);
            

        }
        //paypal
        if ($request->payment == 'paypal') {

            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $totalShippingCharge;
            $order->grand_total = $grandTotal;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->coupon_code = $couponCode;
            $order->coupon_code_id = $discountCodeId;
            $order->discount = $discount;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->country_id = $request->country;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->payment = $request->payment;
            $order->notes = $request->notes;
            $order->save();

            //step 4 - store order items in order items table
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price*$item->qty;
                $orderItem->image = $item->options->image;
                $orderItem->save();

                // update product stock
                $productData = Product::find($item->id);
                $currentQty = $productData->qty;
                $updateQty = $currentQty-$item->qty;
                $productData->qty = $updateQty;
                $productData->save();
            }
            // session()->flash('success','Order Successfully Placed. Pay $'. $grandTotal .  ' And Confirm Your Order');

            //after order do cart empty
            Cart::destroy();

            session()->forget('code');

            return response()->json([
                'message' => 'Order Saved Successfully',
                'status' => true,
                'orderId' => $order->id,
                'payment' => 'paypal',
            ]);
            

        }
    }


    public function thankYou($id){
        return view('front.thanks',[
            'id' => $id
        ]);
    }
    public function payPal($id){
        $order_details = Order::find($id);

        $data['order_details'] = $order_details;
        if ( $order_details !=null) {
           
            return view('front.paypal',$data);
        }else{
            return redirect()->route('home.index');
        }
    }
    public function payPalDataSubmit(Request $request){

        //fetch data
        $user = Auth::user();

        //paypal data send
        $paypal_payment = new Payment;
        $paypal_payment->user_id = $user->id;
        $paypal_payment->order_id = $request->orderId;
        $paypal_payment->payment_id = $request->paymentId;
        $paypal_payment->payer_id = $request->payerID;
        $paypal_payment->payer_email = $request->payerEmail;
        $paypal_payment->amount = $request->grandTotal;
        $paypal_payment->currency = $request->paymentCurrency;
        $paypal_payment->payment_method = $request->paymentMethod;
        $paypal_payment->save();
        

        //find order data
        $thisOrder = Order::find($request->orderId);

        // update order data
        $thisOrder->payment_status = "paid";
        $thisOrder->payment = $request->paymentMethod;
        $thisOrder->save();

        
        //send email after order place
        orderEmail($request->orderId);
        
    }

    public function cancelOrder($id, Request $request){
        $order = Order::find($id);
        if (empty($order)) {
            return redirect()->route('home.index');
        }
        $order->delete();
        return response([
            'status' => true,
            'message' => 'Order Cancel Successfully',

        ]);
    }

    public function applyDiscount(Request $request){
        //dd($request->code);

        //fetch code
        $code = DiscountCoupon::where('code',$request->code)->first();
        //check if have or not
        if ($code == null) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Discount Coupon',
            ]);
        }

        //check coupon start date valid or not
        date_default_timezone_set("Asia/Dhaka"); //timezone set
        $now = Carbon::now();
        //if current time is less than start date
        if ($code->starts_at != "") {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->starts_at);
            if ($now->lt($startDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Discount Coupon',
                ]);
            }
        }
        //if current time is greater than end date
        if ($code->expires_at != "") {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->expires_at);

            if ($now->gt($endDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Discount Coupon',
                ]);
            }
        }

        //max uses check //
        if ($code->max_uses > 0) {
            $couponUsed = Order::where('coupon_code_id',$code->id)->count();
            if ($couponUsed >= $code->max_uses) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Discount Coupon',
                ]);
            }
        }
        //max uses check //

        //max uses by user check //
        if ($code->max_uses_user > 0) {
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::user()->id])->count();
            if ($couponUsedByUser >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'You Already Used This Cooupon',
                ]);
            }
        }
        //max uses by user check //

        //max ammount condition check //
        $subTotal = Cart::subtotal(2,'.','');
        if ($code->min_amount > 0) {
            if ($subTotal < $code->min_amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Minimum Order Amount '.$code->min_amount.' For Apply This Coupon.',
                ]);
            }
        }
        //max ammount condition check //


        //set coupon code in session
        session()->put('code',$code);
        return $this->getOrderSummery($request);
    }

    public function removeCoupon(Request $request){
        session()->forget('code');
        return $this->getOrderSummery($request);
    }


}
