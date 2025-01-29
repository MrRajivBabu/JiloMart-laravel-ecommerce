@extends('admin.layouts.app')
@section('title'){{'Shipping Edit'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shipping /</span> Charges</h4>
        @include('admin.message')

        <div class="row">
            <div>
                <div class="card mb-4">
                    <h5 class="card-header">Shipping Management</h5>
                    <div class="card-body">
                        <form action="" method="post" name="shippingForm" id="shippingForm">
                            <div class="row">
                                <div class="col-md-6 my-3">
                                    <label for="defaultFormControlInput" class="form-label">Country List</label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select A Country</option>
                                        @if($countries->isNotEmpty())
                                        @foreach($countries as $country)
                                        <option {{ ($shippingCharge->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                        @endif
                                        <option {{ ($shippingCharge->country_id == 'rest_of_world') ? 'selected' : '' }} value="rest_of_world">Rest Of The World</option>
                                    </select>
                                    <p></p>

                                </div>
                                <div class="col-md-6 my-3">
                                    <label for="defaultFormControlInput" class="form-label">Amount</label>
                                    <input value="{{ $shippingCharge->amount }}" type="text" name="amount" id="amount" class="form-control" placeholder="50">
                                    <p></p>

                                </div>

                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Update</button>
                            <a href="{{ route('shipping.create') }}" type="button" class="btn btn-default">Cancel</a>
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

        //shipping data store
        $('#shippingForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("shipping.update",$shippingCharge->id) }}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        //redirect after create
                        window.location.href = "{{ route('shipping.create') }}";
                    } else {
                        var errors = response['errors'];
                        if (errors['country']) {
                            $('#country').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['country'])
                        } else {
                            $('#country').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                        if (errors['amount']) {
                            $('#amount').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['amount'])
                        } else {
                            $('#amount').removeClass('is-invalid')
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
