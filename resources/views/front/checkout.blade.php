@extends('front.layouts.app2')
@section('title'){{ 'Checkout' }}@endsection
@section('content')
<main class="main-wrapper">

    <!-- Start Checkout Area  -->
    <div class="axil-checkout-area axil-section-gap">
        <div class="container">

            <form id="orderForm" name="orderForm">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="axil-checkout-notice">

                            <div class="axil-toggle-box">
                                <div class="toggle-bar"><i class="fas fa-pencil"></i> Have a coupon? <a
                                        href="javascript:void(0)" class="toggle-btn">Click here to enter your code <i
                                            class="fas fa-angle-down"></i></a>
                                </div>

                                <div class="axil-checkout-coupon toggle-open">
                                    <p>If you have a coupon code, please apply it below.</p>
                                    <div class="input-group">

                                        <input placeholder="Enter coupon code" type="text" name="discount_code"
                                            id="discount_code"
                                            value="@if(session()->has('code')) {{ Session::get('code')->code }} @endif">

                                        <div class="apply-btn">
                                            <button id="apply_discount_code" type="button"
                                                class="axil-btn btn-bg-primary">Apply</button>
                                        </div>
                                    </div>
                                    <div id="discount_error" class="text-success">
                                    </div>

                                    <div id="discount_response" class="text-success">
                                        @if(session()->has('code'))
                                        Coupon Code:
                                        <strong>{{ Session::get('code')->code }}</strong>
                                        Applied successfully.
                                        <a href="#" id="remove_discount" data-toggle="tooltip" data-placement="right"
                                            title="Remove and Add New"><i class="fas fa-times text-danger"></i></a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="axil-checkout-billing">
                            <h4 class="title mb--40">Billing details</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" placeholder="Adam" id="first_name" name="first_name"
                                            value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Last Name <span>*</span></label>
                                        <input type="text" placeholder="John" id="last_name" name="last_name"
                                            value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}">
                                        <p></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Country/ Region <span>*</span></label>
                                <select id="country" name="country">
                                    <option value="">Select Country</option>
                                    @if($countries->isNotEmpty())
                                    @foreach($countries as $country)
                                    <option
                                        {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }}
                                        value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Street Address <span>*</span></label>
                                <input type="text" class="mb--15" placeholder="House number and street name"
                                    id="address" name="address"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->address : '' }}">
                                <p></p>
                                <input type="text" placeholder="Apartment, suite, unit, etc. (optonal)" id="apartment"
                                    name="apartment"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : '' }}">

                            </div>
                            <div class="form-group">
                                <label>Zip Code <span>*</span></label>
                                <input type="text" id="zip" name="zip" placeholder="9100"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->zip : '' }}">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Town/ City <span>*</span></label>
                                <input type="text" id="city" name="city" placeholder="Mumbai"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->city : '' }}">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" id="state" name="state" placeholder="West Bengal"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->state : '' }}">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Mobile <span>*</span></label>
                                <input type="text" id="mobile" name="mobile" placeholder="9482200021"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : '' }}">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Email Address <span>*</span></label>
                                <input type="email" id="email" name="email" placeholder="sumona@example.com"
                                    value="{{ (!empty($customerAddress)) ? $customerAddress->email : '' }}">
                                <p></p>
                            </div>
                            <!-- <div class="form-group input-group">
                            <input type="checkbox" id="checkbox1" name="account-create">
                            <label for="checkbox1">Create an account</label>
                        </div> -->
                            <!-- <div class="form-group different-shippng">
                            <div class="toggle-bar">
                                <a href="javascript:void(0)" class="toggle-btn">
                                    <input type="checkbox" id="checkbox2" name="diffrent-ship">
                                    <label for="checkbox2">Ship to a different address?</label>
                                </a>
                            </div>
                            <div class="toggle-open">
                                <div class="form-group">
                                    <label>Country/ Region <span>*</span></label>
                                    <select id="Region">
                                        <option value="3">Australia</option>
                                        <option value="4">England</option>
                                        <option value="6">New Zealand</option>
                                        <option value="5">Switzerland</option>
                                        <option value="1">United Kindom (UK)</option>
                                        <option value="2">United States (USA)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Street Address <span>*</span></label>
                                    <input type="text" id="address1" class="mb--15" placeholder="House number and street name">
                                    <input type="text" id="address2" placeholder="Apartment, suite, unit, etc. (optonal)">
                                </div>
                                <div class="form-group">
                                    <label>Town/ City <span>*</span></label>
                                    <input type="text" id="town">
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" id="country">
                                </div>
                                <div class="form-group">
                                    <label>Phone <span>*</span></label>
                                    <input type="tel" id="phone">
                                </div>
                            </div>
                        </div> -->
                            <div class="form-group">
                                <label>Other Notes (optional)</label>
                                <textarea id="notes" name="notes" rows="2"
                                    placeholder="Notes about your order, e.g. speacial notes for delivery."></textarea>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="axil-order-summery order-checkout-summery">
                            <h5 class="title mb--20">Your Order</h5>
                            <div class="summery-table-wrap">
                                <table class="table summery-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Cart::content() as $item)
                                        <tr class="order-product">
                                            <td>{{ $item->name }}<span class="quantity"> x {{ $item->qty }}</span></td>
                                            <td>${{ $item->price*$item->qty }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="order-subtotal">
                                            <td>Subtotal</td>
                                            <td>${{ Cart::subtotal() }}</td>
                                        </tr>
                                        <tr class="order-subtotal">
                                            <td>Discount</td>
                                            <td id="order_discount" class="text-danger">-${{ number_format($discount,2) }}</td>
                                        </tr>
                                        <tr class="order-shipping">
                                            <td colspan="2">
                                                <div class="shipping-amount">
                                                    <span class="title">Shipping Fee</span>
                                                    <span class="amount"
                                                        id="totalShippingCharge">${{ number_format($totalShippingCharge,2) }}</span>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>Total</td>
                                            <td class="order-total-amount" id="grandTotal">
                                                ${{ number_format($grandTotal,2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="order-payment-method">
                                {{-- <div class="single-payment">
                                    <div class="input-group">
                                        <input type="radio" id="radio4" name="payment">
                                        <label for="radio4">Direct bank transfer</label>
                                    </div>
                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                                </div> --}}
                                
                                <div class="single-payment">
                                    <div class="input-group justify-content-between align-items-center">
                                        <input type="radio" id="radio6" name="payment" value="paypal" checked>
                                        <label for="radio6">Paypal</label>
                                        <img src="{{ asset('front-assets/images/others/payment.png') }}" alt="Paypal payment">
                                    </div>
                                    <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                </div>
                                <div class="single-payment">
                                    <div class="input-group">
                                        <input type="radio" id="radio5" name="payment" value="cod">
                                        <label for="radio5">Cash on delivery</label>
                                    </div>
                                    <p>Pay with cash upon delivery.</p>
                                </div>
                            </div>
                    
                            <button type="submit" class="axil-btn btn-bg-primary checkout-btn">Process to
                                Checkout</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Checkout Area  -->

</main>
@endsection

@section('customJs')
<script>
    $("#orderForm").submit(function(event) {
        event.preventDefault();
        $('button[type="submit"]').prop('disabled', true);
        $.ajax({
            url: "{{ route('processCheckout') }}",
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                var errors = response.errors;
                $('button[type="submit"]').prop('disabled', false);
                //show validation error or redirect
                if (response.status == false) {
                    if (errors.first_name) {
                        $("#first_name").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.first_name);
                    } else {
                        $("#first_name").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.last_name) {
                        $("#last_name").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.last_name);
                    } else {
                        $("#last_name").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.email) {
                        $("#email").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.email);
                    } else {
                        $("#email").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.country) {
                        $("#country").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.country);
                    } else {
                        $("#country").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.address) {
                        $("#address").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.address);
                    } else {
                        $("#address").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.address) {
                        $("#city").addClass('is-invalid').siblings("p").addClass('invalid-feedback')
                            .html(errors.address);
                    } else {
                        $("#city").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.state) {
                        $("#state").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.state);
                    } else {
                        $("#state").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.zip) {
                        $("#zip").addClass('is-invalid').siblings("p").addClass('invalid-feedback')
                            .html(errors.zip);
                    } else {
                        $("#zip").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                    if (errors.mobile) {
                        $("#mobile").addClass('is-invalid').siblings("p").addClass(
                            'invalid-feedback').html(errors.mobile);
                    } else {
                        $("#mobile").removeClass('is-invalid').siblings("p").removeClass(
                            'invalid-feedback').html('');
                    }
                } else {
                    if (response.payment == 'cod') {
                    //redirect with order id
                    window.location.href = "{{ url('/thanks/') }}/" + response.orderId;
                    }
                    if (response.payment == 'paypal') {
                    //redirect with order id
                    window.location.href = "{{ url('account/paypal/') }}/" + response.orderId;
                    }
                }
            }
        });
    });
    //live change shipping fee when select country
    $("#country").change(function() {
        $.ajax({
            url: "{{ route('getOrderSummery') }}",
            type: 'post',
            data: {
                country_id: $(this).val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    //live change when selected country
                    $("#totalShippingCharge").html('$' + response.totalShippingCharge);
                    $("#grandTotal").html('$' + response.grandTotal);
                }
            }
        });
    });
    //apply discount coupon
    $('body').on('click', '#apply_discount_code', function() {
        $.ajax({
            url: "{{ route('applyDiscount') }}",
            type: 'post',
            data: {
                code: $('#discount_code').val(),
                country_id: $('#country').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    //live change
                    $("#totalShippingCharge").html('$' + response.totalShippingCharge);
                    $("#grandTotal").html('$' + response.grandTotal);
                    $("#order_discount").html('$' + response.discount);
                    $("#discount_response").load(window.location.href + " #discount_response");
                    $("#discount_error").html("");
                } else {
                    //show error message
                    $("#discount_error").html('<span class="text-danger">' + response.message +
                        '</span>');
                }
            }
        });
    });
    //dissmiss discount coupon - must use body for proper remove btn work
    $('body').on('click', '#remove_discount', function() {
        $.ajax({
            url: "{{ route('removeCoupon') }}",
            type: 'post',
            data: {
                country_id: $('#country').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    //live change
                    $("#totalShippingCharge").html('$' + response.totalShippingCharge);
                    $("#grandTotal").html('$' + response.grandTotal);
                    $("#order_discount").html('$' + response.discount);
                    $("#discount_response").html('');
                    $("#discount_error").html("");
                    //after remove clear input field
                    $("#discount_code").val('');
                }
            }
        });
    });
    
</script>

@endsection