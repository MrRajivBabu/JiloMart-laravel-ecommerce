@extends('front.layouts.app3')
@section('title'){{ 'Reset Password' }}@endsection
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
                <h2 class="title">We Offer the Best Products</h2>
            </div>
        </div>
        <div class="col-lg-6 offset-xl-2">
            <div class="axil-signin-form-wrap">
                <div class="axil-signin-form">
                    <h3 class="title">Change Password</h3>
                    <p class="b2 mb--55">Generate and enter new password, then submit to reset your password.</p>
                    <form class="singin-form" id="resetPasswordForm" name="resetPasswordForm">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label>New password</label>
                            <input type="password" class="form-control" name="new_password" id="new_password"
                                placeholder="Enter New Password">
                            <p class="text-danger"></p>
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                placeholder="Retype New Password">
                            <p class="text-danger"></p>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="axil-btn btn-bg-primary submit-btn">Reset Password</button>
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
    $("#resetPasswordForm").submit(function(event) {
        event.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: "{{ route('processResetPassword') }}",
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);
                //show json validation errors
                var errors = response.errors;
                if (response.status == true) {
                    //redirect
                    window.location.href = "{{ route('login') }}";

                    $("#new_password").removeClass('is-invalid').siblings('p').html('').removeClass(
                            'invalid-feedback');
                    $("#confirm_password").removeClass('is-invalid').siblings('p').html('')
                            .removeClass('invalid-feedback');

                } else {
                    if (errors.new_password) {
                        $("#new_password").addClass('is-invalid').siblings('p').html(errors
                            .new_password).addClass('invalid-feedback');
                    } else {
                        $("#new_password").removeClass('is-invalid').siblings('p').html('').removeClass(
                            'invalid-feedback');
                    }
                    if (errors.confirm_password) {
                        $("#confirm_password").addClass('is-invalid').siblings('p').html(errors
                            .confirm_password).addClass('invalid-feedback');
                    } else {
                        $("#confirm_password").removeClass('is-invalid').siblings('p').html('')
                            .removeClass('invalid-feedback');
                    }
                
                }
            
            }
        });
    });
</script>
@endsection