@extends('front.layouts.app2')
@section('title'){{ 'Cart' }}@endsection
@section('content')
<main class="main-wrapper">

    <!-- Start Cart Area  -->
    <div class="axil-product-cart-area axil-section-gap">
        <div class="container">
        @if(!empty(Cart::count() > 0))
            <div class="axil-product-cart-wrap">
                <div class="product-table-heading">
                    <h4 class="title">Your Cart</h4>
                    <a href="" class="cart-clear" onclick="clearCart()">Clear Shoping Cart</a>
                </div>
                <div>
                    @include('admin.message')
                </div>
                <div class="table-responsive">
                    <table class="table axil-product-table axil-cart-table mb--40">
                        <thead>
                            <tr>
                                <th scope="col" class="product-remove"></th>
                                <th scope="col" class="product-thumbnail">Product</th>
                                <th scope="col" class="product-title"></th>
                                <th scope="col" class="product-price">Price</th>
                                <th scope="col" class="product-quantity">Quantity</th>
                                <th scope="col" class="product-subtotal">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartContent as $cartItem)
                            <tr>
                                <td class="product-remove"><a href="#" class="remove-wishlist" onclick="removeCart('{{ $cartItem->rowId }}')"><i
                                            class="fal fa-times"></i></a></td>
                                <td class="product-thumbnail"><a href="single-product.html"><img
                                            src="{{ asset('uploads/product/thumbnail/'.$cartItem->options->image) }}"
                                            alt="Digital Product"></a></td>
                                <td class="product-title"><a href="single-product.html">{{ $cartItem->name }}</a></td>
                                <td class="product-price" data-title="Price"><span
                                        class="currency-symbol">$</span>{{ $cartItem->price }}</td>

                                <td class="product-quantity" data-title="Qty">

                                    <div class="pro-qty">

                                        <span class="input-group-btn"><button class="dec qtybtn sub" data-id="{{ $cartItem->rowId }}">-</button></span>

                                        <input type="text" class="quantity-input" value="{{ $cartItem->qty }}" disabled>

                                        <span class="input-group-btn"><button class="inc qtybtn add" data-id="{{ $cartItem->rowId }}">+</button></span>

                                    </div>

                                </td>
                                <td class="product-subtotal" data-title="Subtotal"><span
                                        class="currency-symbol">$</span>{{ $cartItem->price*$cartItem->qty }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- <div class="cart-update-btn-area">
                    <div class="input-group product-cupon">
                        <input placeholder="Enter coupon code" type="text">
                        <div class="product-cupon-btn">
                            <button type="submit" class="axil-btn btn-outline">Apply</button>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-xl-5 col-lg-7 offset-xl-7 offset-lg-5">
                        <div class="axil-order-summery">
                            <h5 class="title mb--20">Order Summary</h5>
                            <div class="summery-table-wrap">
                                <table class="table summery-table mb--30">
                                    <tbody>
                                        <tr class="order-subtotal">
                                            <td>Subtotal</td>
                                            <td>${{ Cart::subtotal() }}</td>
                                        </tr>
                                        <!-- <tr class="order-shipping">
                                            <td>Shipping</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="radio" id="radio1" name="shipping" checked>
                                                    <label for="radio1">Free Shippping</label>
                                                </div>
                                                <div class="input-group">
                                                    <input type="radio" id="radio3" name="shipping" checked>
                                                    <label for="radio3">Regular: $12.00</label>
                                                </div>
                                                <div class="input-group">
                                                    <input type="radio" id="radio2" name="shipping">
                                                    <label for="radio2">Fast: $35.00</label>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr class="order-tax">
                                            <td>State Tax</td>
                                            <td>$8.00</td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>Total</td>
                                            <td class="order-total-amount">$1000</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('checkout') }}" class="axil-btn btn-bg-primary checkout-btn">Process to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
        @include('admin.message')
        <div class="axil-product-cart-wrap">
            <div class="product-table-heading justify-content-center">
                <h2 class="title">Your Cart Is Empty.</h2>
            </div>
        </div>
        @endif
        </div>
    </div>
    <!-- End Cart Area  -->
    @endsection

    @section('customJs')
    <script>

        //add button
        $('body').on('click','.add',function(){
            var qtyElement = $(this).parent().prev(); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue+1);

                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId,newQty)

            }
        });
        //minus button
        $('body').on('click','.sub',function(){
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue-1);

                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId,newQty)
            }
        });


        //update cart
        function updateCart(rowId,qty){
            $.ajax({
                url: '{{ route("updateCart") }}',
                type: 'post',
                data: {rowId:rowId, qty:qty},
                dataType: 'json',
                success: function(response){
                        window.location.href = "{{ route('cart') }}";
                }
            });
        }

        //remove item from cart

            function removeCart(rowId){
                if (confirm("Are You Sure, You Want To Delete?")) {
                    $.ajax({
                        url: '{{ route("removeCart") }}',
                        type: 'post',
                        data: {rowId:rowId},
                        dataType: 'json',
                        success: function(response){
                                window.location.href = "{{ route('cart') }}";
                        }
                    });
                }
            }

            function clearCart(){
                if (confirm("Are You Sure, You Want To Remove All?")) {
                    $.ajax({
                        url: '{{ route("clearCart") }}',
                        type: 'get',
                        data: {},
                        dataType: 'json',
                        success: function(response){
                                window.location.href = "{{ route('cart') }}";
                        }
                    });
                }
            }






    </script>

    @endsection
