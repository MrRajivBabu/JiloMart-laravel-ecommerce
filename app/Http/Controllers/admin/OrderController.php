<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::orderBy('created_at', 'desc')->get();

        $data['orders'] = $orders;
        return view('admin.order.list',$data);
    }

    public function detail($orderId){
        //fetch order detail
        $order = Order::select('orders.*','countries.name as countryName')
                    ->where('orders.id',$orderId)
                    ->leftJoin('countries','countries.id','orders.country_id')//join for get country name
                    ->first();

        //fetch order items
        $orderItems = OrderItem::select('order_items.*','products.slug as productSlug','products.sku as productSku')
                        ->where('order_items.order_id',$orderId)
                        ->leftJoin('products','products.id','order_items.product_id')//join 
                        ->get();

        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        return view('admin.order.detail',$data);
    }

    public function changeOrderStatus(Request $request, $orderId){
        //shipped date
        $current_date = Carbon::now();

        $order = Order::find($orderId);
        $order->status = $request->order_status;
        $order->shipped_date = $current_date;
        $order->save();

        //message
        session()->flash('success','Order Status Updated');

        return response()->json([
            'status' => true,
            'message' => 'Order Status Updated',
        ]);

    }
    public function changePaidStatus(Request $request, $orderId){
        //shipped date
        $current_date = Carbon::now();

        $order = Order::find($orderId);
        $order->payment_status = $request->paid_status;
        $order->save();

        //message
        session()->flash('success','Paid Status Updated');

        return response()->json([
            'status' => true,
            'message' => 'Paid Status Updated',
        ]);

    }

    public function sendInvoiceEmail(Request $request, $orderId){
        invoiceMail($orderId);

        //message
        $invoiceMessage = "Invoice Sent Successfully";
        session()->flash('success',$invoiceMessage);

        return response()->json([
            'status' => true,
            'message' => $invoiceMessage
        ]);
    }

    public function deleteOrder($id, Request $request){
        $order = Order::find($id);
        if (empty($order)) {
            return redirect()->route('home.index');
        }
        $order->delete();

        session()->flash('success','Order Deleted Successfully');
        return response([
            'status' => true,
            'message' => 'Order Deleted Successfully',

        ]);
    }

    public function activeOrders(){
        
        $orders = Order::whereIn('status',['pending','shipped'])->orderBy('created_at', 'desc')->get();

        $data['orders'] = $orders;
        return view('admin.order.activeorder',$data);
    }

}    
