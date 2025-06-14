@extends('front.layouts.app2')
@section('title'){{ $product->title }}@endsection
@section('customCss')
<style>
    .full-description {
        font-size: var(--font-size-b1);
        line-height: var(--line-height-b1);
        font-weight: var(--p-regular);
        color: #777777;
        margin: 0 0 30px;
    }
    
    input[type=radio]~label {
        position: unset;
        font-size: unset;
        line-height: 20px;
        color: #ccc;
        font-weight: 500;
        padding-left: unset;
        cursor: pointer;
    }
</style>
@endsection
@section('content')

<main class="main-wrapper">
    <!-- Start Shop Area  -->
    <div class="axil-single-product-area axil-section-gap pb--0 bg-color-white">
        <div class="single-product-thumb mb--40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mb--40">
                        <div class="row">
                            <div class="col-lg-10 order-lg-2">
                                <div class="single-product-thumbnail-wrap zoom-gallery">

                                    <div class="single-product-thumbnail product-large-thumbnail-3 axil-product">
                                        <!-- product thumbnail image-->
                                        <div class="thumbnail">
                                            <a href="{{ asset('uploads/product/thumbnail/'.$product->image) }}"
                                                class="popup-zoom">
                                                <img src="{{ asset('uploads/product/thumbnail/'.$product->image) }}"
                                                    alt="Product Images">
                                            </a>
                                        </div>
                                        <!-- product gallery images -->
                                        @if($product->product_images->isNotEmpty())
                                        @foreach($product->product_images as $product_image)
                                        <div class="thumbnail">
                                            <a href="{{ asset($product_image->image) }}" class="popup-zoom">
                                                <img src="{{ asset($product_image->image) }}" alt="Product Images">
                                            </a>
                                        </div>
                                        @endforeach
                                        @endif

                                    </div>
                                    <div class="label-block">
                                        @if($product->compare_price !== $product->price)
                                        <div class="product-badget">
                                            {{ ceil(($product->compare_price - $product->price)/$product->compare_price *100) }}%
                                            OFF
                                        </div>
                                        @endif
                                    </div>
                                    <!-- <div class="product-quick-view position-view">
                                        <a href="{{ asset('front-assets/images/product/product-big-01.png') }}"
                                            class="popup-zoom">
                                            <i class="far fa-search-plus"></i>
                                        </a>
                                    </div> -->

                                </div>
                            </div>
                            <div class="col-lg-2 order-lg-1">
                                <div class="product-small-thumb-3 small-thumb-wrapper">

                                    <div class="small-thumb-img">
                                        <img src="{{ asset('uploads/product/thumbnail/'.$product->image) }}"
                                            alt="thumb image">
                                    </div>

                                    @if($product->product_images->isNotEmpty())
                                    @foreach($product->product_images as $key=> $product_image)
                                    <div class="small-thumb-img">
                                        <img src="{{ asset($product_image->image) }}" alt="thumb image">
                                    </div>
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mb--40">
                        <div class="single-product-content">
                            <div class="inner">
                                <h2 class="product-title">{{ $product->title }}</h2>
                                <span class="price-amount">
                                    ${{ $product->price }} -
                                    @if($product->compare_price !== $product->price)
                                    <del>${{ $product->compare_price }}</del>
                                    @endif
                                </span>
                                @if($countProductRating > 0)
                                <div class="product-rating">
                                    {{-- average rating stars --}}
                                    @if ($averegeRating >= 5)
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    @elseif($averegeRating >= 4)
                                    <div class="star-rating">
                                        <i class="far fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    @elseif($averegeRating >= 3)
                                    <div class="star-rating">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    @elseif($averegeRating >= 2)
                                    <div class="star-rating">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    @elseif($averegeRating >= 1)
                                    <div class="star-rating">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    @else

                                    @endif

                                    <div class="review-link">
                                        <a href="#" style="margin-left:5px">
                                            {{-- rating total count  --}}
                                            (<span>{{ $countProductRating }}</span> customer reviews)
                                        </a>
                                    </div>
                                </div>
                                @endif
                                <ul class="product-meta">
                                    <li>
                                        @if ($product->qty > 0)
                                        <span class="badge bg-primary rounded-pill px-4 fs-4 fw-normal">In stock</span>
                                        @elseif($product->qty <= 0) <span
                                            class="badge bg-danger rounded-pill px-4 fs-4 fw-normal">Out Of stock</span>
                                            @else

                                            @endif

                                    </li><br>
                                    <li><i class="fal fa-check"></i>Free delivery available</li>
                                    <li><i class="fal fa-check"></i>Sales 30% Off Use Code: MOTIVE30</li>
                                </ul>
                                <p class="description">{{ strip_tags($product->short_description) }}</p>

                                <div class="product-variations-wrapper">

                                    <!-- Start Product Variation  -->
                                    <!-- <div class="product-variation">
                                            <h6 class="title">Colors:</h6>
                                            <div class="color-variant-wrapper">
                                                <ul class="color-variant">
                                                    <li class="color-extra-01 active"><span><span class="color"></span></span>
                                                    </li>
                                                    <li class="color-extra-02"><span><span class="color"></span></span>
                                                    </li>
                                                    <li class="color-extra-03"><span><span class="color"></span></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div> -->
                                    <!-- End Product Variation  -->

                                    <!-- Start Product Variation  -->
                                    <!-- <div class="product-variation product-size-variation">
                                            <h6 class="title">Size:</h6>
                                            <ul class="range-variant">
                                                <li>xs</li>
                                                <li>s</li>
                                                <li>m</li>
                                                <li>l</li>
                                                <li>xl</li>
                                            </ul>
                                        </div> -->
                                    <!-- End Product Variation  -->

                                </div>

                                <!-- Start Product Action Wrapper  -->
                                <div class="product-action-wrapper d-flex-center">
                                    <!-- Start Quentity Action  -->
                                    
                                    <div class="pro-qty">
                                        <form id="addToCartForm" name="addToCartForm">
                                        <span class="input-group-btn"><button type="button" class="dec qtybtn sub cart-input-button">-</button></span>

                                        <input type="number" name="quantity_number" class="quantity-input cart-input" value="1" readonly>
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <span class="input-group-btn"><button type="button" class="inc qtybtn add cart-input-button">+</button></span>

                                    </div>
                                    <!-- End Quentity Action  -->

                                    <!-- Start Product Action  -->
                                    <ul class="product-action d-flex-center mb--0">
                                        <li class="add-to-cart">
                                            <button type="submit" href="javascript:void(0);" class="axil-btn btn-bg-primary">Add
                                                to Cart
                                            </button>
                                        </li>
                                        </form>
                                        <li class="wishlist"><a href="javascript:void(0);"
                                                onclick="addToWishlist({{ $product->id }})"
                                                class="axil-btn wishlist-btn"><i class="far fa-heart"></i></a></li>
                                    </ul>
                                    
                                    <!-- End Product Action  -->

                                </div>
                                <!-- End Product Action Wrapper  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .single-product-thumb -->

        <div class="woocommerce-tabs wc-tabs-wrapper bg-vista-white">
            <div class="container">
                <ul class="nav tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab"
                            aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                            aria-selected="false">Reviews</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                        aria-labelledby="description-tab">
                        <div class="product-desc-wrapper">
                            <div class="row">
                                <div class="mb--30">
                                    <div class="single-desc">
                                        <h5 class="title">Specifications:</h5>
                                        <p>{{ strip_tags($product->description) }}</p>
                                    </div>
                                </div>
                                <!-- End .col-lg-6 -->
                                <div class="mb--30">
                                    <div class="single-desc">
                                        <h5 class="title">Shipping & Returns:</h5>
                                        <p>{{ strip_tags($product->shipping_returns) }}</p>
                                    </div>
                                </div>
                                <!-- End .col-lg-6 -->
                            </div>
                            <!-- End .row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="pro-des-features">
                                        <li class="single-features">
                                            <div class="icon">
                                                <img src="{{ asset('front-assets/images/product/product-thumb/icon-3.png') }}"
                                                    alt="icon">
                                            </div>
                                            Easy Returns
                                        </li>
                                        <li class="single-features">
                                            <div class="icon">
                                                <img src="{{ asset('front-assets/images/product/product-thumb/icon-2.png') }}"
                                                    alt="icon">
                                            </div>
                                            Quality Service
                                        </li>
                                        <li class="single-features">
                                            <div class="icon">
                                                <img src="{{ asset('front-assets/images/product/product-thumb/icon-1.png') }}"
                                                    alt="icon">
                                            </div>
                                            Original Product
                                        </li>
                                    </ul>
                                    <!-- End .pro-des-features -->
                                </div>
                            </div>
                            <!-- End .row -->
                        </div>
                        <!-- End .product-desc-wrapper -->
                    </div>

                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews-wrapper">
                            <div class="row">
                                <div class="col-lg-6 mb--40">
                                    <div class="axil-comment-area pro-desc-commnet-area">
                                        @if($averegeRating>0)
                                        <h5 class="title">{{ $countProductRating }} Review for this
                                            product
                                            @if($averegeRating>0)
                                            ({{ $averegeRating }})
                                            @endif
                                        </h5>
                                        @else()
                                        <h5 class="title">Haven't given any reviews yet.</h5>
                                        @endif
                                        <ul class="comment-list" id="results-wrapper">

                                            <!-- Start Single Comment  -->
                                            @if ($productRatings->isNotEmpty())
                                            @foreach ($productRatings as $rating)
                                            <li class="comment">
                                                <div class="comment-body">
                                                    <div class="single-comment">
                                                        {{-- <div class="comment-img">
                                                            <img src="{{ asset('front-assets/images/blog/author-image-4.png') }}"
                                                        alt="Author Images">
                                                    </div> --}}
                                                    <div class="comment-inner">
                                                        <h6 class="commenter">
                                                            <a class="hover-flip-item-wrapper">
                                                                <span class="hover-flip-item">
                                                                    <span data-text="Cameron Williamson">
                                                                        {{ $rating->name }}</span>
                                                                </span>
                                                            </a>
                                                            {{-- rating stars --}}
                                                            @if ($rating->rating == 5)
                                                            <span class="commenter-rating">
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                            </span>
                                                            @elseif($rating->rating == 4)
                                                            <span class="commenter-rating">
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                            </span>
                                                            @elseif($rating->rating == 3)
                                                            <span class="commenter-rating">
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                            </span>
                                                            @elseif($rating->rating == 2)
                                                            <span class="commenter-rating">
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                            </span>
                                                            @else
                                                            <span class="commenter-rating">
                                                                <a href="#"><i class="fas fa-star"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                                <a href="#"><i class="fas fa-star empty-rating"></i></a>
                                                            </span>
                                                            @endif

                                                        </h6>
                                                        <div class="comment-text">
                                                            <p>“{{ $rating->comment }}”
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                    </li>
                                    @endforeach
                                    @else

                                    @endif

                                    <!-- End Single Comment  -->
                                    
                                    </ul>
                                    
                                    
                                </div>
                                <div class="text-center pt--20" id="pagination-wrapper">
                                    {{ $productRatings->withQueryString()->links() }}
                                </div>
                                <!-- End .axil-commnet-area -->
                            </div>
                            <!-- End .col -->
                            <div class="col-lg-6 mb--40">
                                <!-- Start Comment Respond  -->
                                <div class="comment-respond pro-des-commend-respond mt--0">
                                    <h5 class="title mb--30">Add a Review</h5>
                                    <p>Your email address will not be published. Required fields are marked *</p>
                                    <form id="ratingForm" name="ratingForm">
                                        <div class="rating-wrapper d-flex-center mb--40">
                                            Your Rating <span class="require">*</span>

                                            {{-- rating star input --}}
                                            <div class="star-rating" id="star-rating">
                                                <input type="radio" id="5-stars" name="rating" value="5" />
                                                <label for="5-stars" class="star">&#9733;</label>
                                                <input type="radio" id="4-stars" name="rating" value="4" />
                                                <label for="4-stars" class="star">&#9733;</label>
                                                <input type="radio" id="3-stars" name="rating" value="3" />
                                                <label for="3-stars" class="star">&#9733;</label>
                                                <input type="radio" id="2-stars" name="rating" value="2" />
                                                <label for="2-stars" class="star">&#9733;</label>
                                                <input type="radio" id="1-star" name="rating" value="1" />
                                                <label for="1-star" class="star">&#9733;</label>
                                            </div>
                                            <p></p>
                                            {{-- //rating star input --}}

                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Write Comment <span class="require">*</label>
                                                    <textarea name="comment" id="comment"
                                                        placeholder="Your Comment"></textarea>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Name <span class="require">*</span></label>
                                                    <input value="@if(Auth::check() == true){{ $userData->name }}@endif" name="name" id="name" type="text">
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Email <span class="require">*</span> </label>
                                                    <input value="@if(Auth::check() == true){{ $userData->email }}@endif" name="email" id="email" type="email">
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-submit">
                                                    <button type="submit" id="rating-submit-btn"
                                                        class="axil-btn btn-bg-primary w-auto">Submit
                                                        Review</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- End Comment Respond  -->
                            </div>
                            <!-- End .col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- woocommerce-tabs -->

    </div>
    <!-- End Shop Area  -->

    <!-- Start Related Product Area  -->
    @if(!empty($relatedProducts))
    <div class="axil-product-area bg-color-white axil-section-gap pb--50 pb_sm--30">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="title-highlighter highlighter-primary"><i class="far fa-shopping-basket"></i> Your
                    Can View</span>
                <h2 class="title">Relateded Products</h2>
            </div>
            <div class="recent-product-activation slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                @foreach($relatedProducts as $relatedProduct)
                <div class="slick-single-layout">
                    <div class="axil-product">
                        <div class="thumbnail">
                            @if($relatedProduct->image)
                            <a href="{{ route('product',$relatedProduct->slug) }}">
                                <img src="{{ asset('uploads/product/thumbnail/'.$relatedProduct->image) }}"
                                    alt="Product Images">
                            </a>
                            @endif
                            <div class="label-block label-right">
                                @if($relatedProduct->compare_price !== $relatedProduct->price)
                                <div class="product-badget">
                                    {{ ceil(($relatedProduct->compare_price - $relatedProduct->price)/$relatedProduct->compare_price *100) }}%
                                    OFF
                                </div>
                                @endif
                            </div>
                            <div class="product-hover-action">
                                <ul class="cart-action">
                                    <li class="wishlist"><a href="javascript:void(0);"
                                            onclick="addToWishlist({{ $relatedProduct->id }})"><i class="far fa-heart"></i></a>
                                    </li>
                                    <li class="select-option cart-dropdown-btn"><a href="javascript:void(0);"
                                            onclick="addToCart({{ $relatedProduct->id }});">Add to Cart</a></li>
                                    <li class="quickview"><button class="product_view" value="{{ $relatedProduct->id }}"><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></button></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="inner">
                                <h5 class="title"><a
                                        href="{{ route('product',$relatedProduct->slug) }}">{{ Illuminate\Support\Str::limit($relatedProduct->title, 50) }}</a>
                                </h5>
                                <div class="product-price-variant">
                                    @if($relatedProduct->compare_price !== $relatedProduct->price)
                                    <span class="price old-price">${{ $relatedProduct->compare_price }}</span>
                                    @endif
                                    <span class="price current-price">${{ $relatedProduct->price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End .slick-single-layout -->

            </div>
        </div>
    </div>
    @endif
    <!-- End Related Product Area  -->

    @endsection

    @section('customJs')
    <script>
        $("#ratingForm").submit(function(event) {
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: "{{ route('submitRating',$product->id) }}",
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);
                    var errors = response.errors;
                    if (response.status == "not_logged_in") {
                        window.location.href = "{{ route('login') }}";
                    }
                    if (response.status == true) {
                        location.reload();
                    } else {
                        //show errors
                        if (errors.name) {
                            $("#name").addClass('is-invalid').siblings('p').html(errors
                                .name).addClass('invalid-feedback');
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p').html('').removeClass(
                                'invalid-feedback');
                        }
                        if (errors.email) {
                            $("#email").addClass('is-invalid').siblings('p').html(errors
                                .email).addClass('invalid-feedback');
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p').html('')
                                .removeClass(
                                    'invalid-feedback');
                        }
                        if (errors.comment) {
                            $("#comment").addClass('is-invalid').siblings('p').html(errors
                                .comment).addClass('invalid-feedback');
                        } else {
                            $("#comment").removeClass('is-invalid').siblings('p').html('')
                                .removeClass(
                                    'invalid-feedback');
                        }
                        if (errors.rating) {
                            $("#star-rating").addClass('is-invalid').siblings('p').html(errors
                                .rating).addClass('invalid-feedback');
                        } else {
                            $("#star-rating").removeClass('is-invalid').siblings('p').html('')
                                .removeClass(
                                    'invalid-feedback');
                        }
                    }
                }
            });
        });

        //rating pagination without page refresh
        $(document).on('click', '#pagination-wrapper a', function(e){e.preventDefault();
            $('#results-wrapper').load($(this).attr('href') + ' #results-wrapper');//result div id
            $('#pagination-wrapper').load($(this).attr('href') + ' #pagination-wrapper');//pagination div id
        });

        //for increase or decrease quantity input
        $(".input-group-btn").on("click", function() {
        var $button = $(this);
        var $parent = $button.parent(); 
        var oldValue = $parent.find('.cart-input').val();

        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
            } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
                } else {
                newVal = 1;
            }
            }
            $parent.find('.cart-input').val(newVal);
        });

        //add to cart form
        $('#addToCartForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $.ajax({
                url: "{{ route('addToCartFromSingle') }}",
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if(response.status == true){
                        location.reload();
                    }else{
                        location.reload();
                    }
                }
            })
        });


    </script>
    @endsection
