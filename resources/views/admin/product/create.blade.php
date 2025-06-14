@extends('admin.layouts.app')
@section('title'){{'Product Create'}}@endsection
@section('customCss')
<style>

</style>
@endsection

@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Create</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Create New</h5>
                    <div class="card-body">
                        <form action="" method="post" name="productForm" id="productForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Product Title</label>
                                    <input name="title" id="title" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="Shirt"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p class="error"></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Slug</label>
                                    <input name="slug" id="slug" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="lycra-shirts"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p class="error"></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Product Description</label>
                                    <textarea name="description" id="description" class="summernote"
                                        placeholder="Description"></textarea>

                                </div>

                                <input type="hidden" id="image_id" name="image_id" value="">
                                <div class="col-md-6 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">Set Thumbnail Image (630 x
                                        630 PX)</label>

                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 mt-3">
                                    <label for="defaultFormControlInput" class="form-label">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="summernote"
                                        placeholder="short_description"></textarea>

                                </div>
                                <div class="col-md-6 mb-3 mt-3">
                                    <label for="defaultFormControlInput" class="form-label">Shipping And Returns</label>
                                    <textarea name="shipping_returns" id="shipping_returns" class="summernote"
                                        placeholder="shipping_returns"></textarea>

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Compare at Price</label>
                                    <input type="text" name="compare_price" id="compare_price" class="form-control"
                                        placeholder="Compare Price" data-bs-toggle="tooltip"
                                        title="To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.">
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control"
                                        placeholder="Barcode">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="hidden" name="track_qty" value="No">
                                    <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty"
                                        value="Yes" checked>
                                    <label for="defaultSelect" class="form-label">Track Quantity</label>
                                    <p class="error"></p>
                                    <input type="number" min="0" name="qty" id="qty" class="form-control"
                                        placeholder="Qty">
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Set status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label"> Sub Category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Brand</label>
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Choose Brand</option>
                                        @if($brands->isNotEmpty())
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Set Featured</label>
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Related Products</label>
                                    <select class="related-products w-100" name="related_products[]"
                                        id="related-products" multiple="multiple">
                                    </select>
                                    <p class="error"></p>
                                </div>

                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Create</button>
                            <a href="{{ route('products.index') }}" type="button" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @endsection

    @section('customJs')
    <script>

        //related products
        $('.related-products').select2({
            ajax: {
                url: '{{ route("products.getProducts") }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults:function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
        // product submit
        $("#productForm").submit(function(event) {
            event.preventDefault();
            var formArray = $(this).serializeArray();
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: '{{ route("products.store") }}',
                type: 'post',
                data: formArray,
                dataType: 'json',
                success: function(response) {
                    $("button[type='submit']").prop('disabled', false);
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('products.index') }}";
                    } else {
                        var errors = response['errors'];
                        // show errors in all p tag
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='nember']").removeClass(
                            'is-invalid');
                        $.each(errors, function(key, value) {
                            $(`#${key}`)
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(value)
                        });
                    }
                },
                error: function(response) {
                    console.log("something went wrong");
                }
            });
        });
        // get sub category data in form by category
        $("#category").change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route("product-subcategories.index") }}',
                type: 'get',
                data: {
                    category_id: category_id
                },
                dataType: 'json',
                success: function(response) {
                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response["subcategories"], function(key, item) {
                        $("#sub_category").append(
                            `<option value='${item.id}'>${item.name}</option>`)
                    });
                },
                error: function(response) {
                    console.log("something went wrong");
                }
            });
        });
        // auto fill slug
        $("#title").change(function() {
            element = $(this);
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("getSlug") }}',
                type: 'get',
                data: {
                    title: element.val()
                },
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response["status"] == true) {
                        $("#slug").val(response["slug"])
                    }
                }
            });
        });
        // dropzone file upload
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });
        //jpreview
        $('.product_images').jPreview();
    </script>
    @endsection
