

<a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
    <!-- Start Header -->
    <header class="header axil-header header-style-2">

        <!-- Start Header Top Area  -->
        <div class="axil-header-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-sm-3 col-5">
                        <div class="header-brand">
                            <a href="{{ route('home.index') }}" class="logo logo-dark">
                                <img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px">
                            </a>
                            <a href="{{ route('home.index') }}" class="logo logo-light">
                                <img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10 col-sm-9 col-7">
                        <div class="header-top-dropdown dropdown-box-style">
                            <div class="axil-search">
                                <button type="submit" class="icon wooc-btn-search">
                                    <i class="far fa-search"></i>
                                </button>
                                <input type="search" class="placeholder product-search-input" name="search2" id="search2" value="" maxlength="128" placeholder="What are you looking for...." autocomplete="off">
                            </div>
                            <div class="dropdown">
                                {{-- <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    EN
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">EN</a></li>
                                    <li><a class="dropdown-item" href="#">Hindi</a></li>
                                    <li><a class="dropdown-item" href="#">Bengali</a></li>
                                </ul> --}}
                            </div>
                            <div class="dropdown">
                                <button style="border: 1px solid #f0f0f0;padding: 10px 20px;border-radius:6px" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    USD
                                </button>
                                {{-- <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">USD</a></li>
                                    <li><a class="dropdown-item" href="#">AUD</a></li>
                                    <li><a class="dropdown-item" href="#">EUR</a></li>
                                </ul> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top Area  -->

        <!-- Start Mainmenu Area  -->
        <div class="axil-mainmenu aside-category-menu">
            <div class="container">
                <div class="header-navbar">
                    <div class="header-nav-department">
                        <aside class="header-department">
                            <button class="header-department-text department-title">
                                <span class="icon"><i class="fal fa-bars"></i></span>
                                <span class="text">Categories</span>
                            </button>
                            <nav class="department-nav-menu">
                                <button class="sidebar-close"><i class="fas fa-times"></i></button>
                                <ul class="nav-menu-list">
                                    @if(getCategories()->isNotEmpty())
                                    @foreach(getCategories() as $category)
                                    <li>
                                        <a href="{{ route('shop',[$category->slug]) }}" class="nav-link {{ ($category->sub_category->isNotEmpty()) ? 'has-megamenu' : '' }}">
                                            <span class="menu-icon"><img src="{{ asset('uploads/category/'.$category->image) }}" alt=""></span>
                                            <span class="menu-text">{{ $category->name }}</span>
                                        </a>
                                        @if($category->sub_category->isNotEmpty())
                                        <div class="department-megamenu">
                                            <div class="department-megamenu-wrap" style="width:max-content;border-radius:10px;padding:none;">

                                                    <div class="department-submenu">

                                                        <ul style="margin-bottom:0px">
                                                            @foreach($category->sub_category as $subCategory)
                                                            <li><a href="{{ route('shop',[$category->slug,$subCategory->slug]) }}">{{ $subCategory->name }}</a></li>
                                                            @endforeach()

                                                        </ul>
                                                    </div>

                                            </div>
                                        </div>
                                        @endif
                                    </li>
                                    @endforeach
                                    @endif


                                </ul>
                            </nav>
                        </aside>
                    </div>
                    <div class="header-main-nav">
                        <!-- Start Mainmanu Nav -->
                        <nav class="mainmenu-nav">
                            <button class="mobile-close-btn mobile-nav-toggler"><i class="fas fa-times"></i></button>
                            <div class="mobile-nav-brand">
                                <a href="index-2.html" class="logo">
                                    <img src="{{ asset('front-assets/images/logo/logo.png') }}" alt="Site Logo">
                                </a>
                            </div>
                            <ul class="mainmenu">
                                <li><a class="{{ Request::is('/') ? 'active' : '' }}" href="{{ route('home.index') }}">Home</a></li>
                                <li><a class="{{ Request::is('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a></li>
                                <li><a class="{{ Request::is('about-us') ? 'active' : '' }}" href="{{ route('aboutUs') }}">About</a></li>
                                <li><a class="{{ Request::is('blogs') ? 'active' : '' }}" href="{{ route('blogs') }}">Blog</a></li>
                                <li><a class="{{ Request::is('contact-us') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </nav>
                        <!-- End Mainmanu Nav -->
                    </div>
                    <div class="header-action">
                        <ul class="action-list">
                            <li class="axil-search d-sm-none d-block">
                                <a href="javascript:void(0)" class="header-search-icon" title="Search">
                                    <i class="flaticon-magnifying-glass"></i>
                                </a>
                            </li>
                            <li class="wishlist">
                                <a href="{{ route('wishlist') }}">
                                    <i class="flaticon-heart"></i>
                                </a>
                            </li>
                            <li class="shopping-cart">
                                <a href="#" class="cart-dropdown-btn">

                                    <span class="cart-count">
                                    @if(getCartContent()->isNotEmpty())
                                        <span class="cart-number">{{ getCartContent()->count('item') }}</span>

                                    @else()

                                    <span class="cart-number">0</span>

                                    @endif
                                    </span>

                                    <i class="flaticon-shopping-cart"></i>
                                </a>
                            </li>
                            <li class="my-account">
                                <a href="javascript:void(0)">
                                    <i class="flaticon-person"></i>
                                </a>
                                <div class="my-account-dropdown">
                                    <span class="title">QUICKLINKS</span>
                                    <ul>
                                        <li>
                                            <a href="{{ route('profile') }}">My Account</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('wishlist') }}">Wishlist</a>
                                        </li>
                                    </ul>
                                    @if(Auth::check() == true)
                                    <a href="{{ route('logout') }}" class="axil-btn btn-bg-primary">Logout</a>
                                    @else
                                    <a href="{{ route('login') }}" class="axil-btn btn-bg-primary">Login</a>
                                    <div class="reg-footer text-center">No account yet? <a href="{{ route('register') }}" class="btn-link">REGISTER HERE.</a></div>
                                    @endif
                                    </div>
                            </li>
                            <li class="axil-mobile-toggle">
                                <button class="menu-btn mobile-nav-toggler">
                                    <i class="flaticon-menu-2"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Mainmenu Area  -->
    </header>
