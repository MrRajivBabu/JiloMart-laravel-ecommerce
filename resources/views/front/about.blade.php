@extends('front.layouts.app2')
@section('title'){{ 'About Us' }}@endsection
@section('content')
<main class="main-wrapper">
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="index-2.html">Home</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">About Us</li>
                        </ul>
                        <h1 class="title">About Our Store</h1>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start About Area  -->
    <div class="axil-about-area about-style-1 axil-section-gap ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-6">
                    <div class="about-thumbnail">
                        <div class="thumbnail">
                            <img src="{{ asset('front-assets/images/about/about-01.png') }}" alt="About Us">
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-6">
                    <div class="about-content content-right">
                        <span class="title-highlighter highlighter-primary2"> <i class="far fa-shopping-basket"></i>About Store</span>
                        <h3 class="title">Online shopping includes both buying things online.</h3>
                        <span class="text-heading">Salesforce B2C Commerce can help you create unified, intelligent digital commerce
                            experiences — both online and in the store.</span>
                        <div class="row">
                            <div class="col-xl-6">
                                <p>Empower your sales teams with industry tailored
                                    solutions that support manufacturers as they go
                                    digital, and adapt to changing markets & customers
                                    faster by creating new business.</p>
                            </div>
                            <div class="col-xl-6">
                                <p class="mb--0">Salesforce B2B Commerce offers buyers the
                                    seamless, self-service experience of online
                                    shopping with all the B2B</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Area  -->

    <!-- Start About Area  -->
    <div class="about-info-area">
        <div class="container">
            <div class="row row--20">
                <div class="col-lg-4">
                    <div class="about-info-box">
                        <div class="thumb">
                            <img src="{{ asset('front-assets/images/about/shape-01.png') }}" alt="Shape">
                        </div>
                        <div class="content">
                            <h6 class="title">40,000+ Happy Customer</h6>
                            <p>Empower your sales teams with industry
                                tailored solutions that support.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-info-box">
                        <div class="thumb">
                            <img src="{{ asset('front-assets/images/about/shape-02.png') }}" alt="Shape">
                        </div>
                        <div class="content">
                            <h6 class="title">16 Years of Experiences</h6>
                            <p>Empower your sales teams with industry
                                tailored solutions that support.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-info-box">
                        <div class="thumb">
                            <img src="{{ asset('front-assets/images/about/shape-03.png') }}" alt="Shape">
                        </div>
                        <div class="content">
                            <h6 class="title">12 Awards Won</h6>
                            <p>Empower your sales teams with industry
                                tailored solutions that support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Area  -->





@endsection
