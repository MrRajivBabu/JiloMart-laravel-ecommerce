                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row ">
                            {{-- active orders --}}
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Active Orders">
                                <a href="{{ route('order.active') }}"
                                    class="nav-link dropdown-toggle hide-arrow position-relative">
                                    <i class='bx bx-shopping-bag bx-sm text-primary'></i>
                                    <span
                                        class="position-absolute top-30 start-70 translate-middle p-1 bg-success border border-light rounded-circle">
                                    </span>
                                </a>
                            </li>
                            {{-- Stock Out --}}
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Out Of Stock">
                                <a href="{{ route('outOfStock') }}"
                                    class="nav-link dropdown-toggle hide-arrow position-relative">
                                    <i class='bx bx-store bx-sm text-primary'></i>
                                    <span
                                        class="position-absolute top-30 start-70 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    </span>
                                </a>
                            </li>

                        </ul>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        @if(!empty(adminInfo(Auth::guard('admin')->user()->id)->image))
                                        <img src="{{ asset('uploads/user/'.adminInfo(Auth::guard('admin')->user()->id)->image) }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                        @else
                                        <img src="{{ asset('admin-assets/img/user.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">

                                                        @if(!empty(adminInfo(Auth::guard('admin')->user()->id)->image))
                                                        <img src="{{ asset('uploads/user/'.adminInfo(Auth::guard('admin')->user()->id)->image) }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                        @else
                                                        <img src="{{ asset('admin-assets/img/user.png') }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">
                                                        {{ Auth::guard('admin')->user()->name }}
                                                    </span>
                                                    <small class="text-muted">
                                                        @if(Auth::guard('admin')->user()->role == 2)
                                                        <span>Admin</span>
                                                        @else()
                                                        <span>Member</span>
                                                        @endif

                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('showChangePasswordForm') }}">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->