@extends('admin.layouts.app')
@section('title'){{'Category edit'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Category /</span> Update</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">{{ $category->name }}</h5>
                    <div class="card-body">
                        <form action="" method="post" name="categoryForm" id="categoryForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Category Name</label>
                                    <input value="{{ $category->name }}" name="name" id="name" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="Shirt"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Slug</label>
                                    <input value="{{ $category->slug }}" name="slug" id="slug" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="lycra-shirts"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <input type="hidden" id="image_id" name="image_id" value="">
                                <div class="col-md-6 mb-3">
                                <label for="defaultFormControlInput" class="form-label">Image (512 x 512 PX)</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($category->image))
                                <div class="col-md-6 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">Current Image</label><br>
                                    <img width="200px" src="{{ asset('uploads/category/'.$category->image) }}" alt="" >
                                </div>
                                @endif
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option {{ ($category->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ ($category->status == 0) ? 'selected' : '' }} value="0">Deactive</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Show On Home</label>
                                    <select id="showHome" name="showHome" class="form-select">
                                        <option {{ ($category->showHome == 'No') ? 'selected' : '' }} value="No">No</option>
                                        <option {{ ($category->showHome == 'Yes') ? 'selected' : '' }} value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Update</button>
                            <a href="{{ route('categories.index') }}" type="button" class="btn btn-default">Cancel</a>
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
        //categorey data store
        $('#categoryForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("categories.update",$category->id) }}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('categories.index') }}";
                        $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                        $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                    } else {
                        if (response['notFound'] == true) {
                            window.location.href="{{ route('categories.index') }}";
                        }
                        var errors = response['errors'];
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
    </script>
    @endsection
