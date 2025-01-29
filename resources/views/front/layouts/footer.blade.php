</main>

<div class="service-area mt-5">
    <div class="container">
        <div class="row row-cols-xl-4 row-cols-sm-2 row-cols-1 row--20">
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service1.png') }}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Fast &amp; Secure Delivery</h6>
                        <p>Tell about your service.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service2.png') }}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Money Back Guarantee</h6>
                        <p>Within 10 days.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service3.png') }}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">24 Hour Return Policy</h6>
                        <p>No question ask.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="service-box service-style-2">
                    <div class="icon">
                        <img src="{{ asset('front-assets/images/icons/service4.png') }}" alt="Service">
                    </div>
                    <div class="content">
                        <h6 class="title">Pro Quality Support</h6>
                        <p>24/7 Live support.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Start Footer Area  -->
<footer class="axil-footer-area footer-style-2">
    <!-- Start Footer Top Area  -->
    <div class="footer-top separator-top">
        <div class="container">
            <div class="row">
                <!-- Start Single Widget  -->
                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">Support</h5>
                        <!-- <div class="logo mb--30">
                            <a href="index.html">
                                <img class="light-logo" src="{{ asset('front-assets/images/logo/logo.png') }}" alt="Logo Images">
                            </a>
                        </div> -->
                        <div class="inner">
                            <p>685 Market Street, <br>
                                Las Vegas, LA 95820, <br>
                                United States.
                            </p>
                            <ul class="support-list-item">
                                <li><a href="mailto:example@domain.com"><i class="fal fa-envelope-open"></i>
                                        example@domain.com</a></li>
                                <li><a href="tel:(+01)850-315-5862"><i class="fal fa-phone-alt"></i> (+01)
                                        850-315-5862</a></li>
                                <!-- <li><i class="fal fa-map-marker-alt"></i> 685 Market Street,  <br> Las Vegas, LA 95820, <br> United States.</li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Widget  -->
                <!-- Start Single Widget  -->
                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">Account</h5>
                        <div class="inner">
                            <ul>
                                <li><a href="my-account.html">My Account</a></li>
                                <li><a href="sign-up.html">Login / Register</a></li>
                                <li><a href="cart.html">Cart</a></li>
                                <li><a href="wishlist.html">Wishlist</a></li>
                                <li><a href="shop.html">Shop</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Widget  -->
                <!-- Start Single Widget  -->
                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">Useful Link</h5>
                        <div class="inner">
                            <ul>
                                @if(staticPages()->isNotEmpty())
                                    @foreach(staticPages() as $page)
                                    <li><a href="{{ route('page',$page->slug) }}">{{ $page->name }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Widget  -->
                <!-- Start Single Widget  -->
                <div class="col-lg-3 col-sm-6">
                    <div class="axil-footer-widget">
                        <h5 class="widget-title">Download App</h5>
                        <div class="inner">
                            <span>Save $3 With App & New User only</span>
                            <div class="download-btn-group">
                                <div class="qr-code">
                                    <img src="{{ asset('front-assets/images/others/qr.png') }}" alt="Axilthemes">
                                </div>
                                <div class="app-link">
                                    <a href="#">
                                        <img src="{{ asset('front-assets/images/others/app-store.png') }}"
                                            alt="App Store">
                                    </a>
                                    <a href="#">
                                        <img src="{{ asset('front-assets/images/others/play-store.png') }}"
                                            alt="Play Store">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Widget  -->
            </div>
        </div>
    </div>
    <!-- End Footer Top Area  -->
    <!-- Start Copyright Area  -->
    <div class="copyright-area copyright-default separator-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4">
                    <div class="social-share">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="copyright-left d-flex flex-wrap justify-content-center">
                        <ul class="quick-link">
                            <li>© 2023. All rights reserved by <a target="_blank"
                                    href="https://axilthemes.com/">Axilthemes</a>.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div
                        class="copyright-right d-flex flex-wrap justify-content-xl-end justify-content-center align-items-center">
                        <span class="card-text">Accept For</span>
                        <ul class="payment-icons-bottom quick-link">
                            <li><img src="{{ asset('front-assets/images/icons/cart/cart-1.png') }}" alt="paypal cart">
                            </li>
                            <li><img src="{{ asset('front-assets/images/icons/cart/cart-2.png') }}" alt="paypal cart">
                            </li>
                            <li><img src="{{ asset('front-assets/images/icons/cart/cart-5.png') }}" alt="paypal cart">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copyright Area  -->
</footer>
<!-- End Footer Area  -->

<!-- Product Quick View Modal Start -->
<div class="modal fade quick-view-product" id="quick-view-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="far fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="single-product-thumb">
                    <div class="row">
                        <div class="col-lg-7 mb--40">
                            <div class="row">
                                <div class="col-lg-12 order-lg-2">
                                    <div
                                        class="single-product-thumbnail product-large-thumbnail axil-product thumbnail-badge zoom-gallery" id="single_product_large_images">

                                        <div class="thumbnail">
                                            <div id="single_product_image">
                                                
                                            </div>
                                            <div class="label-block label-right" id="single_product_discount">
                                                
                                            </div>
                                            <div class="product-quick-view position-view" id="single_product_small_image">
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-5 mb--40">
                            <div class="single-product-content">
                                <div class="inner">
                                    <div class="product-rating">
                                        <div class="star-rating" id="single_p_rate">
                                            
                                        </div>
                                        <div class="review-link" style="margin-left:5px" id="single_p_rate_count">
                                            
                                        </div>
                                    </div>
                                    <h3 class="product-title" id="product-view-title"></h3>
                                    <span class="price-amount">
                                        $<span id="single_product_price"></span> - 
                                        $<del id="single_product_compare_price"></del>
                                    </span>
                                    <ul class="product-meta">
                                        <li>
                                            <span id="single_product_stock_available" class="badge bg-primary rounded-pill px-4 fs-4 fw-normal"></span>
                                            <span id="single_product_stock_unavailable" class="badge bg-danger rounded-pill px-4 fs-4 fw-normal"></span>
                                        </li>
                                        <li><i class="fal fa-check"></i>Free delivery available</li>
                                        <li><i class="fal fa-check"></i>Sales 30% Off Use Code: MOTIVE30</li>
                                    </ul>
                                    <p class="description" id="product_short_description"></p>

                                    <!-- Start Product Action Wrapper  -->
                                    <div class="product-action-wrapper d-flex-center">

                                        <!-- Start Product Action  -->
                                        <ul class="product-action d-flex-center mb--0">
                                            <li class="add-to-cart cart-dropdown-btn" id="single_p_add_cart">
                                                
                                            </li>
                                            <li class="wishlist" id="single_p_add_wishlist">
                                                
                                            </li>
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
        </div>
    </div>
</div>
<!-- Product Quick View Modal End -->

<!-- Header Search Modal Start -->
<div class="header-search-modal" id="header-search-modal">
    <button class="card-close sidebar-close"><i class="fas fa-times"></i></button>
    <div class="header-search-wrap">
        <div class="card-header">
            <form action="{{ route('shop') }}">
                <div class="input-group">
                    <input value="{{ Request::get('product-search') }}" type="search" class="form-control"
                        name="product-search" id="product-search" placeholder="Write Something....">
                    <button type="submit" class="axil-btn btn-bg-primary"><i class="far fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="card-body" id="live-search-result">
            <div class="search-result-header">
                <h6 class="title" id="live-search-count"></h6>
                <span id="live-search-view-all"></span>
            </div>
            <div class="psearch-results" id="psearch-results">
                @if(getProducts()->isNotEmpty())
                @foreach(getProducts() as $product)
                <div class="axil-product-list">
                    <div class="thumbnail">
                        <a href="{{ route('product',$product->slug) }}">
                            <img src="{{ asset('uploads/product/thumbnail/'.$product->image) }}" width="120px">
                        </a>
                    </div>
                    <div class="product-content">
                        <div class="product-rating">
                            <span class="rating-icon">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fal fa-star"></i>
                            </span>
                            <span class="rating-number"><span>100+</span> Reviews</span>
                        </div>
                        <h6 class="product-title"><a href="{{ route('product',$product->slug) }}">{{ substr($product->title, 0, 22) }}</a></h6>
                        <div class="product-price-variant">
                            <span class="price current-price">${{ number_format($product->price,2) }}</span>
                            <span class="price old-price">${{ number_format($product->compare_price,2) }}</span>
                        </div>
                        <div class="product-cart">
                            <a href="{{ route('product',$product->slug) }}" class="cart-btn"><i class="far fa-eye"></i></a>
                            <a href="javascript:void(0);" onclick="addToWishlist({{ $product->id }})" class="cart-btn"><i class="fal fa-heart"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Header Search Modal End -->

{{-- cart modal  --}}
<div class="cart-dropdown" id="cart-dropdown">
    <div class="cart-content-wrap">

        <div class="cart-header">

            <h2 class="header-title">Cart review</h2>
            <button class="cart-close sidebar-close"><i class="fas fa-times"></i></button>

        </div>
        <div id="side_cart_alert">

        </div>

        <div class="cart-body">

            <ul class="cart-item-list">
                @if(getCartContent()->isNotEmpty())
                @foreach(getCartContent() as $CartContent)
                <li class="cart-item">
                    <div class="item-img">
                        <a href="single-product.html"><img
                                src="{{ asset('uploads/product/thumbnail/'.$CartContent->options->image) }}" alt=""></a>
                        <button class="close-btn" onclick="removeNowCart('{{ $CartContent->rowId }}')"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="item-content">
                        <h3 class="item-title"><a href="single-product-3.html">{{ $CartContent->name }}</a></h3>
                        <div class="item-price"><span class="currency-symbol">$</span>{{ $CartContent->price }}</div>
                        <div class="pro-qty item-quantity">
                            <span class="input-group-btn"><button class="dec qtybtn sub_cart"
                                    data-id="{{ $CartContent->rowId }}">-</button></span>

                            <input type="text" class="quantity-input" value="{{ $CartContent->qty }}" disabled>

                            <span class="input-group-btn"><button class="inc qtybtn add_cart"
                                    data-id="{{ $CartContent->rowId }}">+</button></span>

                            {{-- <span class="item-price" style="margin-right: 10px;font-size: 10px">X</span>
                            <span class="item-price" style="font-size: 20px">{{ $CartContent->qty }}</span> --}}
                        </div>
                    </div>
                </li>
                @endforeach
                @else
                <div class="axil-product-cart-wrap">
                    <div class="product-table-heading justify-content-center">
                        <h5 class="title">Your Cart Is Empty.</h5>
                    </div>
                </div>

                @endif

            </ul>

        </div>
        <div class="cart-footer">
            <h3 class="cart-subtotal">
                <span class="subtotal-title">Subtotal:</span>
                <span class="subtotal-amount">${{ Cart::subtotal() }}</span>
            </h3>
            <div class="group-btn">
                <a href="{{ route('cart') }}" class="axil-btn btn-bg-primary viewcart-btn">View Cart</a>
                <a href="{{ route('checkout') }}" class="axil-btn btn-bg-secondary checkout-btn">Checkout</a>
            </div>
        </div>
    </div>
</div>

{{-- edit address modal  --}}

<div class="modal fade quick-view-product" id="edit-address-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="far fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="adressUpdateForm" name="adressUpdateForm"  class="account-details-form">
                <div class="single-product-thumb">
                    <div class="row mb-5" style="margin-top: -10px">
                        
                            <h5 class="title">Change Address</h5>
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input type="text" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->first_name : '' }}" id="first_name" name="first_name">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input type="text" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->last_name : '' }}" id="last_name" name="last_name">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->email : '' }}" id="email" name="email">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input type="text" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->mobile : '' }}" id="mobile" name="mobile">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <select name="country_id" id="country_id">
                                    @if (!empty($countries))
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ (!empty($userAddress) && $userAddress->country_id == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>State</label>
                                <input type="text" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->state : '' }}" id="state" name="state">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" id="address" class="form-control">{{ (!empty($userAddress)) ? $userAddress->address : '' }}</textarea>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Apartment</label>
                                <input type="text" class="form-control" id="apartment" name="apartment" value="{{ (!empty($userAddress)) ? $userAddress->apartment : '' }}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->city : '' }}" id="city" name="city">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Zip Code</label>
                                <input type="text" class="form-control" value="{{ (!empty($userAddress)) ? $userAddress->zip : '' }}" id="zip" name="zip">
                                <p></p>
                            </div>
                            <div class="form-group mb--0">
                                <input type="submit" class="axil-btn" value="Save Changes">
                                <p></p>
                            </div>
                        
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
