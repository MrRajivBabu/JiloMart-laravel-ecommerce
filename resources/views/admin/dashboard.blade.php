@extends('admin.layouts.app')
@section('title'){{'Dashboard'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{ $admin->name }}! 🎉</h5>
                                <p class="mb-4">
                                    You can see all Info of your deram website from here. So, enjoy your web Maintenance journey. Have a nice day :)
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View
                                    Active Orders</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('admin-assets/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png') }}"
                                    data-app-light-img="illustrations/man-with-laptop-light.png') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 order-1">
                <div class="row">

                    <div class="col-lg-4 col-sm-6 col-12 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-cart bx-sm text-primary border border-primary rounded-circle p-2"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a href="{{ route('order.index') }}" class="dropdown-item" href="javascript:void(0);">View
                                                All</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Orders</span>
                                <h3 class="card-title mb-2">{{ $totalOrders }}</h3>
                                <span class="badge bg-label-primary rounded-pill">Life time</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bxs-t-shirt bx-sm text-primary border border-primary rounded-circle p-2"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a href="{{ route('products.index') }}" class="dropdown-item" href="javascript:void(0);">View
                                                All</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Products</span>
                                <h3 class="card-title mb-2">{{ $totalProducts }}</h3>
                                <span class="badge bg-label-primary rounded-pill">Life time</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-user bx-sm text-primary border border-primary rounded-circle p-2"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a href="{{ route('users.index') }}" class="dropdown-item" href="javascript:void(0);">View
                                                All</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Customers</span>
                                <h3 class="card-title mb-2">{{ $totalCustomers }}</h3>
                                <span class="badge bg-label-primary rounded-pill">Life time</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                <div class="row">

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Total Revenue</h5>
                                            <span class="badge bg-label-primary rounded-pill">Life Time</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                        
                                            <h5 class="mb-0">${{ number_format($totalRevenue,2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Current Month Revenue</h5>
                                            <span class="badge bg-label-primary rounded-pill">{{\Carbon\Carbon::now()->monthName}}</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                        
                                            <h5 class="mb-0">${{ number_format($revenueThisMonth,2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Last Month Revenue</h5>
                                            <span class="badge bg-label-primary rounded-pill">{{\Carbon\Carbon::now()->subMonth()->monthName}}</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                        
                                            <h5 class="mb-0">${{ number_format($revenueLastMonth,2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">30 Days Revenue</h5>
                                            <span class="badge bg-label-primary rounded-pill">Last 30 Days</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                        
                                            <h5 class="mb-0">${{ number_format($revenueLastThirtyDays,2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        

    </div>
    <!-- / Content -->
    @endsection