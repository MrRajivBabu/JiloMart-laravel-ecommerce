@extends('front.layouts.app2')
@section('content')
<div class="axil-product-cart-area axil-section-gap">
    <div class="container">
        <div class="axil-product-cart-wrap">
            <div class="product-table-heading justify-content-center">
                <img src="{{ asset('front-assets/images/icons/shopping-bag.png') }}" alt="" style="max-width: 50px"><br>
            </div>
            <div class="product-table-heading justify-content-center" style="text-align: center">
                <h2 class="title">Thanks For Your Order.</h2>
            </div>
            <div class="product-table-heading justify-content-center">
                <a href="{{ route('profile') }}" class="btn btn-primary rounded-pill" style="padding: 5px 15px;font-size:14px">Go To Acount</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customJs') 
{{-- <script> 
window.setTimeout(function() {
    window.location.href = "{{ route('home.index') }}";
}, 20000);
</script> --}}
@endsection
