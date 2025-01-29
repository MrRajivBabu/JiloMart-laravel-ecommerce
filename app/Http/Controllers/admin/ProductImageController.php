<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductGalleryImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    public function index($productId, Request $request) {
        //check if in server or not
        $product = Product::find($productId);
        if (empty($product)) {
            return redirect()->route('products.index');
        }

        $productImages = ProductGalleryImage::where('product_id',$productId)->get();

        return view('admin.product-image.index',compact('product','productImages'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'product_gallery_image.*' => 'mimes:png,jpg,jpeg',
        ]);

        //catch input data from form
        $productGalleryImages = $request->file('product_gallery_image');
        $productId = $request->product_id;

        foreach($productGalleryImages as $productGalleryImageFile){

            $fileName = hexdec(uniqid()) . '.' . $productGalleryImageFile->extension();
            $path = public_path('uploads/product/gallery/' . $fileName );
            // $manager = new ImageManager(new Driver());
            // $image = $manager->read($productGalleryImageFile);
            $image = Image::make($productGalleryImageFile);
            $image = $image->fit(584, 584, function ($constraint) {
                $constraint->upsize();
            });
            $image->save($path);
            $productGalleryImagePath = 'uploads/product/gallery/' . $fileName;

            $productGalleryImage = new ProductGalleryImage();
            $productGalleryImage->product_id = $productId;
            $productGalleryImage->image = $productGalleryImagePath;
            $productGalleryImage->save();
        }
        return redirect()->back();
    }
    public function destroy($productImageId, Request $request) {

        $productImage = ProductGalleryImage::find($productImageId);
        if(File::exists($productImage->image)){
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back();
    }
}
