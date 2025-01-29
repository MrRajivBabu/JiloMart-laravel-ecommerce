@extends('admin.layouts.app')
@section('title'){{'Order Active'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Order /</span> Active</h4>
    @include('admin.message')

    <div class="row">
      <div>
        <div class="card mb-4">

          <h5 class="card-header">
            Active Orders

          </h5>

          <div class="card-body">

            <!-- Start main content -->
            <div class="table-responsive text-nowrap">

              <table class="table" id="myTable">
                <thead>
                  <tr>

                    <th>Orders #</th>
                    <th>Customer Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Pament Method</th>
                    <th>Date Purchased</th>

                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody">

                  @if ($orders->isNotEmpty())

                  @foreach($orders as $order)

                  <tr>

                    <td><a href="{{ route('order.detail',$order->id) }}"><strong>#{{ $order->id }}</strong></a></td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->mobile }}</td>
                    <td>
                        @if ($order->status == "pending")
                            <span class="badge bg-primary">{{ $order->status }}</span>
                        @elseif($order->status == "shipped")
                            <span class="badge bg-info">{{ $order->status }}</span>
                        @elseif($order->status == "delivered")
                            <span class="badge bg-success">{{ $order->status }}</span>  
                        @elseif($order->status == "cancelled")
                            <span class="badge bg-danger">{{ $order->status }}</span>      
                        @endif
                    </td>
                    <td>${{ number_format($order->grand_total,2) }}</td>
                    <td>
                        @if ($order->payment == "cod")
                        <span>Cash On Delivery</span>
                        @else
                        <span>{{ $order->payment }}</span> 
                            @if($order->payment_status == "paid")
                                <span class="text-success">({{ $order->payment_status }})</span>
                            @elseif($order->payment_status == "not paid")
                                <span class="text-danger">({{ $order->payment_status }})</span>
                            @endif
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
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



    // //delete
    // function deleteCategory(id) {
    //   var url = '{{ route('categories.delete','ID ') }}'
    //   var newUrl = url.replace('ID', id)
    //   if (confirm("Are You Sure & Want To Delete ?")) {
    //     $.ajax({
    //       url: newUrl,
    //       type: 'delete',
    //       data: {},
    //       dataType: 'json',
    //       headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //       success: function(response) {
    //         if (response['status']) {
    //           //redirect after create
    //           window.location.href = "{{ route('categories.index') }}";
    //         }
    //       }
    //     });
    //   }
    // }


  </script>
  @endsection

