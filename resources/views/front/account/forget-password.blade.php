@extends('front.layouts.app3')
@section('title'){{ 'Forgot Password' }}@endsection
@section('content')
<div class="axil-signin-area">

    <!-- Start Header -->
    <div class="signin-header">
        <div class="row align-items-center">
            <div class="col-xl-4 col-sm-6">
                <a href="{{ route('home.index') }}" class="site-logo px-5 bg-white py-3 rounded-pill"><img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px"></a>
            </div>
            <div class="col-md-2 d-lg-block d-none">
                <a href="{{ route('login') }}" class="back-btn"><i class="far fa-angle-left"></i></a>
            </div>
            <div class="col-xl-6 col-lg-4 col-sm-6">
                <div class="singin-header-btn">
                    <p>If not forgot password?</p>
                    <a href="{{ route('login') }}" class="sign-up-btn axil-btn btn-bg-secondary">Sign In</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="axil-signin-banner bg_image bg_image--10">
                <h3 class="title">We Offer the Best Products</h3>
            </div>
        </div>
        <div class="col-lg-6 offset-xl-2">
            <div class="axil-signin-form-wrap">
                <div class="axil-signin-form">
                    <h3 class="title">Forgot Password?</h3>
                    <p class="b2 mb--55">Enter the email address you used when you joined and we’ll send you
                        instructions to reset your password.</p>
                    <p class="badge bg-success text-white fs-5 px-4 rounded-pill" id="pass-alert"></p>    
                    <form class="singin-form" name="forgetPasswordForm" id="forgetPasswordForm">
                        <div class="form-group">
                            
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="annie@example.com">
                            <p class="text-danger"></p>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="forget-password-btn" class="axil-btn btn-bg-primary submit-btn">Send Reset
                                Instructions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
     $("#forgetPasswordForm").submit(function(event){
            event.preventDefault();
            $("button[type='submit']").prop('disabled',true);
            $.ajax({
                url: "{{ route('processForgetPassword') }}",
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("button[type='submit']").prop('disabled',false);

                    //show json validation errors
                    var errors = response.errors;

                    if (response.status == true) {
                        //alert
                        successPopup('Password Reset Link Successfully Sent To Your Email');
                        $("#pass-alert").html("Email Sent, Please Check Your Inbox");

                        $("#email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');

                    }else{
                        if (errors.email) {
                        $("#email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                        }else{
                            $("#email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                        }
                    }

                }
            });
        });        
</script>
@endsection