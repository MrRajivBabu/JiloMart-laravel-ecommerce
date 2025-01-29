@extends('front.layouts.app2')
@section('title'){{ 'Wishlist' }}@endsection
@section('content')
<main class="main-wrapper">

    <!-- Start Wishlist Area  -->
    <div class="axil-wishlist-area axil-section-gap">
        <div class="container">
            <div class="product-table-heading">
                <h4 class="title">My Wish List</h4>
            </div>
            <div class="table-responsive">
                @if ($wishlistItems->isNotEmpty())
                <table class="table axil-product-table axil-wishlist-table">
                    <thead>
                        <tr>
                            <th scope="col" class="product-remove"></th>
                            <th scope="col" class="product-thumbnail">Product</th>
                            <th scope="col" class="product-title"></th>
                            <th scope="col" class="product-price">Unit Price</th>
                            <th scope="col" class="product-add-cart"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($wishlistItems as $wishlist)

                        <tr>
                            <td class="product-remove"><a onclick="removeWishlistItem({{ $wishlist->product->id }})"
                                    href="#" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                            <td class="product-thumbnail"><a href="{{ route('product',$wishlist->product->slug) }}"
                                    target="_blank"><img
                                        src="{{ asset('uploads/product/thumbnail/'.$wishlist->product->image) }}"
                                        alt="Digital Product"></a></td>
                            <td class="product-title"><a href="{{ route('product',$wishlist->product->slug) }}"
                                    target="_blank">{{ substr($wishlist->product->title,0,60) }}</a></td>
                            <td class="product-price" data-title="Price">
                                <del class="text-muted"><span
                                        class="currency-symbol">$</span>{{ $wishlist->product->compare_price }}</del>
                                <span class="text-dark"><span
                                        class="currency-symbol">$</span>{{ number_format($wishlist->product->price,2) }}</span>
                            </td>
                            <td class="product-add-cart cart-dropdown-btn"><a href="javascript:void(0);"
                                    onclick="addToCart({{ $wishlist->product->id }});" class="axil-btn btn-outline">Add
                                    to
                                    Cart</a></td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
                @else
                <span class="fas fa-heart"></span> No Item Added To Wishlist.
                @endif
            </div>
        </div>
    </div>
    <!-- End Wishlist Area  -->
    @endsection

    @section('customJs')
    <script>
        function removeWishlistItem(id) {
            $.ajax({
                url: '{{ route("removeWishlistItem") }}',
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        // window.location.href = "{{ route('wishlist') }}"; 
                        location.reload();
                    }
                }
            });
        }
    </script>
    @endsection