@extends('admin.layouts.app')
@section('title'){{'User Edit'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Customer /</span> Details</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Edit Details</h5>
                    <div class="card-body">
                        <form action="" method="post" name="UpdateUserForm" id="UpdateUserForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Username</label>
                                    <input value="{{ $user->username }}" name="username" id="username" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="rafiq585"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Email</label>
                                    <input value="{{ $user->email }}" name="email" id="email" type="email" class="form-control"
                                        id="defaultFormControlInput" placeholder="Rafiq@gmail.com"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Full name</label>
                                    <input value="{{ $user->name }}" name="name" id="name" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="Rafiq Uddin"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Password</label>
                                    <input name="password" id="password" type="password" class="form-control"
                                        id="defaultFormControlInput" placeholder="Enter New password"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p>(If you want to change password, fill input otherwise keep blank.)</p>
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Phone Number</label>
                                    <input value="{{ $user->mobile }}" name="mobile" id="mobile" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="+880 1406828387"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="1" {{ ($user->status == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ ($user->status == 0) ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Update </button>
                            <a href="{{ route('users.index') }}" type="button" class="btn btn-default">Cancel</a>

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
        //user data update
        $('#UpdateUserForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("users.update",$user->id) }}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('users.index') }}";

                    } else {
                        var errors = response['errors'];
                        //show input error if empty
                        if (errors['username']) {
                            $('#username').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['username'])
                        } else {
                            $('#username').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['email']) {
                            $('#email').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['email'])
                        } else {
                            $('#email').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['name']) {
                            $('#name').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['name'])
                        } else {
                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['mobile']) {
                            $('#mobile').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['mobile'])
                        } else {
                            $('#mobile').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['password']) {
                            $('#password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['password'])
                        } else {
                            $('#password').removeClass('is-invalid')
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

    </script>
    @endsection

