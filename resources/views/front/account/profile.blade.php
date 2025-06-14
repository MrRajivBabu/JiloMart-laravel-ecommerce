@extends('front.layouts.app2')
@section('title'){{ 'Account' }}@endsection
@section('content')
<main class="main-wrapper">

    <!-- Start My Account Area  -->
    <div class="axil-dashboard-area axil-section-gap">
        <div class="container">
            <div class="axil-dashboard-warp">
                <div class="axil-dashboard-author">
                    <div class="media">
                        <div class="thumbnail" id="userTopImage">
                            @if(!empty($userDetail->image))
                            <img src="{{ asset('uploads/user/'.$userDetail->image) }}" alt="" width="70px">
                            @else
                            <img src="{{ asset('front-assets/images/user.png') }}" alt="" width="70px">
                            @endif
                        </div>
                        <div class="media-body">
                            <h5 class="title mb-0">Hello {{ $userDetail->name }}</h5>
                            <span class="joining-date">Member Since {{ \Carbon\Carbon::parse($userDetail->created_at)->format('M Y') }}</span>
                        </div>
                        @include('admin.message')
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-4">
                        <aside class="axil-dashboard-aside">
                            <nav class="axil-dashboard-nav">
                                <div class="nav nav-tabs" role="tablist">
                                    <a class="nav-item nav-link active" data-bs-toggle="tab" href="#nav-dashboard"
                                        role="tab" aria-selected="true"><i class="fas fa-th-large"></i>Dashboard</a>
                                    <a class="nav-item nav-link" data-bs-toggle="tab" href="#nav-orders" role="tab"
                                        aria-selected="false"><i class="fas fa-shopping-basket"></i>Orders</a>
                                    <a class="nav-item nav-link" data-bs-toggle="tab" href="#nav-address" role="tab"
                                        aria-selected="false"><i class="fas fa-home"></i>Addresses</a>
                                    <a class="nav-item nav-link" data-bs-toggle="tab" href="#nav-account" role="tab"
                                        aria-selected="false"><i class="fas fa-user"></i>Account Details</a>
                                    <a class="nav-item nav-link" href="{{ route('logout') }}"><i
                                            class="fal fa-sign-out"></i>Logout</a>
                                </div>
                            </nav>
                        </aside>
                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="nav-dashboard" role="tabpanel">
                                <div class="axil-dashboard-overview">
                                    <div class="welcome-text">Hello {{ $userDetail->name }} (not <span>Annie?</span> <a
                                            href="{{ route('logout') }}">Log Out</a>)</div>
                                    <p>From your account dashboard you can view your recent orders, manage your shipping
                                        and billing addresses, and edit your password and account details.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-orders" role="tabpanel">
                                <div class="axil-dashboard-order">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Order</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Selected Method</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($orders->isNotEmpty())
                                                @foreach ($orders as $order)
                                                <tr>
                                                    <th scope="row">#{{ $order->id }}</th>
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($order->status == "shipped")
                                                        <span class="badge bg-info">Shipped</span>
                                                        @elseif($order->status == "delivered")
                                                        <span class="badge bg-success">Delivered</span>
                                                        @elseif($order->status == "cancelled")
                                                        <span class="badge bg-danger">Cancelled</span>
                                                        @else
                                                        <span class="badge bg-primary">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format($order->grand_total,2) }}</td>
                                                    <td>
                                                        @if ($order->payment == "cod")
                                                        <span class="text-primary">Cash On Delivery</span>
                                                        @elseif($order->payment == "paypal")
                                                        <span class="text-dark">Paypal</span>
                                                        @if($order->payment_status == "paid")
                                                        <span class="text-success">({{ $order->payment_status }})</span>
                                                        @elseif($order->payment_status == "not paid")
                                                        <span class="text-danger">({{ $order->payment_status }})</span>
                                                        @else
                                                        @endif
                                                        @else

                                                        @endif
                                                    </td>
                                                    <td><button class="axil-btn view-btn order_view"
                                                            value="{{ $order->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">View</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No Order Found!</td>
                                                </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-address" role="tabpanel">
                                <div class="axil-dashboard-address">
                                    <p class="notice-text">The following address will be used on the checkout page by
                                        default.</p>
                                    <div class="row row--30">
                                        <div class="col-lg-6">
                                            <div class="address-info mb--40">
                                                <div
                                                    class="addrss-header d-flex align-items-center justify-content-between">
                                                    <h4 class="title mb-0">Shipping Address</h4>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit-address-modal" class="address-edit"><i
                                                            class="far fa-edit"></i></a>
                                                </div>
                                                <ul class="address-details" id="address-details">
                                                    @if(!empty($userAddress))
                                                    <li>Name: {{ $userAddress->first_name }}
                                                        {{ $userAddress->last_name }}</li>
                                                    <li>Email: {{ $userAddress->email }}</li>
                                                    <li>Phone: {{ $userAddress->mobile }}</li>
                                                    <li class="mt--30">
                                                        {{ (!empty($userAddress->address)) ? $userAddress->address.'.' : '' }}
                                                        <br>
                                                        {{ (!empty($userAddress->apartment)) ? $userAddress->apartment.',' : '' }}
                                                        {{ (!empty($userAddress->city)) ? $userAddress->city.' - ' : '' }}
                                                        {{ (!empty($userAddress->zip)) ? $userAddress->zip.',' : '' }}
                                                        {{ (!empty($userAddress->state)) ? $userAddress->state.',' : '' }}
                                                        {{ (!empty($userCountry)) ? $userCountry->countryName : '' }}
                                                    </li>
                                                    @else
                                                    <li>Customer Adress Not Found.</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-account" role="tabpanel">
                                <div class="col-lg-9">
                                    <div class="axil-dashboard-account">
                                        <div class="row">
                                            <form class="account-details-form" name="userDetailForm"
                                                id="userDetailForm">
                                                <h5 class="title">User Details</h5>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <input type="hidden" id="image_id" name="image_id" value="">
                                                        <div class="form-group mb--40 col-sm-6 col-12">
                                                            <label>Image (70 x 70 PX)</label>
                                                            <div id="image" class="dropzone dz-clickable">
                                                                <div class="dz-message needsclick">
                                                                    <br>Drop files here or click to upload.<br><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="userImage" class="form-group mb--40 col-sm-6 col-12">
                                                            @if(!empty($userDetail->image))
                                                            <div class="col-md-6 mb-3">
                                                                <p style="margin:unset">Current Image</p>
                                                                <img width="70px"
                                                                    src="{{ asset('uploads/user/'.$userDetail->image) }}"
                                                                    alt="" width="70px">
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mb--40">
                                                        <label>Full Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $userDetail->name }}" name="name" id="name">
                                                        <p></p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb--30">
                                                        <label>Email Adress</label>
                                                        <input type="email" class="form-control"
                                                            value="{{ $userDetail->email }}" name="email" id="email">
                                                        <p></p>
                                                    </div>
                                                    <div class="form-group mb--0">
                                                        <input type="submit" class="axil-btn" value="Save Changes">
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="passwordChangeForm" name="passwordChangeForm">
                                                <div class="col-12 mt-5">
                                                    <h5 class="title">Password Change</h5>

                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <input type="password" class="form-control" name="new_password"
                                                            id="new_password">
                                                        <p></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirm New Password</label>
                                                        <input type="password" class="form-control"
                                                            name="confirm_password" id="confirm_password">
                                                        <p></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Old Password</label>
                                                        <input type="password" class="form-control" name="old_password"
                                                            id="old_password">
                                                        <p></p>
                                                    </div>
                                                    <div class="form-group mb--0">
                                                        <input type="submit" class="axil-btn" value="Save Changes"
                                                            id="password_change_btn">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End My Account Area  -->

    <!-- order View Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="axil-order-summery order-checkout-summery" style="background-color: #fff">
                        <h5 class="title mb-20">#<span id="orderId"></span> Order Details <span id="orderStatus"></span>
                            <span id="paymentStatus"></span> <span id="paymentMethod"></span></h5>
                        <div class="summery-table-wrap">
                            <table class="table summery-table">
                                <thead>
                                    <tr>
                                        <th>Shopping Items</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItems">

                                </tbody>
                                <tr class="order-subtotal">
                                    <td colspan="2" align="right"><span style="margin-right: 15px">Subtotal</span>$<span
                                            id="subTotal"></span></td>
                                </tr>
                                <tr class="order-subtotal">
                                    <td colspan="2" align="right" id="order_discount" class="text-danger"><span
                                            style="margin-right: 15px">Discount</span>-$<span id="discount"></span></td>
                                </tr>
                                <tr class="order-subtotal">
                                    <td colspan="2" align="right"><span style="margin-right: 15px">Shipping
                                            Fee</span>$<span id="shipping"></span></td>
                                </tr>
                                <tr class="order-total">

                                    <td colspan="2" align="right" class="order-total-amount"><span
                                            style="margin-right: 15px">Total</span>$<span id="grandTotal"></span></td>
                                </tr>
                                <tr id="payWith">

                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('customJs')

    <script>
        $(document).ready(function() {
            $(document).on('click', '.order_view', function() {
                var order_id = $(this).val();
                // alert(order_id);
                $.ajax({
                    type: "get",
                    url: "/account/order-view/" + order_id,
                    success: function(response) {
                        // comnsole.log(response);
                        //show data in modal start//
                        $('#orderId').text(response.order.id);
                        $('#subTotal').text(response.subTotal);
                        $('#discount').text(response.discount);
                        $('#shipping').text(response.shipping);
                        $('#grandTotal').text(response.grandTotal);
                        //order status
                        var orderStatus = response.order.status;
                        if (orderStatus == "pending") {
                            $('#orderStatus').html('<span class="badge bg-primary">' +
                                orderStatus + '</span>');
                        }
                        if (orderStatus == "shipped") {
                            $('#orderStatus').html('<span class="badge bg-info">' +
                                orderStatus + '</span>');
                        }
                        if (orderStatus == "delivered") {
                            $('#orderStatus').html('<span class="badge bg-success">' +
                                orderStatus + '</span>');
                        }
                        if (orderStatus == "cancelled") {
                            $('#orderStatus').html('<span class="badge bg-danger">' +
                                orderStatus + '</span>');
                        }
                        //payment method
                        var paymentMethod = response.order.payment
                        $('#paymentMethod').html('<span class="badge bg-secondary">' +
                            paymentMethod + '</span>');
                        if (paymentMethod == "cod") {
                            $('#paymentMethod').html(
                                '<span class="badge bg-secondary">Cash On Delivery</span>'
                                );
                        }
                        //paymeny status
                        var paymentStatus = response.order.payment_status;
                        if (paymentStatus == "not paid") {
                            $('#paymentStatus').html('<span class="badge bg-danger">' +
                                paymentStatus + '</span>');
                        }
                        if (paymentStatus == "paid") {
                            $('#paymentStatus').html('<span class="badge bg-success">' +
                                paymentStatus + '</span>');
                        }
                        //pay with buttons
                        var orderId = response.order.id;
                        $('#payWith').html('');
                        if (paymentStatus == "not paid") {
                            //here double comma qutation must be in single comma
                            $('#payWith').html('<td colspan="2" align="right">' +
                                '<span style="margin-right: 15px">' +
                                'Pay With' +
                                '</span>' +
                                '<span id="payWithPaypal">' +
                                '<a href="/account/paypal/' + orderId +
                                '"><img src="{{ asset("front-assets/images/logo/paypal.png") }}" style="max-width: 180px"></a>' +
                                '</span>' +
                                '</td>');
                        }
                        //loop order items show
                        $('#orderItems').html(""); //clear html data first
                        var table = document.getElementById('orderItems');
                        for (let i = 0; i < response.orderItems.length; i++) {
                            var row = `<tr>
                                    <td>
                                        <img src="/uploads/product/thumbnail/${response.orderItems[i].image}" style="max-width:35px;border-radius:5px;margin-right:10px">
                                        ${response.orderItems[i].name.substring(0,50)} 
                                        ($${response.orderItems[i].price}
                                        <span>x</span>  ${response.orderItems[i].qty})

                                    </td>
                                    <td>$${response.orderItems[i].total}</td>
                                </tr>`
                            table.innerHTML += row
                        }
                        //show data in modal//
                    }
                });
            });
        });
        // changer user details
        $("#userDetailForm").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("profile.update") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        //alert
                        successPopup('Profile Details Updated');

                        $('#userImage').load(location.href+' #userImage');
                        $('#userTopImage').load(location.href+' #userTopImage');
                    } else {
                        //show error under input field
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid').siblings('p').html(errors.name)
                                .addClass('invalid-feedback');
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p').html('').removeClass(
                                'invalid-feedback');
                        }
                        if (errors.email) {
                            $("#email").addClass('is-invalid').siblings('p').html(errors.email)
                                .addClass('invalid-feedback');
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                    }
                }
            });
        });
        // changer user address
        $("#adressUpdateForm").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("address.update") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        //alert
                        successPopup('Your Adress Updated');
                    } else {
                        //show error under input field
                        var errors = response.errors;
                        if (errors.first_name) {
                            $("#first_name").addClass('is-invalid').siblings('p').html(errors
                                .first_name).addClass('invalid-feedback');
                        } else {
                            $("#first_name").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.last_name) {
                            $("#last_name").addClass('is-invalid').siblings('p').html(errors
                                .last_name).addClass('invalid-feedback');
                        } else {
                            $("#last_name").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.email) {
                            $("#adressUpdateForm #email").addClass('is-invalid').siblings('p').html(
                                errors.email).addClass('invalid-feedback');
                        } else {
                            $("#adressUpdateForm #email").removeClass('is-invalid').siblings('p')
                                .html('').removeClass('invalid-feedback');
                        }
                        if (errors.apartment) {
                            $("#apartment").addClass('is-invalid').siblings('p').html(errors
                                .apartment).addClass('invalid-feedback');
                        } else {
                            $("#apartment").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.country) {
                            $("#country").addClass('is-invalid').siblings('p').html(errors.country)
                                .addClass('invalid-feedback');
                        } else {
                            $("#country").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.address) {
                            $("#address").addClass('is-invalid').siblings('p').html(errors.address)
                                .addClass('invalid-feedback');
                        } else {
                            $("#address").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.city) {
                            $("#city").addClass('is-invalid').siblings('p').html(errors.city)
                                .addClass('invalid-feedback');
                        } else {
                            $("#city").removeClass('is-invalid').siblings('p').html('').removeClass(
                                'invalid-feedback');
                        }
                        if (errors.state) {
                            $("#state").addClass('is-invalid').siblings('p').html(errors.state)
                                .addClass('invalid-feedback');
                        } else {
                            $("#state").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.zip) {
                            $("#zip").addClass('is-invalid').siblings('p').html(errors.zip)
                                .addClass('invalid-feedback');
                        } else {
                            $("#zip").removeClass('is-invalid').siblings('p').html('').removeClass(
                                'invalid-feedback');
                        }
                        if (errors.mobile) {
                            $("#mobile").addClass('is-invalid').siblings('p').html(errors.mobile)
                                .addClass('invalid-feedback');
                        } else {
                            $("#mobile").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                    }
                }
            });
        });
        //change user password
        $("#passwordChangeForm").submit(function(event) {
            event.preventDefault();
            //button disable
            $("#password_change_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route("password.update") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("#password_change_btn").prop('disabled', false);
                    if (response.status == "not_match") {
                        //clear valid error and add show old pass not match
                        $("#new_password").removeClass('is-invalid').siblings('p').html('')
                            .removeClass('invalid-feedback');
                        $("#confirm_password").removeClass('is-invalid').siblings('p').html('')
                            .removeClass('invalid-feedback');
                        $("#old_password").removeClass('is-invalid').siblings('p').html(
                            '<p class="text-danger">old password not match, please enter correct password!</p>'
                            ).removeClass('invalid-feedback');
                    }
                    if (response.status == true) {
                        location.reload();
                    } else {
                        //show error under input field
                        var errors = response.errors;
                        if (errors.new_password) {
                            $("#new_password").addClass('is-invalid').siblings('p').html(errors
                                .new_password).addClass('invalid-feedback');
                        } else {
                            $("#new_password").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.confirm_password) {
                            $("#confirm_password").addClass('is-invalid').siblings('p').html(errors
                                .confirm_password).addClass('invalid-feedback');
                        } else {
                            $("#confirm_password").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                        if (errors.old_password) {
                            $("#old_password").addClass('is-invalid').siblings('p').html(errors
                                .old_password).addClass('invalid-feedback');
                        } else {
                            $("#old_password").removeClass('is-invalid').siblings('p').html('')
                                .removeClass('invalid-feedback');
                        }
                    }
                }
            });
        });
        // dropzone file upload
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });
    </script>

    @endsection