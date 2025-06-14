@extends('front.layouts.app3')
@section('title'){{ 'Register' }}@endsection
@section('content')

<div class="axil-signin-area">

<!-- Start Header -->
<div class="signin-header">
    <div class="row align-items-center">
        <div class="col-md-6">
            <a href="{{ route('home.index') }}" class="site-logo px-5 bg-white py-3 rounded-pill"><img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px"></a>
        </div>
        <div class="col-md-6">
            <div class="singin-header-btn">
                <p>Already a member?</p>
                <a href="{{ route('login') }}" class="axil-btn btn-bg-secondary sign-up-btn">Sign In</a>
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
                <h3 class="title">I'm New Here</h3>
                <p class="b2 mb--55">Enter your detail below</p>
                <form class="singin-form" id="registerForm" name="registerForm">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Anniemario Gomez">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="anniemario">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="annie@example.com">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="***********">
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="***********">
                        <p class="text-danger"></p>
                    </div>
                    <input type="hidden" class="form-control" name="role" id="role" value="1">

                    <div class="form-group">
                        <button type="submit" class="axil-btn btn-bg-primary submit-btn">Create Account</button>
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
        $("#registerForm").submit(function(event){
            event.preventDefault();
            $("button[type='submit']").prop('disabled',true);
            $.ajax({
                url: "{{ route('processRegister') }}",
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){

                    $("button[type='submit']").prop('disabled',false);

                    //show json validation errors
                    var errors = response.errors;

                    if (response.status == false) {
                        if(errors.name){
                            $("#name").siblings("p").addClass('invalid-feedback').html(errors.name);
                            $("#name").addClass('is-invalid');
                        }else{
                            $("#name").siblings("p").removeClass('invalid-feedback').html('');
                            $("#name").removeClass('is-invalid');
                        }
                        if(errors.username){
                            $("#username").siblings("p").addClass('invalid-feedback').html(errors.username);
                            $("#username").addClass('is-invalid');
                        }else{
                            $("#username").siblings("p").removeClass('invalid-feedback').html('');
                            $("#username").removeClass('is-invalid');
                        }
                        if(errors.email){
                            $("#email").siblings("p").addClass('invalid-feedback').html(errors.email);
                            $("#email").addClass('is-invalid');
                        }else{
                            $("#email").siblings("p").removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }
                        if(errors.password){
                            $("#password").siblings("p").addClass('invalid-feedback').html(errors.password);
                            $("#password").addClass('is-invalid');
                        }else{
                            $("#password").siblings("p").removeClass('invalid-feedback').html('');
                            $("#password").removeClass('is-invalid');
                        }
                    }else{

                        //clear validation error
                        $("#name").siblings("p").removeClass('invalid-feedback').html('');
                        $("#name").removeClass('is-invalid');

                        $("#username").siblings("p").removeClass('invalid-feedback').html('');
                        $("#username").removeClass('is-invalid');

                        $("#email").siblings("p").removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');

                        $("#password").siblings("p").removeClass('invalid-feedback').html('');
                        $("#password").removeClass('is-invalid');
                    }
                    if (response.status == true) {
                        //redirect after create
                        window.location.href = "{{ route('login') }}";
                    }


                }
            });
        });
    </script>
@endsection
