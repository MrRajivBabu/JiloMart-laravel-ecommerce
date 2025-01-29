@extends('front.layouts.app2')
@section('title'){{ 'Latest Post' }}@endsection
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
                            <li class="axil-breadcrumb-item active" aria-current="page">Blogs</li>
                        </ul>
                        <h1 class="title">Latest Blogs</h1>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->
    <!-- Start Blog Area  -->
    <div class="axil-blog-area axil-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row g-5">
                        <div class="col-md-6 col-12 col-sm-12 col-lg-4">
                            <div class="content-blog blog-grid">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="blog-details.html">
                                            <img src="{{ asset('front-assets/images/blog/blog-10.png') }}" alt="Blog Images">
                                        </a>
                                        <div class="blog-category">
                                            <a href="#">Digital Art's</a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="blog-details.html">Keeping yourself safe when buying NFTs on eTrade</a></h5>

                                        <div class="read-more-btn">
                                            <a class="axil-btn right-icon" href="blog-details.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 col-sm-12 col-lg-4">
                            <div class="content-blog blog-grid">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="blog-details.html">
                                            <img src="{{ asset('front-assets/images/blog/blog-11.png') }}" alt="Blog Images">
                                        </a>
                                        <div class="blog-category">
                                            <a href="#">Photography</a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="blog-details.html">Important updates for listing and delisting your NFTs</a></h5>

                                        <div class="read-more-btn">
                                            <a class="axil-btn right-icon" href="blog-details.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 col-sm-12 col-lg-4">
                            <div class="content-blog blog-grid">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="blog-details.html">
                                            <img src="{{ asset('front-assets/images/blog/blog-12.png') }}" alt="Blog Images">
                                        </a>
                                        <div class="blog-category">
                                            <a href="#">Music</a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="blog-details.html">10 tips for avoiding scams and staying safe on the decentralized web</a></h5>

                                        <div class="read-more-btn">
                                            <a class="axil-btn right-icon" href="blog-details.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 col-sm-12 col-lg-4">
                            <div class="content-blog blog-grid">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="blog-details.html">
                                            <img src="{{ asset('front-assets/images/blog/blog-10.png') }}" alt="Blog Images">
                                        </a>
                                        <div class="blog-category">
                                            <a href="#">Sports</a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="blog-details.html">Keeping yourself safe when buying NFTs on eTrade</a></h5>

                                        <div class="read-more-btn">
                                            <a class="axil-btn right-icon" href="blog-details.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="post-pagination">
                        <nav class="navigation pagination" aria-label="Products">
                            <ul class="page-numbers">
                                <li><span aria-current="page" class="page-numbers current">1</span></li>
                                <li><a class="page-numbers" href="#">2</a></li>
                                <li><a class="page-numbers" href="#">3</a></li>
                                <li><a class="page-numbers" href="#">4</a></li>
                                <li><a class="page-numbers" href="#">5</a></li>
                                <li><a class="next page-numbers" href="#"><i class="fal fa-arrow-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
            <!-- End post-pagination -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End Blog Area  -->

@endsection
