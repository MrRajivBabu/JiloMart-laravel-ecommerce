            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                        <img src="{{ asset('uploads/logo/'.webData()->image) }}" alt="Site Logo" width="150px">
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <!-- Orders -->
                    <li class="menu-item {{ Request::is('admin/order') ? 'active' : '' }}">
                        <a href="{{ route('order.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-cart"></i>
                            <div data-i18n="Analytics">Orders</div>
                        </a>
                    </li>
                     <!-- products -->
                     <li class="menu-item {{ Request::is('admin/products') ? 'active open' : '' }}
                     {{ Request::is('admin/products/create') ? 'active open' : '' }}" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-t-shirt"></i>
                            <div data-i18n="Account Settings">Products</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('admin/products') ? 'active' : '' }}">
                                <a href="{{ route('products.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Product</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/products/create') ? 'active' : '' }}">
                                <a href="{{ route('products.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Add New</div>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <!-- Customer -->
                    <li class="menu-item {{ Request::is('admin/users') ? 'active open' : '' }}
                    {{ Request::is('admin/users/create') ? 'active open' : '' }}" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-user"></i>
                            <div data-i18n="Account Settings">Customers</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('admin/users') ? 'active' : '' }}">
                                <a href="{{ route('users.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Users</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/users/create') ? 'active' : '' }}">
                                <a href="{{ route('users.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Add New</div>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <!-- ratings -->
                    <li class="menu-item {{ Request::is('admin/ratings') ? 'active' : '' }}">
                        <a href="{{ route('ratings.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-message-square-dots"></i>
                            <div data-i18n="Analytics">Product Ratings</div>
                        </a>
                    </li>
                    <!-- Blog Posts -->
                    <li class="menu-item" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-edit"></i>
                            <div data-i18n="Account Settings">Blog Posts</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Account">All Posts</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Notifications">Add New</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- category -->
                    <li class="menu-item {{ Request::is('admin/categories') ? 'active open' : '' }} 
                    {{ Request::is('admin/categories/create') ? 'active open' : '' }} 
                     {{ Request::is('admin/sub-category') ? 'active open' : '' }} 
                      {{ Request::is('admin/sub-category/create') ? 'active open' : '' }}" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-category"></i>
                            <div data-i18n="Account Settings">Product Categories</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('admin/categories') ? 'active' : '' }}">
                                <a href="{{ route('categories.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Categories</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/categories/create') ? 'active' : '' }}">
                                <a href="{{ route('categories.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Add Category</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/sub-category') ? 'active' : '' }}">
                                <a href="{{ route('sub-category.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Sub Categories</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/sub-category/create') ? 'active' : '' }}">
                                <a href="{{ route('sub-categories.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Add Sub Category</div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- brands -->
                    <li class="menu-item {{ Request::is('admin/brands') ? 'active open' : '' }} 
                    {{ Request::is('admin/brands/create') ? 'active open' : '' }}" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-unite"></i>
                            <div data-i18n="Account Settings">Brands</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('admin/brands') ? 'active' : '' }}">
                                <a href="{{ route('brands.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Brands</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/brands/create') ? 'active' : '' }}">
                                <a href="{{ route('brands.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Add Brand</div>
                                </a>
                            </li>


                        </ul>
                    </li>

                   
                    <!-- shipping -->
                    <li class="menu-item {{ Request::is('admin/shipping/create') ? 'active' : '' }}">
                        <a href="{{ route('shipping.create') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-package"></i>
                            <div data-i18n="Analytics">Shipping Charges</div>
                        </a>
                    </li>
                    <!-- discount -->
                    <li class="menu-item {{ Request::is('admin/discount') ? 'active open' : '' }} 
                    {{ Request::is('admin/discount/create') ? 'active open' : '' }}" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-discount"></i>
                            <div data-i18n="Account Settings">Discount Coupons</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('admin/discount') ? 'active' : '' }}">
                                <a href="{{ route('discount.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Coupons</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/discount/create') ? 'active' : '' }}">
                                <a href="{{ route('discount.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Create New</div>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <!-- Static Pages -->
                    <li class="menu-item {{ Request::is('admin/pages') ? 'active open' : '' }} 
                    {{ Request::is('admin/pages/create') ? 'active open' : '' }}" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-merge"></i>
                            <div data-i18n="Account Settings">Static Pages</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('admin/pages') ? 'active' : '' }}">
                                <a href="{{ route('pages.index') }}" class="menu-link">
                                    <div data-i18n="Account">All Pages</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('admin/pages/create') ? 'active' : '' }}">
                                <a href="{{ route('pages.create') }}" class="menu-link">
                                    <div data-i18n="Notifications">Create New</div>
                                </a>
                            </li>


                        </ul>
                    </li>
                    
                    <!-- Important Sections -->
                    <li class="menu-item" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-sidebar"></i>
                            <div data-i18n="Account Settings">Important Sections</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Account">Home Page</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Notifications">About Us</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Notifications">Contact Page</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Website Settings -->
                    <li class="menu-item" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-laptop"></i>
                            <div data-i18n="Account Settings">Website Settings</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('titleAndLogo') }}" class="menu-link">
                                    <div data-i18n="Account">Title and Logo</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Notifications">Footer Info</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- social -->
                    <li class="menu-item" style="">
                        <a href="javascript:void(0);" class="menu-link">
                            <i class="menu-icon tf-icons bx bxl-instagram"></i>
                            <div data-i18n="Account Settings">Social Profiles</div>
                        </a>
                    </li>
                    

                    

                </ul>
            </aside>
            <!-- / Menu -->
