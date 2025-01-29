@extends('admin.layouts.app')
@section('title'){{'Change Password'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Details</h4>
        @include('admin.message')

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Change Admin Image</h5>
                    <div class="card-body">
                        <form action="" method="post" name="upoadAdminImageForm" id="upoadAdminImageForm">
                            <div class="row mb-3">
                                <input type="hidden" id="image_id" name="image_id" value="">
                                <div class="form-group mb--40 col-sm-6 col-12">
                                    <label>Image (70 x 70 PX)</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                                <div id="userImage" class="form-group mb--40 col-sm-6 col-12">
                                    @if(!empty($admin->image))
                                    <div class="col-md-6 mb-3">
                                        <p style="margin:unset">Current Image</p>
                                        <img width="70px"
                                            src="{{ asset('uploads/user/'.$admin->image) }}"
                                            alt="" width="70px">
                                    </div>
                                    @endif
                                </div>

                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Upload </button>
                            <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                    <h5 class="card-header">Change Admin Password</h5>
                    <div class="card-body">
                        <form action="" method="post" name="changePasswordForm" id="changePasswordForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Create New Password</label>
                                    <input name="new_password" id="new_password" type="password" class="form-control"
                                        id="defaultFormControlInput" placeholder="Create New Password"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Confirm</label>
                                    <input name="confirm_password" id="confirm_password" type="password"
                                        class="form-control" id="defaultFormControlInput"
                                        placeholder="Confirm New Password" aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Current Password</label>
                                    <input name="current_password" id="current_password" type="password"
                                        class="form-control" id="defaultFormControlInput"
                                        placeholder="Type Old Password" aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>

                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Save </button>
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
        //admin image upload
        $('#upoadAdminImageForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("adminImageUpload") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response.status == true) {
                        location.reload();
                    }
                }
            });
        });

        //admin data store
        $('#changePasswordForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("processchangePassword") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('showChangePasswordForm') }}";
                    } else {
                        var errors = response['errors'];
                        if (errors['new_password']) {
                            $('#new_password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['new_password'])
                        } else {
                            $('#new_password').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['confirm_password']) {
                            $('#confirm_password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['confirm_password'])
                        } else {
                            $('#confirm_password').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['current_password']) {
                            $('#current_password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['current_password'])
                        } else {
                            $('#current_password').removeClass('is-invalid')
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