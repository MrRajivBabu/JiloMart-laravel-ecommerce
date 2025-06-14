<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brands;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\ProductGalleryImage;
use App\Models\ProductRating;
use App\Models\SubCategory;


class ProductController extends Controller
{
    public function index(){

        $data = [];
        //fetch data
        $products = Product::orderBy('id','DESC')->get();
        $data['products'] = $products;

        return view('admin.product.list',$data);
    }



    public function create() {
        $data = [];
        // get data from db
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;


        return view('admin.product.create', $data);
    }

    public function store(Request $request){
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'compare_price' => 'required|numeric|gte:price',
            'sku' => 'required|unique:products',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'track_qty' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = $request->short_description;
            $product->shipping_returns = $request->shipping_returns;
            $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : "";
            $product->save();


            // store image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extarray = explode('.',$tempImage->name);
                $ext = last($extarray);

                // change img name by product
                $newImageName = $product->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                // generate thumbnail
                $dPath = public_path().'/uploads/product/thumbnail/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(64, 64);
                $img->fit(630, 630, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);

                $product->image = $newImageName;
                $product->save();

            }


            //message
            session()->flash('success','Product Added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Added Successfully',
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }



    }

    public function edit($productId, Request $request){

        //fetch data
        $product = Product::find($productId);

        $subCategories = SubCategory::where('category_id', $product->category_id)->get();

        $productImages = ProductGalleryImage::where('product_id', $product->id)->get();

        // related products fetch
        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }

        $data = [];
        $data['product'] = $product;
        $data['subCategories'] = $subCategories;
        $data['productImages'] = $productImages;
        // get data from db
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['relatedProducts'] = $relatedProducts;

        return view('admin.product.edit',$data);
    }



    public function update($productId, Request $request){

        $product = Product::find($productId); // change

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id', // change
            'price' => 'required|numeric',
            'compare_price' => 'required|numeric|gte:price',
            'sku' => 'required|unique:products,sku,'.$product->id.',id', // change
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'track_qty' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {

            // $product = new Product; //change
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = $request->short_description;
            $product->shipping_returns = $request->shipping_returns;
            $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : "";
            $product->save();

            $oldImage = $product->image; //change

            // store image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extarray = explode('.',$tempImage->name);
                $ext = last($extarray);

                // change img name by product
                $newImageName = $product->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                // generate thumbnail
                $dPath = public_path().'/uploads/product/thumbnail/'.$newImageName;
                $img = Image::make($sPath);
                //$img->resize(64, 64);
                $img->fit(630, 630, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);

                $product->image = $newImageName;
                $product->save();

                //delete old image when update
                File::delete(public_path().'/uploads/product/thumbnail/'.$oldImage); //change

            }


            //message
            session()->flash('success','Product Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully',
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }



    }


    public function destroy($id, Request $request){
        $product = Product::find($id);

        if (empty($product)) {
            session()->flash('error','Product Not Found');
            return response()->json([
                'status' => false,
                'notFound' => true,
            ]);
        }
        // delete product images
        $productImages = ProductGalleryImage::where('product_id',$id)->get();
        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                File::delete($productImage->image);
            }

            ProductGalleryImage::where('product_id',$id)->delete();
        }
        //delete thumbnail
        File::delete(public_path().'/uploads/product/thumbnail/'.$product->image);
        $product->delete();

        session()->flash('success','Product Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product Deleted Successfully',
        ]);

    }

    public function getProducts(Request $request){
        $tempProduct = [];
        if ($request->term != "" ) {
            $products = Product::where('title','LIKE','%'.$request->term.'%')->get();
        }
        if ($products != null) {
            foreach ($products as $product) {
                $tempProduct[] = array(
                    'id' => $product->id,
                    'text' => $product->title
                );
            }
        }

        return response()->json([
            'tags' => $tempProduct,
            'status' => true
        ]);
    }

    public function productRatings(){
        //fetch ratings with her product title
        $ratings = DB::table('product_ratings')
                    ->join('products','product_ratings.product_id','products.id')
                    ->select('product_ratings.*','products.title as productTitle')
                    ->orderBy('created_at', 'desc')
                    ->get();

        $data['ratings'] = $ratings;
        return view('admin.product.ratings',$data);
    }

    public function deleteRating($id, Request $request){
        $rating = ProductRating::find($id);
        if (empty($rating)) {
            session()->flash('error','Rating Not Found');
            return response()->json([
                'status' => true,
            ]);
        }
        $rating->delete();
        session()->flash('success','Rating Deleted Successfully');
            return response()->json([
                'status' => true,
            ]);
    }

    public function ratingView($id){
        $rating = ProductRating::find($id);
        
        return response()->json([
            'status' => true,
            'rating' => $rating,
        ]);
    }

    public function changeRatingStatus(Request $request){
        $productRating = ProductRating::find($request->ratingId);
        $productRating->status = $request->ratingStatus;
        $productRating->save();

        return response()->json([
            'status' => true,
        ]);
    }

    public function outOfStock(){

        $data = [];
        //fetch data
        $products = Product::where('qty','<=',0)->orderBy('id','DESC')->get();
        $data['products'] = $products;

        return view('admin.product.stockout',$data);
    }


}
