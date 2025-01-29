<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandsController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\DiscountCouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\WebSettingController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LiveSearchController;

use Illuminate\Http\Request;

Route::get('/blog-post', function () {
    return view('front.blog-post');
});

// Route::get('/', function () {
//     return view('welcome');
// });

//home
Route::get('/', [FrontController::class, 'index'])->name('home.index');

//live search
Route::post('/live-search-product', [LiveSearchController::class, 'liveSearchProduct'])->name('liveSearchProduct');

//shop
Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class, 'product'])->name('product');

//cart
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('updateCart');
Route::post('/remove-cart', [CartController::class, 'removeCart'])->name('removeCart');
Route::get('/clear-cart', [CartController::class, 'clearCart'])->name('clearCart');

//add to cart from single product page
Route::post('/add-to-cart-from-single', [CartController::class, 'addToCartFromSingle'])->name('addToCartFromSingle');

//checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('processCheckout');
Route::get('/thanks/{orderId}', [CartController::class, 'thankYou'])->name('thankYou');
Route::post('/get-order-summery', [CartController::class, 'getOrderSummery'])->name('getOrderSummery');


//apply discount coupon
Route::post('/apply-discount-coupon', [CartController::class, 'applyDiscount'])->name('applyDiscount');
Route::post('/remove-discount-coupon', [CartController::class, 'removeCoupon'])->name('removeCoupon');

//wishlist
Route::post('/add-to-wishlist', [FrontController::class, 'addToWishlist'])->name('addToWishlist');


//page
Route::get('/page/{slug}', [FrontController::class, 'page'])->name('page');
//contact page
Route::get('/contact-us', [FrontController::class, 'contactUs'])->name('contact');
//blog page
Route::get('/blogs', [FrontController::class, 'blogs'])->name('blogs');
//blog page
Route::get('/about-us', [FrontController::class, 'aboutUs'])->name('aboutUs');

//contact page mail send
Route::post('/send-contact-mail', [FrontController::class, 'processContactUs'])->name('sendContactMail');

//forget password
Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
Route::post('/processForgetPassword', [AuthController::class, 'processForgetPassword'])->name('processForgetPassword');
//reset password
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/processResetPassword', [AuthController::class, 'processResetPassword'])->name('processResetPassword');
//sumbit product rating
Route::post('/submitRating/{ProductId}', [ShopController::class, 'submitRating'])->name('submitRating');

//single product view modal
Route::get('/single-product-view/{id}', [ShopController::class, 'singleProductView'])->name('singleProductView');


//redirect
Route::get('/account', function () {
    return redirect('/account/profile');
});

