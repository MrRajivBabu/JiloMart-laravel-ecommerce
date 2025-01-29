@extends('admin.layouts.app')
@section('title'){{'Shipping Create'}}@endsection
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
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                        @endif
                                        <option value="rest_of_world">Rest Of The World</option>
                                    </select>
                                    <p></p>

                                </div>
                                <div class="col-md-6 my-3">
                                    <label for="defaultFormControlInput" class="form-label">Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control" placeholder="50">
                                    <p></p>

                                </div>

                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"> Create</button>
                            <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                    <div class="card-body">

                        <!-- Start main content -->
                        <div class="table-responsive text-nowrap">

                            <table class="table" id="myTable">
                                <thead>
                                    <tr>

                                        <th>Place</th>
                                        <th>Shipping Charge</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="tbody">

                                    @if ($shippingCharges->isNotEmpty())

                                    @foreach($shippingCharges as $shippingCharge)

                                    <tr>

                                        <td><strong>
                                            {{ ($shippingCharge->country_id == 'rest_of_world') ? 'Rest Of The World' : $shippingCharge->name }}
                                        </strong></td>
                                        <td>${{ $shippingCharge->amount }}</td>
                                        <td>
                                
                                            <a href="{{ route('shipping.edit',$shippingCharge->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i></a>&nbsp;
                                            <a href="javascript:void(0);" onclick="deleteSipping({{$shippingCharge->id}});"><i
                                                    class="bx bx-trash me-1"></i></a>

                                        </td>

                                    </tr>
                                    @endforeach()
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Records Found...</td>
                                    </tr>
                                    @endif

                                </tbody>

                            </table>

                        </div>
                        <!-- // End main content -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @endsection

    @section('customJs')
    <script>
            //data table
    $(document).ready(function() {
      $.fn.dataTableExt.sErrMode = 'throw';
      $('#myTable').DataTable({
        order: false
      });
      document.getElementById("dt-search-0").setAttribute("placeholder", "Search Here...");
     
    });

        //shipping data store
        $('#shippingForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            //when input data then button disabled
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route("shipping.store") }}',
                type: 'post',
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
    //delete
    function deleteSipping(id) {
      var url = '{{ route('shipping.delete','ID ') }}'
      var newUrl = url.replace('ID', id)
      if (confirm("Are You Sure & Want To Delete ?")) {
        $.ajax({
          url: newUrl,
          type: 'delete',
          data: {},
          dataType: 'json',
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          success: function(response) {

              window.location.href = "{{ route('shipping.create') }}";

          }
        });
      }
    }
    </script>
    @endsection