<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LiveSearchController extends Controller
{
    public function liveSearchProduct(Request $request){
        $dataName = $request->data;
        $products = Product::where('title','like','%'.$dataName.'%')->limit(8)->get();//fetch data
        $totalResult = Product::where('title','like','%'.$dataName.'%')->get();
        $resultCount = count($totalResult);//total result

        return response()->json([
            'result'=>$products,
            'resultCount'=>$resultCount,
            'keyword'=>$dataName,
        ]);
    }
}
