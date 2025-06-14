@extends('front.layouts.app3')
@section('title'){{ 'Login' }}@endsection
@section('content')
<div class="axil-signin-area">

<!-- Start Header -->
<div class="signin-header">
    <div class="row align-items-center">
        <div class="col-sm-4">
            <a href="{{ route('home.index') }}" class="site-logo px-5 bg-white py-3 rounded-pill"><img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px"></a>
        </div>
        <div class="col-sm-8">
            <div class="singin-header-btn">
                <p>Not a member?</p>
                <a href="{{ route('register') }}" class="axil-btn btn-bg-secondary sign-up-btn">Sign Up Now</a>
            </div>
        </div>
    </div>
</div>
<!-- End Header -->

<div class="row">
    <div class="col-xl-4 col-lg-6">
        <div class="axil-signin-banner bg_image bg_image--9">
            <h3 class="title">We Offer the Best Products</h3>
        </div>
    </div>

    <div class="col-lg-6 offset-xl-2">

        <div class="axil-signin-form-wrap">

            <div class="axil-signin-form">
            @include('admin.message')
                <h3 class="title">Sign in to eTrade.</h3>
                <p class="b2 mb--55">Enter your detail below</p>
                <form class="singin-form" method="post" action="{{ route('authenticate') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="annie@example.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="invalid-feedback text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********">
                        @error('password')
                            <p class="invalid-feedback text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <button type="submit" class="axil-btn btn-bg-primary submit-btn">Sign In</button>
                        <a href="{{ route('forgetPassword') }}" class="forgot-btn">Forget password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
