@extends('admin.layouts.app')
@section('title'){{'Pages create'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Static Page /</span> Create</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Create New</h5>
                    <div class="card-body">
                        <form action="" method="post" name="pageForm" id="pageForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Page Name</label>
                                    <input name="name" id="name" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="Shirt"
                                        aria-describedby="defaultFormControlHelp"/>
                                    <p></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Slug</label>
                                    <input name="slug" id="slug" type="text" class="form-control"
                                        id="defaultFormControlInput" placeholder="lycra-shirts"
                                        aria-describedby="defaultFormControlHelp"/>
                                    <p></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">Page Content</label>
                                <textarea name="content" id="content" class="summernote"></textarea>
                                </div>

                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Create</button>
                            <a href="{{ route('pages.index') }}" type="button" class="btn btn-default">Cancel</a>
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

        //pages data store
        $('#pageForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("pages.store") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('pages.index') }}";
                        $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                        $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")
                    } else {
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



    </script>
    @endsection

