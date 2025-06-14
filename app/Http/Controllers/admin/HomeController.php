<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\TempImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index(){
        //fetch admin
        $admin = Auth::guard('admin')->user();

        //total order count
        $totalOrders = Order::where('status','!=','cancelled')->count();
        //total product count
        $totalProducts = Product::count();
        //total customer count
        $totalCustomers = User::where('role','1')->count();

        //total revenue
        $totalRevenue = Order::where('status','delivered')->sum('grand_total');

        //this month revenue
        $startThisMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate =  Carbon::now()->format('Y-m-d');
        $revenueThisMonth = Order::where('status','delivered')
                        ->whereDate('created_at','>=',$startThisMonth)
                        ->whereDate('created_at','<=',$currentDate)
                        ->sum('grand_total');
        
        //last month revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');   
        $revenueLastMonth = Order::where('status','delivered')
                        ->whereDate('created_at','>=',$lastMonthStartDate)
                        ->whereDate('created_at','<=',$lastMonthEndDate)
                        ->sum('grand_total');   
                        
        //last 30 days revenue
        $lastThirtyDaysStart = Carbon::now()->subDays(30)->format('Y-m-d');
        $revenueLastThirtyDays = Order::where('status','delivered')
                        ->whereDate('created_at','>=',$lastThirtyDaysStart)
                        ->whereDate('created_at','<=',$currentDate)
                        ->sum('grand_total'); 
                        
                        
        //auto delete previous days temp images
        $yesterday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');//date catch
        $tempImages = TempImage::where('created_at','<=',$yesterday)->get();
        //delete
        foreach ($tempImages as $tempImage) {
            $path = public_path('/temp/'.$tempImage->name);
            //temp images delete from folder
            if (File::exists($path)) {
                File::delete($path);
            }
            //temp images delete from db
            TempImage::where('id',$tempImage->id)->delete();
            
        }
               

        $data['admin'] = $admin;
        $data['totalOrders'] = $totalOrders;
        $data['totalProducts'] = $totalProducts;
        $data['totalCustomers'] = $totalCustomers;
        $data['totalRevenue'] = $totalRevenue;
        $data['revenueThisMonth'] = $revenueThisMonth;
        $data['revenueLastMonth'] = $revenueLastMonth;
        $data['revenueLastThirtyDays'] = $revenueLastThirtyDays;
        return view('admin.dashboard',$data);
    }
    // for session destroy
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
