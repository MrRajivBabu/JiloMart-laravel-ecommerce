@extends('front.layouts.app2')
@section('title'){{ 'Shop' }}@endsection
@section('customCss')
<style>

</style>
@endsection
@section('content')

<main class="main-wrapper">
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="index-2.html">Home</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">My Account</li>
                        </ul>
                        <h1 class="title">Explore All Products</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start Shop Area  -->
    <div class="axil-shop-area axil-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="axil-shop-sidebar">
                        <div class="d-lg-none">
                            <button class="sidebar-close filter-close-btn"><i class="fas fa-times"></i></button>
                        </div>

                        <div class="toggle-list product-categories active">
                            <h6 class="title">CATEGORIES</h6>
                            <div class="shop-submenu">
                                @if($categories->isNotEmpty())
                                <div class="accordion accordion-flush">
                                    @foreach($categories as $category)
                                    <div class="accordion-item">

                                        <a href="{{ route('shop',$category->slug) }}" class="{{ ($categorySelected == $category->id) ? 'text-primary' : ''  }}">
                                            {{ $category->name }}
                                        </a>
                                        @if($category->sub_category->isNotEmpty())
                                        <span class="collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#category-{{ $category->id }}" style="float:right">
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </span>
                                        @endif
                                        @if($category->sub_category->isNotEmpty())
                                        <div id="category-{{ $category->id }}" class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : '' }}">
                                            <div class="accordion-body">
                                                <div class="navbar-nav">
                                                    @foreach($category->sub_category as $SubCategory)
                                                    <a href="{{ route('shop',[$category->slug,$SubCategory->slug]) }}"
                                                        class="nav-item nav-link {{ ($subCategorySelected == $SubCategory->id) ? 'text-primary' : ''  }}">{{ $SubCategory->name }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                    @endforeach

                                </div>
                                @endif

                            </div>
                        </div>

                        <div class="toggle-list product-categories active" style="padding-bottom:30px">
                            <h6 class="title">BRANDS</h6>
                            <div class="shop-submenu">

                                @if($brands->isNotEmpty())
                                <ul>
                                    <form action="">
                                        @foreach($brands as $brand)
                                        <li>
                                            <input class="brand-label" value="{{ $brand->id }}" type="checkbox" name="brand[]" id="brand-{{ $brand->id }}" {{ (in_array($brand->id, $brandsArray)) ? 'checked': '' }}>
                                            <label for="brand-{{ $brand->id }}">{{ $brand->name }}</label><br>
                                        </li>
                                        @endforeach
                                    </form>
                                </ul>
                                @endif

                            </div>
                        </div>
                        <div class="toggle-list product-price-range active">
                            <h6 class="title">PRICE</h6>
                            <div class="shop-submenu">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                            </div>
                        </div>

                        <a href="{{ route('shop') }}" class="axil-btn btn-bg-primary d-block text-center">All Reset</a>
                    </div>
                    <!-- End .axil-shop-sidebar -->
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="axil-shop-top mb--40">
                                <div
                                    class="category-select align-items-center justify-content-lg-end justify-content-between">
                                    <!-- Start Single Select  -->
                                    <!-- <span class="filter-results">Showing 1-12 of 84 results</span> -->
                                    <select class="single-select" name="sort" id="sort">
                                        <option value="latest" {{ ($sort == 'latest') ? 'selected' : '' }}>Short by Latest</option>
                                        <option value="oldest" {{ ($sort == 'oldest') ? 'selected' : '' }}>Short by Oldest</option>
                                        <option value="price_high" {{ ($sort == 'price_high') ? 'selected' : '' }}>Short by Price High</option>
                                        <option value="price_low" {{ ($sort == 'price_low') ? 'selected' : '' }}>Short by Price Low</option>
                                    </select>
                                    <!-- End Single Select  -->
                                </div>
                                <div class="d-lg-none">
                                    <button class="product-filter-mobile filter-toggle"><i class="fas fa-filter"></i>
                                        FILTER</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                    <div class="row row--15">

                        @if($products->isNotEmpty())
                        @foreach($products as $product)
                        <div class="col-xl-4 col-sm-6">
                            <div class="axil-product product-style-one mb--30">
                                <div class="thumbnail">
                                    <a href="{{ route('product',$product->slug) }}">
                                        <img src="{{ asset('uploads/product/thumbnail/'.$product->image) }}"
                                            alt="Product Images">
                                    </a>
                                    <div class="label-block label-right">
                                        @if($product->compare_price !== $product->price)
                                        <div class="product-badget">
                                            {{ ceil(($product->compare_price - $product->price)/$product->compare_price *100) }}%
                                            OFF
                                        </div>
                                        @endif
                                    </div>
                                    <div class="product-hover-action">
                                        <ul class="cart-action">
                                            <li class="wishlist"><a href="javascript:void(0);" onclick="addToWishlist({{ $product->id }})"><i
                                                        class="far fa-heart"></i></a></li>
                                            <li class="select-option cart-dropdown-btn"><a href="javascript:void(0);" onclick="addToCart({{ $product->id }});">Add to Cart</a></li>
                                            <li class="quickview"><button class="product_view" value="{{ $product->id }}"><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></button></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="inner">
                                        <h5 class="title"><a
                                                href="{{ route('product',$product->slug) }}">{{ Illuminate\Support\Str::limit($product->title, 50) }}</a></h5>
                                        <div class="product-price-variant">
                                            <span class="price current-price">${{ $product->price }}</span>
                                            @if($product->compare_price !== $product->price)
                                            <span class="price old-price">${{ $product->compare_price }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product  -->
                        @endforeach
                        @endif

                    </div>
                    <div class="text-center pt--20">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- End .container -->
    </div>
    <!-- End Shop Area  -->

    @endsection

    @section('customJs')
    <script>
        // price range slider
        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 1000,
            from: {{ $priceMin }},
            step: 10,
            to: {{ $priceMax }},
            skin: "round",
            max_postfix: "+",
            prefix: "$",
            onFinish: function() {
                apply_filters();
            }
        });

        var slider = $(".js-range-slider").data("ionRangeSlider");

        // brand filter
        $(".brand-label").change(function(){
            apply_filters();
        });

        // sort by latest - filter
        $("#sort").change(function(){
            apply_filters();
        });

        function apply_filters(){
            var brands = [];
            $(".brand-label").each(function() {
                if ($(this).is(":checked") == true) {
                    brands.push($(this).val());
                }
            });
            console.log(brands.toString());
            var url = '{{ url()->current() }}?';

            //price range slider
            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

            // brand filter
            if (brands.length > 0) {
                url += '&brands='+brands.toString();
            }

            //search filter not clear when other filter apply
            var keyword = $("#product-search").val();
            if (keyword.length > 0) {
                url += '&product-search='+keyword;
            }

            // sort by latest - filter
            url += '&sort='+$("#sort").val();

            window.location.href = url;
        }


    </script>
    @endsection


