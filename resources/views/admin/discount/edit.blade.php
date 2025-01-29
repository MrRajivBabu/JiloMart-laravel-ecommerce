@extends('admin.layouts.app')
@section('title'){{'Discount edit'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Discount /</span> Coupon</h4>

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Coupon Edit</h5>
                    <div class="card-body">
                        <form action="" method="post" name="discountForm" id="discountForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="code" class="form-label">Code</label>
                                    <input value="{{ $coupon->code }}" name="code" id="code" type="text" class="form-control"
                                        placeholder="RFG56b"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input value="{{ $coupon->name }}" name="name" id="name" type="text" class="form-control"
                                        placeholder="Coupon code name"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" type="text" class="form-control" placeholder="Description"
                                        aria-describedby="defaultFormControlHelp">{{ $coupon->description }}</textarea>
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="max_uses" class="form-label">Max Uses</label>
                                    <input value="{{ $coupon->max_uses }}" name="max_uses" id="max_uses" type="number" class="form-control"
                                         placeholder="Maximum Number Can Use"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="max_uses_user" class="form-label">Max Uses User</label>
                                    <input value="{{ $coupon->max_uses_user }}" name="max_uses_user" id="max_uses_user" type="number" class="form-control"
                                        placeholder="Maximum Number Can Use By a Customer"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Discount Type</label>
                                    <select id="type" name="type" class="form-select">
                                        <option {{ ($coupon->type == 'percent') ? 'selected' : '' }} value="percent">Percent</option>
                                        <option {{ ($coupon->type == 'fixed') ? 'selected' : '' }} value="fixed">Fixed</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_amount" class="form-label">Discount Amount</label>
                                    <input value="{{ $coupon->discount_amount }}" name="discount_amount" id="discount_amount" type="number" class="form-control"
                                    placeholder="Discount Amount"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                <div class="col-md-6">
                                    <label for="min_amount" class="form-label">Min Amount</label>
                                    <input value="{{ $coupon->min_amount }}" name="min_amount" id="min_amount" type="number" class="form-control"
                                    placeholder="min amount need to shopping"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                

                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option {{ ($coupon->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ ($coupon->status == 0) ? 'selected' : '' }} value="0">Deactive</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="starts_at" class="form-label">Start Time</label>
                                    <input value="{{ $coupon->starts_at }}" autocomplete="off" name="starts_at" id="starts_at" type="text" class="form-control"
                                    placeholder="Start At"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>

                                <div class="col-md-6">
                                    <label for="expires_at" class="form-label">Expires Time</label>
                                    <input value="{{ $coupon->expires_at }}" autocomplete="off" name="expires_at" id="expires_at" type="text" class="form-control"
                                    placeholder="Expires At"
                                        aria-describedby="defaultFormControlHelp" />
                                    <p></p>

                                </div>
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Update</button>
                            <a href="{{ route('discount.index') }}" type="button" class="btn btn-default">Cancel</a>
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
                url: '{{ route("discount.update", $coupon->id) }}',//change
                type: 'put',//change
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

