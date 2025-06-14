<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null){
        // category or sub cat active
        $categorySelected = '';
        $subCategorySelected = '';

        //brands filter input
        $brandsArray = [];

        //fetch data
        $categories = Category::orderBy('name','ASC')->with('sub_category')->where('status',1)->get();
        $subcategories = SubCategory::orderBy('name','ASC')->with('category')->where('status',1)->get();
        $brands = Brands::orderBy('name','ASC')->where('status',1)->get();

        // change start
        $products = Product::where('status',1);
        // apply filters - by category and sub category
        if (!empty($categorySlug)) {
            $category = Category::where('slug',$categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }
        if (!empty($subCategorySlug)) {
            $subCategoy = SubCategory::where('slug',$subCategorySlug)->first();
            $products =  $products->where('sub_category_id',$subCategoy->id);
            $subCategorySelected = $subCategoy->id;
        }
        // apply filter - by brands
        if (!empty($request->get('brands'))) {
            $brandsArray = explode(',',$request->get('brands'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }
        // apply filter - by price range slider
        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            if ($request->get('price_max') == 1000) {
                $products = $products->whereBetween('price',[intval($request->get('price_min')),1000000]);
            }else{
                $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
            }

        }

        // search product - search bar
        if (!empty($request->get('product-search'))) {
            $products = $products->where('title','like','%'.$request->get('product-search').'%');
        }

        // apply filter - sort By
        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {

                $products = $products->orderBy('id','DESC');

            }elseif ($request->get('sort') == 'oldest') {

                $products = $products->orderBy('id','ASC');

            }elseif ($request->get('sort') == 'price_low') {

                $products = $products->orderBy('price','ASC');

            }elseif ($request->get('sort') == 'price_high') {

                $products = $products->orderBy('price','DESC');
            }
        }else {
           //products fetch
            $products = $products->orderBy('id','DESC');
        }


        $products = $products->paginate(6); // get product with pagination
        // change end

        $data['categories'] = $categories;
        $data['subcategories'] = $subcategories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 1000 : $request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');

        return view('front.shop',$data);
    }

    public function product($slug){
        $product = Product::where('slug',$slug)->with('product_images')->first();
        if ($product == null) {
            abort(404);
        }


        //fetch product rating
        $ratings =  ProductRating::where('product_id',$product->id)->where('status',1);
        //for pagination            
        $productRatings = ProductRating::where('product_id',$product->id)->where('status',1)->paginate(3);
        // count total
        $countProductRating = $ratings->count();
        //average rating
        $ratiingSum = $ratings->sum('rating');
        $averegeRating = '0.00';
        if ($countProductRating > 0) {
            $averegeRating = number_format(($ratiingSum / $countProductRating),2);
        }

        //fetch logged in user
        $userData = Auth::user();


        // related products fetch
        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->with('product_images')->get();
        }

        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        $data['productRatings'] = $productRatings;
        $data['countProductRating'] = $countProductRating;
        $data['averegeRating'] = $averegeRating;
        $data['userData'] = $userData;

        return view('front.product',$data);
    }

    public function submitRating($id, Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'email' => 'required|email',
            'comment' => 'required|max:200',
            'rating' => 'required',
        ]);
        if ($validator->passes()) {
            // if not loggedin redirect 
            if (Auth::check() == false) {
              
                //now after login back to current page
                session(['url.intended' => url()->previous()]);
    
                return response()->json([
                    'status' => 'not_logged_in',
                ]);
            }

            //not repeat - check only one time submit rating 
            $count = ProductRating::where('email',$request->email)->where('product_id',$id)->count();
            if ($count > 0) {
                //sweet alert
                Alert::error('You Already Rated This Product.', '');
                return response()->json([
                    'status' => true,
                ]);
            }else{
                //send to db
                $productRating = new ProductRating();
                $productRating->product_id = $id;
                $productRating->name = $request->name;
                $productRating->email = $request->email;
                $productRating->comment = $request->comment;
                $productRating->rating = $request->rating;
                $productRating->status = 0;
                $productRating->save();

                //sweet alert
                Alert::success('Your Review Successfully Sent For Review.', '');
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

    public function singleProductView($id){
        //fetch product
        $product = Product::find($id);

        $product_short_desc = strip_tags($product->short_description);

   
        $discount = ceil(($product->compare_price - $product->price)/$product->compare_price *100);

        //fetch product rating
        $ratings =  ProductRating::where('product_id',$id)->where('status',1);
        // count total
        $countProductRating = $ratings->count();
        //average rating
        $ratiingSum = $ratings->sum('rating');
        $averegeRating = '0.00';
        if ($countProductRating > 0) {
            $averegeRating = number_format(($ratiingSum / $countProductRating),2);
        }


        return response()->json([
            'status' => true,
            'product' => $product,
            'product_short_desc' => $product_short_desc,
            'discount' => $discount,
            'countProductRating' => $countProductRating,
            'averegeRating' => $averegeRating,
        ]);

    }
}
