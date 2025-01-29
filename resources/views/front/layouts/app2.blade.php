
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(webData()->favicon) }}">

    <!-- CSS
    ============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/base.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-assets/plugins/ion-range-slider/ion-range-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/plugins/jquerymodal/jquerymodal.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/custom.css') }}">
    @yield('customCss')


</head>

<body>
    <div id="preloader"></div>
    @include('front.layouts.header2')
    @yield('content')

    @include('front.layouts.footer')

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="{{ asset('front-assets/js/vendor/modernizr.min.js') }}"></script>
    <!-- jQuery JS -->
    <script src="{{ asset('front-assets/js/vendor/jquery.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('front-assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/js.cookie.js') }}"></script>
    <!-- <script src="{{ asset('front-assets/js/vendor/jquery.style.switcher.js') }}"></script> -->
    <script src="{{ asset('front-assets/js/vendor/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/sal.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/counterup.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/waypoints.min.js') }}"></script>
    <script src="{{ asset('front-assets/plugins/ion-range-slider/ion-range-slider.js') }}"></script>
    <script src="{{ asset('front-assets/plugins/jquerymodal/jquerymodal.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('front-assets/js/main.js') }}"></script>
    <script src="{{ asset('front-assets/js/custom.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //add to cart
        function addToCart(id) {
            $.ajax({
                url: '{{ route("addToCart") }}',
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        // window.location.href="{{ route('cart') }}";
                        // live show cart number in html without reload
                        $('.cart-item-list').load(location.href + ' .cart-item-list');
                        $('.cart-number').load(window.location.href + ' .cart-number');
                        $('.subtotal-amount').load(window.location.href + ' .subtotal-amount');
                    }
                    successPopup('Added To cart');
                }
            });
        }
        
        //remove item from cart
        function removeNowCart(rowId) {
            $.ajax({
                url: '{{ route("removeCart") }}',
                type: 'post',
                data: {
                    rowId: rowId
                },
                dataType: 'json',
                success: function(response) {
                    $('.cart-item-list').load(location.href + ' .cart-item-list');
                    $('.cart-number').load(window.location.href + ' .cart-number');
                    $('.subtotal-amount').load(window.location.href + ' .subtotal-amount');
                }
            });
        }
        //add button
        $('body').on('click', '.add_cart', function() {
            var qtyElement = $(this).parent().prev(); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue + 1);
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateSiteCart(rowId, newQty)
            }
            //live change data
            $('.subtotal-amount').load(window.location.href + ' .subtotal-amount');
        });
        //minus button
        $('body').on('click', '.sub_cart', function() {
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue - 1);
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateSiteCart(rowId, newQty)
            }
            //live change data
            $('.subtotal-amount').load(window.location.href + ' .subtotal-amount');
        });
        //update cart
        function updateSiteCart(rowId, qty) {
            $.ajax({
                url: '{{ route("updateCart") }}',
                type: 'post',
                data: {
                    rowId: rowId,
                    qty: qty
                },
                dataType: 'json',
                success: function(response) {
                    // window.location.href = "{{ route('cart') }}";
                }
            });
        }

        //add to wishlist
        function addToWishlist(id) {
            $.ajax({
                url: '{{ route("addToWishlist") }}',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success: function(response) {
                    if(response.status == true){
                        location.reload();
                    }
                    else{
                        window.location.href = "{{ route('login') }}"; 
                    }
                    
                }
            });
        }
        // live search 
        $(document).ready(function() {
            $("#product-search").on("keyup", function() {
                var inputVal = $("#product-search").val();
                if (inputVal == "") {
                    $("#psearch-results").html("");
                    $("#live-search-count").html("");
                    $("#live-search-view-all").html('');
                } else {
                    $.ajax({
                        url: '{{ route("liveSearchProduct") }}',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            data: inputVal
                        },
                        success: function(response) {

                            //return live search output in html
                            $("#live-search-count").html(response.resultCount +
                                ' Result Found');
                             
                            $("#live-search-view-all").html(
                                '<a href="/shop?product-search=' + response.keyword +
                                '" class="view-all">View All</a>');
                             

                            //loop result items show
                            $('.psearch-results').html(""); //clear html data first
                            var result = document.getElementById('psearch-results');
                            for (let i = 0; i < response.result.length; i++) {
                                var row = `<div class="axil-product-list">
                            <div class="thumbnail">
                        <a href="/product/${response.result[i].slug}">
                            <img src="/uploads/product/thumbnail/${response.result[i].image}" width="120px">
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
                        <h6 class="product-title"><a href="/product/${response.result[i].slug}">${response.result[i].title.substring(0,60)}</a></h6>
                        <div class="product-price-variant">
                            <span class="price current-price">$${response.result[i].price.toFixed(2)}</span>
                            <span class="price old-price">$${response.result[i].compare_price.toFixed(2)}</span>
                        </div>
                        <div class="product-cart">
                            <a href="/product/${response.result[i].slug}" class="cart-btn"><i class="far fa-eye"></i></a>
                            <a href="javascript:void(0);" onclick="addToWishlist(${response.result[i].id})" class="cart-btn"><i class="fal fa-heart"></i></a>
                        </div>
                    </div>
                </div>`
                                result.innerHTML += row
                            }
                        }
                    });
                }
            });
        });
    </script>


    <script
        src="https://www.paypal.com/sdk/js?client-id=AfOMyE9PzwZDd1uJDzex9zTV71o1Sbf_5Uu9sIw2cN-oXaLV9suCHptG7boZs4UhvSaIsfBxvgleDN2u&buyer-country=US&currency=USD&components=buttons&enable-funding=card&disable-funding=venmo,paylater"
        data-sdk-integration-source="developer-studio"></script>

    @yield('customJs')
    {{-- sweetalert --}}
    @include('sweetalert::alert')

</body>

</html>