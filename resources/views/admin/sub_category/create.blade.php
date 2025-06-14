@extends('admin.layouts.app')
@section('title'){{'Sub Category Create'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sub Category /</span> Create</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Create New</h5>
                    <div class="card-body">
                        <form action="" method="post" name="subCategoryForm" id="subCategoryForm">
                            <div class="row">
                            <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Category</label>
                                    <select id="category" name="category" class="form-select">
                                        <option value="">Select A Category</option>
                                        @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        @else
                                        <option>Category Not Found</option>
                                        @endif

                                    </select>
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Sub Category Name</label>
                                    <input name="name" id="name" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="Shirt"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Slug</label>
                                    <input name="slug" id="slug" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="lycra-shirts"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <!-- <input type="hidden" id="image_id" name="image_id" value="">
                                <div class="col-md-6 mb-3">
                                <label for="defaultFormControlInput" class="form-label">Image (64 x 64 PX)</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Show On Home</label>
                                    <select id="showHome" name="showHome" class="form-select">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Create</button>
                            <a href="{{ route('sub-category.index') }}" type="button" class="btn btn-default">Cancel</a>

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
        //sub categorey data store
        $('#subCategoryForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("sub-category.store") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('sub-category.index') }}";
                        $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                        $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                    } else {
                        var errors = response['errors'];
                        //show input error if empty
                        if (errors['name']) {
                            $('#name').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['name'])
                        } else {
                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['slug']) {
                            $('#slug').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['slug'])
                        } else {
                            $('#slug').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['category']) {
                            $('#category').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['category'])
                        } else {
                            $('#category').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("something went wrong")
                }
            })
        });
        // auto fill slug
        $("#name").change(function() {
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
    </script>
    @endsection
