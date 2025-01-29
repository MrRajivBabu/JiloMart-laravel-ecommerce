
@extends('admin.layouts.app')
@section('title'){{'Change Title And Logo'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Website /</span> Settings</h4>
        @include('admin.message')
        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Title And Logo</h5>
                    <div class="card-body">
                        <form name="logoForm" id="logoForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">WebPage Title</label>
                                    <textarea name="title" id="title" type="text" class="form-control"
                                    id="defaultFormControlInput" placeholder="Shirt"
                                    aria-describedby="defaultFormControlHelp" rows="3">{{ !empty($webData->title) ? $webData->title : " " }}</textarea>
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Description</label>
                                    <textarea name="description" id="description" type="text" class="form-control"
                                    id="defaultFormControlInput" placeholder="Shirt"
                                    aria-describedby="defaultFormControlHelp" rows="5">{{ !empty($webData->description) ? $webData->description : "" }}</textarea>
                                    <p></p>

                                </div>
                                <input type="hidden" id="image_id" name="image_id" value="">
                                <div class="col-md-6 mb-3">
                                <label for="defaultFormControlInput" class="form-label">Website Logo </label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($webData->image))
                                <div class="col-md-6 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">Current Logo</label><br>
                                    <img width="200px" src="{{ asset('uploads/logo/'.$webData->image) }}" alt="" >
                                </div>
                                @endif
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Save</button>
                            <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                    <h5 class="card-header">Favicon</h5>
                    <div class="card-body">
                        <form action="{{ route('faviconUpdate') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="image_id" name="image_id" value="">
                                <div class="col-md-6 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">Favicon Image</label>
                                    <input type="file" name="favicon" class="form-control" Required/>
                                </div>
                                @if (!empty($webData->favicon))
                                <div class="col-md-6 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">Current Favicon</label><br>
                                    <img width="50px" src="{{ asset($webData->favicon) }}" alt="" >
                                </div>
                                @endif
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Upload </button>
                            <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-default">Cancel</a>
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
        $('#logoForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("titleAndLogoUpdate") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        location.reload();
                        $('#title').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                        $('#description').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                    } else {
                        var errors = response['errors'];
                        if (errors['title']) {
                            $('#title').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['title'])
                        } else {
                            $('#title').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['description']) {
                            $('#description').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['description'])
                        } else {
                            $('#description').removeClass('is-invalid')
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