// user login and register and account
Route::group(['prefix' => 'account'], function(){
    //guest route
    Route::group(['middleware' => 'guest'],function(){

        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('processRegister');
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');


    });
    //protected pages routes - after login user
    Route::group(['middleware' => 'auth'],function(){
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/update-profile', [AuthController::class, 'userDetailUpdate'])->name('profile.update');
        Route::post('/update-address', [AuthController::class, 'addressUpdate'])->name('address.update');
        Route::post('/update-password', [AuthController::class, 'UpdatePassword'])->name('password.update');
        Route::get('/order-view/{id}', [AuthController::class, 'orderView'])->name('orderView');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        //cancel order
        Route::delete('/order/{orderId}', [CartController::class, 'cancelOrder'])->name('order.cancel');
        //paypal
        Route::get('/paypal/{orderId}', [CartController::class, 'payPal'])->name('paypal');
        Route::post('/paypal-data-submit', [CartController::class, 'payPalDataSubmit'])->name('paypal-data-submit');
        Route::get('/wishlist', [AuthController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist-item-remove', [AuthController::class, 'removeWishlistItem'])->name('removeWishlistItem');
    });

});




//Route::get('admin/login', [AdminLoginController::class, 'index'])->name('admin.login');

//redirect
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

Route::group(['prefix' => 'admin'], function(){
    //guest route
    Route::group(['middleware' => 'admin.guest'],function(){

        //admin login
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        //validation
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    //protected pages routes - after login admin
    Route::group(['middleware' => 'admin.auth'],function(){


        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        //categories routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

        //sub category
        Route::get('/sub-category', [SubCategoryController::class, 'index'])->name('sub-category.index');
        Route::get('/sub-category/create', [SubCategoryController::class, 'create'])->name('sub-categories.create');
        Route::post('/sub-category/store', [SubCategoryController::class, 'store'])->name('sub-category.store');
        Route::get('/sub-category/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('sub-category.edit');
        Route::put('/sub-category/{subCategory}', [SubCategoryController::class, 'update'])->name('sub-category.update');
        Route::delete('/sub-category/{subCategory}', [SubCategoryController::class, 'destroy'])->name('sub-category.delete');

        //brands
        Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandsController::class, 'store'])->name('brands.store');
        Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
        Route::get('/brands/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}', [BrandsController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandsController::class, 'destroy'])->name('brands.delete');

        //product
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
        //out of stock products
        Route::get('/out-of-stock', [ProductController::class, 'outOfStock'])->name('outOfStock');

        //product ratings
        Route::get('/ratings', [ProductController::class, 'productRatings'])->name('ratings.index');
        Route::delete('/ratings/{rating}', [ProductController::class, 'deleteRating'])->name('ratings.delete');
        Route::get('/rating-view/{id}', [ProductController::class, 'ratingView'])->name('ratingView');
        Route::post('/change-rating-status', [ProductController::class, 'changeRatingStatus'])->name('changeRatingStatus');


        //product images
        Route::get('/products/{productId}/upload', [ProductImageController::class, 'index'])->name('products-image.upload');
        Route::post('/products-image/store', [ProductImageController::class, 'store'])->name('products-image.store');
        Route::get('/product-image/{productImageId}', [ProductImageController::class, 'destroy'])->name('product-image.delete');

        //shipping charge
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{shippingId}/edit', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/{shippingId}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{shippingId}', [ShippingController::class, 'destroy'])->name('shipping.delete');

        //Discount coupon
        Route::get('/discount', [DiscountCouponController::class, 'index'])->name('discount.index');
        Route::get('/discount/create', [DiscountCouponController::class, 'create'])->name('discount.create');
        Route::post('/discount/store', [DiscountCouponController::class, 'store'])->name('discount.store');
        Route::get('/discount/{discountId}/edit', [DiscountCouponController::class, 'edit'])->name('discount.edit');
        Route::put('/discount/{discountId}', [DiscountCouponController::class, 'update'])->name('discount.update');
        Route::delete('/discount/{discountId}', [DiscountCouponController::class, 'destroy'])->name('discount.delete');


        //users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete');

        //pages
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/pages/store', [PageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.delete');


        //order
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail');
        Route::post('/order/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('order.changeOrderStatus');
        Route::post('/order/send-invoice/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('order.sendInvoiceEmail');
        Route::delete('/order/{orderId}', [OrderController::class, 'deleteOrder'])->name('order.delete');
        Route::post('/order/change-paid-status/{id}', [OrderController::class, 'changePaidStatus'])->name('order.changePaidStatus');
        //active orders
        Route::get('/active-order', [OrderController::class, 'activeOrders'])->name('order.active');

        //admin change password
        Route::get('/change-password', [SettingController::class, 'showChangePasswordForm'])->name('showChangePasswordForm');
        Route::post('/process-change-password', [SettingController::class, 'processchangePassword'])->name('processchangePassword');
        Route::post('/admin-image-upload', [SettingController::class, 'adminImageUpload'])->name('adminImageUpload');

        //title and logo
        Route::get('/title-and-logo', [WebSettingController::class, 'titleAndLogo'])->name('titleAndLogo');
        Route::post('/title-and-logo-update', [WebSettingController::class, 'titleAndLogoUpdate'])->name('titleAndLogoUpdate');
        Route::post('/favicon-update', [WebSettingController::class, 'faviconUpdate'])->name('faviconUpdate');

    
        //get product sub category
        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');

        //temp image route
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        // auto fill slug
        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
            ]);
        })->name('getSlug');

    });

});
