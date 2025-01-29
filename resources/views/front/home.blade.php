@extends('front.layouts.app')

@section('title'){{ 'Home' }}@endsection
@section('content')

<main class="main-wrapper">

<!-- Start Slider Area -->
<div class="axil-main-slider-area main-slider-style-2">
    <div class="container">
        <div class="slider-offset-left">
            <div class="row row--20">
                <div class="col-lg-9">
                    <div class="slider-box-wrap">
                        <div class="slider-activation-one axil-slick-dots">
                            <div class="single-slide slick-slide">
                                <div class="main-slider-content">
                                    <span class="subtitle"><i class="fal fa-headset"></i> Headphone</span>
                                    <h1 class="title">Wireless Headphone</h1>
                                    <div class="shop-btn">
                                        <a href="shop.html" class="axil-btn">Shop Now <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="main-slider-thumb">
                                    <img src="{{ asset('front-assets/images/product/product-38.png') }}" alt="Product">
                                </div>
                            </div>
                            <div class="single-slide slick-slide">
                                <div class="main-slider-content">
                                    <span class="subtitle"><i class="fal fa-watch"></i> Smartwatch</span>
                                    <h1 class="title">Bloosom Smat Watch</h1>
                                    <div class="shop-btn">
                                        <a href="shop.html" class="axil-btn">Shop Now <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="main-slider-thumb">
                                    <img src="{{ asset('front-assets/images/product/product-40.png') }}" alt="Product">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="slider-product-box">
                        <div class="product-thumb">
                            <a href="single-product.html">
                                <img src="{{ asset('front-assets/images/product/product-46.png') }}" alt="Product">
                            </a>
                        </div>
                        <h6 class="title"><a href="single-product.html">T900 Ultra 2 Full Touch Screen Smart Watch Bluetooth Calls Watch</a></h6>
                        <span class="price">$29.99</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Slider Area -->

<div class="service-area">
    <div class="container">
        <div class="row row-cols-xl-5 row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 row--20">
            <div class="col">
                <div class="service-box">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service1.png') }}" alt="Service">
                    </div>
                    <h6 class="title">Fast &amp; Secure Delivery</h6>
                </div>
            </div>
            <div class="col">
                <div class="service-box">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service2.png') }}" alt="Service">
                    </div>
                    <h6 class="title">100% Guarantee On Product</h6>
                </div>
            </div>
            <div class="col">
                <div class="service-box">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service3.png') }}" alt="Service">
                    </div>
                    <h6 class="title">24 Hour Return Policy</h6>
                </div>
            </div>
            <div class="col">
                <div class="service-box">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service4.png') }}" alt="Service">
                    </div>
                    <h6 class="title">24 Hour Return Policy</h6>
                </div>
            </div>
            <div class="col">
                <div class="service-box">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service5.png') }}" alt="Service">
                    </div>
                    <h6 class="title">Next Level Pro Quality</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start New Arrivals Product Area  -->
