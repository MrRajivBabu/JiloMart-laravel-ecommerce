@extends('admin.layouts.app')
@section('title'){{'Product Photo'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Images</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Images of ( {{ substr($product->title, 0, 35) }}... )</h5>
                    <div class="card-body">

                        <div class="mb-3">
                        @foreach ($productImages as $productImage)
                        <div style="position:relative;display:inline-block">
                        <img src="{{ asset($productImage->image) }}" class="border m-1" width="190"/>
                        <a href="{{ route('product-image.delete',$productImage->id) }}" ><i class='bx bx-x-circle' style="font-size:30px;color:red;position:absolute;right:10px;top:10px"></i></a>
                        </div>
                        @endforeach
                        </div>

                        <form action="{{ route('products-image.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label>Upload 5 Images (584 X 584px images only)</label><br><br>
                            <input type="file" name="product_gallery_image[]" multiple class="form-control" Required/>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <a href="{{ route('products.edit',$product->id) }}" class="btn btn-info">Edit Product Details</a>
                            <a href="{{ route('products.index') }}" class="btn btn-secondery">Cancel</a>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- / Content -->
    @endsection

    @section('customJs')
    <script>

    </script>
    @endsection
