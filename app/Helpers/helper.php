<?php

use App\Mail\orderEmail;
use App\Mail\invoiceMail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Logo;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

//fetch caregory
function getCategories(){
    return Category::orderBy('name','ASC')
        ->with('sub_category')
        ->where('status',1)
        ->where('showHome','Yes')
        ->limit(8)
        ->get();
}
//fetch products
function getProducts(){
    return Product::orderBy('created_at','ASC')
        ->where('status',1)
        ->limit(8)
        ->get();
}
//fetch cart
function getCartContent(){
    return Cart::content()->sort();
}

//fetch order details for email
function orderEmail($orderId){
    $order = Order::where('id',$orderId)->with('items')->first();

    //mail data
    $mailData = [
        'subject' => 'Thanks for your order',
        'order' => $order
    ];

    //mail to
    Mail::to($order->email)->send(new orderEmail($mailData));
}


//fetch invoice details for email
function invoiceMail($orderId){
    $order = Order::where('id',$orderId)->with('items')->first();

    //mail data
    $invoiceData = [
        'subject' => 'Order Invoice',
        'order' => $order
    ];

    //mail to
    Mail::to($order->email)->send(new invoiceMail($invoiceData));
}

//fetch country info
function getCountryInfo($id){
    return Country::where('id',$id)->first();
}

//fetch static pages
function staticPages(){
    $pages = Page::orderBy('name','ASC')->get();
    return $pages;
}

//fetch admin data
function adminInfo($id){
    return User::where('id',$id)->first();
}

//fetch logo , title, favicon
function webData(){
    return Logo::where('id',1)->first();
}
?>
