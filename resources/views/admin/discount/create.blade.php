@extends('admin.layouts.app')
@section('title'){{'Discount create'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Discount /</span> Coupon</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Create New</h5>
                    <div class="card-body">
                        <form action="" method="post" name="discountForm" id="discountForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="code" class="form-label">Code</label>
                                    <input name="code" id="code" type="text" class="form-control"
                                        placeholder="RFG56b"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input name="name" id="name" type="text" class="form-control"
                                        placeholder="Coupon code name"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" type="text" class="form-control" placeholder="Description"
                                        aria-describedby="defaultFormControlHelp"></textarea>
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="max_uses" class="form-label">Max Uses</label>
                                    <input name="max_uses" id="max_uses" type="number" class="form-control"
                                         placeholder="Maximum Number Can Use"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="max_uses_user" class="form-label">Max Uses User</label>
                                    <input name="max_uses_user" id="max_uses_user" type="number" class="form-control"
                                        placeholder="Maximum Number Can Use By a Customer"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Discount Type</label>
                                    <select id="type" name="type" class="form-select">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_amount" class="form-label">Discount Amount</label>
                                    <input name="discount_amount" id="discount_amount" type="number" class="form-control"
                                    placeholder="Discount Amount"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="min_amount" class="form-label">Min Amount</label>
                                    <input name="min_amount" id="min_amount" type="number" class="form-control"
                                    placeholder="min amount need to shopping"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="starts_at" class="form-label">Start Time</label>
                                    <input autocomplete="off" name="starts_at" id="starts_at" type="text" class="form-control"
                                    placeholder="Start At"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>

                                <div class="col-md-6">
                                    <label for="expires_at" class="form-label">Expires Time</label>
                                    <input autocomplete="off" name="expires_at" id="expires_at" type="text" class="form-control"
                                    placeholder="Expires At"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Create</button>
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
        $('#discountForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("discount.store") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('discount.index') }}"

                        $('#code').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")

                        $('#discount_amount').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("") 
                                
                        $('#starts_at').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")    
                        
                        $('#expires_at').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")        
                       
                    } else {
                        var errors = response['errors'];
                        if (errors['code']) {
                            $('#code').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['code'])
                        } else {
                            $('#code').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['discount_amount']) {
                            $('#discount_amount').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['discount_amount'])
                        } else {
                            $('#discount_amount').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['starts_at']) {
                            $('#starts_at').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['starts_at'])
                        } else {
                            $('#starts_at').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['expires_at']) {
                            $('#expires_at').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['expires_at'])
                        } else {
                            $('#expires_at').removeClass('is-invalid')
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

        //start at and expire at - datetime plugin
        $(document).ready(function(){
            $('#starts_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });
        $(document).ready(function(){
            $('#expires_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });

    </script>
    @endsection
