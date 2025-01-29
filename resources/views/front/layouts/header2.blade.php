
    <a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
    <!-- Start Header -->
    <header class="header axil-header header-style-5">

        <!-- Start Mainmenu Area  -->
        <div id="axil-sticky-placeholder"></div>
        <div class="axil-mainmenu">
            <div class="container">
                <div class="header-navbar">
                    <div class="header-brand">
                        <a href="{{ route('home.index') }}" class="logo logo-dark">
                            <img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px">
                        </a>
                        <a href="{{ route('home.index') }}" class="logo logo-light">
                            <img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="160px">
                        </a>
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
                            <li class="axil-search d-xl-block d-none">
                                <input type="search" class="placeholder product-search-input" name="search2" id="search2" value="" maxlength="128" placeholder="What are you looking for?" autocomplete="off">
                                <button type="submit" class="icon wooc-btn-search">
                                    <i class="flaticon-magnifying-glass"></i>
                                </button>
                            </li>
                            <li class="axil-search d-xl-none d-block">
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
        <!-- End Mainmenu Area -->

    </header>
    <!-- End Header -->