@if($newArrivals->isNotEmpty())
<div class="axil-new-arrivals-product-area fullwidth-container bg-color-white axil-section-gap pb--0">
    <div class="container ml--xxl-0">
        <div class="product-area pb--50">
            <div class="section-title-wrapper">
                <span class="title-highlighter highlighter-primary"><i class="far fa-shopping-basket"></i> This Week’s</span>
                <h2 class="title">New Arrivals</h2>
            </div>
            <div class="new-arrivals-product-activation slick-layout-wrapper--15 axil-slick-arrow  arrow-top-slide">

                @foreach($newArrivals as $product)
                <div class="slick-single-layout">
                    <div class="axil-product product-style-four">
                        <div class="thumbnail">
                            @if($product->image)
                            <a href="{{ route('product',$product->slug) }}">
                                <img data-sal="fade" data-sal-delay="100" data-sal-duration="1500" src="{{ asset('uploads/product/thumbnail/'.$product->image) }}" alt="Product Images">
                                <img class="hover-img" src="{{ asset('uploads/product/thumbnail/'.$product->image) }}" alt="Product Images">
                            </a>
                            @endif

                            <div class="label-block label-right">
                            @if($product->compare_price !== $product->price)
                                <div class="product-badget">{{ ceil(($product->compare_price - $product->price)/$product->compare_price *100) }}% OFF</div>
                            @endif
                            </div>

                            <div class="product-hover-action">
                                <ul class="cart-action">
                                    <li class="wishlist"><a href="javascript:void(0);" onclick="addToWishlist({{ $product->id }})"><i class="far fa-heart"></i></a></li>
                                    <li class="select-option cart-dropdown-btn"><a href="javascript:void(0);" onclick="addToCart({{ $product->id }});">Add to Cart</a></li>
                                    <li class="quickview"><button class="product_view" value="{{ $product->id }}"><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></button></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="inner">
                                <h5 class="title"><a href="{{ route('product',$product->slug) }}">{{ Illuminate\Support\Str::limit($product->title, 50) }}</a></h5>
                                <div class="product-price-variant">
                                    @if($product->compare_price !== $product->price)
                                    <span class="price old-price">${{ $product->compare_price }}</span>
                                    @endif
                                    <span class="price current-price">${{ $product->price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endif
<!-- End New Arrivals Product Area  -->

<!-- Start Featured Items Product Area  -->
@if($featuredProducts->isNotEmpty())
<div class="axil-best-seller-product-area bg-color-white axil-section-gap pb--50 pb_sm--30">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="title-highlighter highlighter-secondary"><i class="far fa-shopping-basket"></i>This Month</span>
            <h2 class="title">Featured Items</h2>
        </div>
        <div class="new-arrivals-product-activation-2 product-transparent-layout slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide product-slide-mobile">


        @foreach($featuredProducts as $featuredProduct)
        <div class="slick-single-layout">
                    <div class="axil-product product-style-four">
                        <div class="thumbnail">
                            @if($featuredProduct->image)
                            <a href="{{ route('product',$featuredProduct->slug) }}">
                                <img data-sal="fade" data-sal-delay="100" data-sal-duration="1500" src="{{ asset('uploads/product/thumbnail/'.$featuredProduct->image) }}" alt="Product Images">
                                <img class="hover-img" src="{{ asset('uploads/product/thumbnail/'.$featuredProduct->image) }}" alt="Product Images">
                            </a>
                            @endif
                            <div class="label-block label-right">
                                @if($featuredProduct->compare_price !== $featuredProduct->price)
                                <div class="product-badget">
                                    {{ ceil(($featuredProduct->compare_price - $featuredProduct->price)/$featuredProduct->compare_price *100) }}% OFF
                                </div>
                                @endif
                            </div>
                            <div class="product-hover-action">
                                <ul class="cart-action">
                                    <li class="wishlist"><a href="javascript:void(0);" onclick="addToWishlist({{ $featuredProduct->id }})"><i class="far fa-heart"></i></a></li>
                                    <li class="select-option cart-dropdown-btn"><a href="javascript:void(0);" onclick="addToCart({{ $featuredProduct->id }});">Add to Cart</a></li>
                                    <li class="quickview"><button class="product_view" value="{{ $featuredProduct->id }}"><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></button></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="inner">
                                <h5 class="title"><a href="{{ route('product',$featuredProduct->slug) }}">{{ Illuminate\Support\Str::limit($featuredProduct->title, 50) }}</a></h5>
                                <div class="product-price-variant">
                                    @if($featuredProduct->compare_price !== $featuredProduct->price)
                                    <span class="price old-price">${{ $featuredProduct->compare_price }}</span>
                                    @endif
                                    <span class="price current-price">${{ $featuredProduct->price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

        </div>
    </div>
</div>
@endif
<!-- End  Featured Items Product Area  -->

<!-- Poster Countdown Area  -->
<div class="axil-poster-countdown">
    <div class="container">
        <div class="poster-countdown-wrap bg-lighter">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="poster-countdown-content">
                        <div class="section-title-wrapper">
                            <span class="title-highlighter highlighter-secondary"> <i class="far fa-shopping-basket"></i> Don’t Miss!!</span>
                            <h2 class="title">Let's Shopping Today</h2>
                        </div>
                        <div class="poster-countdown countdown mb--40"></div>
                        <a href="#" class="axil-btn btn-bg-primary">Check it Out!</a>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="poster-countdown-thumbnail">
                        <img src="{{ asset('front-assets/images/product/poster/poster-05.png') }}" alt="Poster Product">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Poster Countdown Area  -->

<!-- Start Expolre Product Area  -->
@if($exploreProducts->isNotEmpty())
<div class="axil-product-area bg-color-white axil-section-gap">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="title-highlighter highlighter-primary"> <i class="far fa-shopping-basket"></i> Our Products</span>
            <h2 class="title">Explore our Products</h2>
        </div>
        <div class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
            <div class="slick-single-layout">
                <div class="row row--15">

                    @foreach($exploreProducts as $exploreProduct)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30">
                        <div class="axil-product product-style-one">
                            <div class="thumbnail">
                                @if($exploreProduct->image)
                                <a href="{{ route('product',$exploreProduct->slug) }}">
                                    <img data-sal="fade" data-sal-delay="100" data-sal-duration="1500" src="{{ asset('uploads/product/thumbnail/'.$exploreProduct->image) }}" alt="Product Images">
                                </a>
                                @endif
                                <div class="label-block label-right">
                                    @if($exploreProduct->compare_price !== $exploreProduct->price)
                                    <div class="product-badget">{{ ceil(($exploreProduct->compare_price - $exploreProduct->price)/$exploreProduct->compare_price *100) }}% Off</div>
                                    @endif
                                </div>
                                <div class="product-hover-action">
                                    <ul class="cart-action">
                                        <li class="quickview"><button class="product_view" value="{{ $exploreProduct->id }}"><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></button></li>
                                        <li class="select-option cart-dropdown-btn"><a href="javascript:void(0);" onclick="addToCart({{ $exploreProduct->id }});">Add to Cart</a></li>
                                        <li class="wishlist"><a href="javascript:void(0);" onclick="addToWishlist({{ $exploreProduct->id }})"><i class="far fa-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="inner">
                                    <h5 class="title"><a href="{{ route('product',$exploreProduct->slug) }}">{{ Illuminate\Support\Str::limit($exploreProduct->title, 50) }}</a></h5>
                                    <div class="product-price-variant">
                                        <span class="price current-price">${{ $exploreProduct->price }}</span>
                                        @if($exploreProduct->compare_price !== $exploreProduct->price)
                                        <span class="price old-price">${{ $exploreProduct->compare_price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- End Single Product  -->
                </div>
            </div>
            <!-- End .slick-single-layout -->
        </div>
        <div class="row">
            <div class="col-lg-12 text-center mt--20 mt_sm--0">
                <a href="shop.html" class="axil-btn btn-bg-lighter btn-load-more">View All Products</a>
            </div>
        </div>

    </div>
</div>
@endif
<!-- End Expolre Product Area  -->





@endsection


