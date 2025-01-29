@extends('admin.layouts.app')
@section('title'){{'Order details'}}@endsection
@section('customCss')
<style>
  .print-button {
    float: right;
    background-color: #5F61E6;
    border: none;
    border-radius: 50px;
    padding: 3px 16px;
    color: #fff;
  }

  .print-button:hover {
    background-color: #71DD37;
    transition: all 0.3s ease-in;
    color: #000;
  }

  .print-button:not( :hover) {
    transition: all 0.3s ease-in;
  }

  @media print {
    body * {
      visibility: hidden;
    }

    #print-area,
    #print-area * {
      visibility: visible;
    }

    #print-area {
      position: absolute;
      top: -180px;
      left: 0px;
    }

    .proImg {
      display: none;
    }

    .sku {
      display: none;
    }
  }
</style>
@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">

    <div
      class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 mb-4">

      <div class="d-flex flex-column justify-content-center">
        <div class="mb-1">
          <span class="h5">
            
            Order #{{ $order->id }} 
            
          </span>

          @if ($order->payment_status == "paid")
          <span class="badge bg-label-success me-1 ms-2">{{ $order->payment_status }}</span>
          <span class="badge bg-label-primary me-1">{{ $order->payment }}</span>
          @elseif($order->payment_status == "not paid")
          @if ($order->payment == "cod")
          <span class="badge bg-label-primary me-1 ms-2">Cash On Delivery</span>
          @else
          <span class="badge bg-label-danger me-1 ms-2">{{ $order->payment_status }}</span>
          <span class="badge bg-label-primary me-1">{{ $order->payment }}</span>
          @endif
          @endif

          @if ($order->status == "pending")
          <span class="badge bg-label-secondary">{{ $order->status }}</span>
          @elseif($order->status == "shipped")
          <span class="badge bg-label-info">{{ $order->status }}</span>
          @elseif($order->status == "delivered")
          <span class="badge bg-label-success">{{ $order->status }}</span>
          @elseif($order->status == "cancelled")
          <span class="badge bg-label-danger">{{ $order->status }}</span>
          @endif

        </div>
        <p class="mb-0">
          <span>Purchase: {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</span>
          @if ($order->shipped_date)
          , Shipped: {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') }}
          @else
              
          @endif
        </p>
      </div>
      <div class="d-flex align-content-center flex-wrap gap-2">
        <span>
          <select name="status" id="paidStatus" class="form-select">
            <option value="paid" {{ ($order->payment_status == "paid") ? 'selected' : '' }}>Paid</option>
            <option value="not paid" {{ ($order->payment_status == "not paid") ? 'selected' : '' }}>Not Paid</option>
          </select>
        </span>
        <span>
          <select name="status" id="status" class="form-select">
            <option value="pending" {{ ($order->status == "pending") ? 'selected' : '' }}>Pending</option>
            <option value="shipped" {{ ($order->status == "shipped") ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ ($order->status == "delivered") ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ ($order->status == "cancelled") ? 'selected' : '' }}>Cancelled</option>
          </select>
        </span>
        <button class="btn btn-danger" id="deleteOrder" onclick="cancelOrder({{ $order->id }})">Delete Order <i class="bx bx-trash"></i></button>
        <button class="btn btn-primary" id="sendInvoice">Send Invoice <i class="bx bx-envelope"></i></button>

      </div>
    </div>

    <!-- Order Details Table -->

    <div class="row">
      <div class="col-12 col-lg-8">
        {{-- alert show --}}
        @include('admin.message')
        <div class="card mb-6">
          <div class="card-header d-flex flex-wrap justify-content-between">
            <h5 class="card-title m-0">Order Activity</h5>
            <button class="m-0 print-button" onclick="window.print()">Print <i class="bx bxs-printer"></i></button>
          </div>
          <div class="table-responsive" id="print-area">
            <table class="datatables-order-details table border-top dataTable no-footer dtr-column"
              id="DataTables_Table_0" style="width: 840px;">
              <thead>
                <tr>
                  <th class="w-50 sorting_disabled" rowspan="1" colspan="1" style="width: 320px;" aria-label="products">
                    products</th>
                  <th class="w-25 sorting_disabled" rowspan="1" colspan="1" style="width: 137px;" aria-label="price">
                    price</th>
                  <th class="w-25 sorting_disabled" rowspan="1" colspan="1" style="width: 127px;" aria-label="qty">qty
                  </th>
                  <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 42px;" aria-label="total">total
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($orderItems as $item)
                <tr>
                  <td class="sorting_1">
                    <div class="d-flex justify-content-start align-items-center text-nowrap">
                      <div class="avatar-wrapper proImg">
                        <div class="avatar avatar-sm me-3"><img
                            src="{{ asset('uploads/product/thumbnail/'.$item->image) }}" class="rounded-2"></div>
                      </div>
                      <div class="d-flex flex-column">
                        <a href="{{ route('product',$item->productSlug) }}" target="_blank">
                          <h6 class="text-heading mb-0">{{ substr($item->name,0, 40) }}</h6>
                        </a>
                        <small class="sku">SKU: {{ $item->productSku }}</small>
                      </div>
                    </div>
                  </td>
                  <td>${{ $item->price }}</td>
                  <td>{{ $item->qty }}</td>
                  <td class="" style="">${{ $item->total }}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="5" align="right"><span style="margin-right: 15px">Subtotal:</span>
                    <span>${{ number_format($order->subtotal,2) }}</span></td>
                </tr>
                <tr>
                  <td colspan="5" align="right"><span style="margin-right: 15px">Discount:</span>
                    <span>${{ number_format($order->discount,2) }}</span></td>
                </tr>
                <tr>
                  <td colspan="5" align="right"><span style="margin-right: 15px">Shipping Fee:</span>
                    <span>${{ number_format($order->shipping,2) }}</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" align="right">
                    <span style="margin-right: 15px">Total:</span>
                    <span>${{ number_format($order->grand_total,2) }}</span></td>
                </tr>
              </tbody>
            </table>
            <div class="card-body pt-1">
              <ul class="timeline pb-0 mb-0 row">
                <li class="timeline-item timeline-item-transparent border-primary col-sm-6">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header">
                      <h6 class="mb-0">Shipping Adress</h6>
                    </div>
                    <p class="mt-1">
                      Customer Name: {{ $order->first_name }} {{ $order->last_name }}.<br>
                      Phone: {{ $order->mobile }}. <br>
                      {{ $order->address }} <br>
                      {{ $order->apartment }} <br>
                      ({{ $order->zip }}) -
                      {{ $order->city }}
                      {{ $order->state }}, {{ $order->countryName }}.

                    </p>
                  </div>
                </li>
                <li class="timeline-item timeline-item-transparent border-primary col-sm-6">
                  <span class="timeline-point timeline-point-primary"></span>
                  <div class="timeline-event">
                    <div class="timeline-header">
                      <h6 class="mb-0">Payment Details</h6>
                    </div>
                    <p class="mt-1">
                      Order ID: #{{ $order->id }}<br>
                      Total Amount: ${{ number_format($order->grand_total,2) }}<br>
                      Method:
                      <span>
                        @if ($order->payment == "cod")
                          <span class="text-primary">CASH ON DELIVERY</span>
                        @else
                          <span style="text-transform:uppercase" class="text-primary">{{ $order->payment }}</span>
                        @endif
                      </span><br>
                      Payment Status:
                      @if ($order->payment_status == "paid")
                      <span class="text-success">PAID</span>
                      @elseif($order->payment_status == "not paid")
                      <span class="text-danger">NOT PAID</span>
                      @endif
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="card mb-6 mb-4">
          <div class="card-header">
            <h5 class="card-title m-0"><i class="bx bxs-user"></i> Customer details</h5>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-start align-items-center mb-6">
              <div class="d-flex flex-column">
                <h6 class="mb-0 mb-2">Customer Profile</h6>
                <span>Customer ID: #{{ $order->user_id }}</span>
              </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
              <h6 class="mb-1 mb-2">Contact info</h6>
              </h6>
            </div>
            <p class=" mb-1">Customer Name: {{ $order->first_name }} {{ $order->last_name }}</p>
            <p class=" mb-1">Email: {{ $order->email }}</p>
            <p class=" mb-0">Mobile: +88 {{ $order->mobile }}</p>
            <div class="d-flex justify-content-between mt-3">
              <h6 class="mb-1 mb-2">Shipping address</h6>
            </div>
            <p class="mb-0">{{ $order->address }} <br>{{ $order->apartment }} <br>({{ $order->zip }}) -
              {{ $order->city }}<br>{{ $order->state }}, {{ $order->countryName }}</p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- / Content -->
  @endsection

  @section('customJs')
  <script>
    //order status update
    $("#status").change(function(){
      var orderStatus = $(this).val();
      $.ajax({
                url: "{{ route('order.changeOrderStatus',$order->id) }}",
                type: 'post',
                data: {order_status:orderStatus},
                dataType: 'json',
                success: function(response){
                  if (response.status == true) {
                    window.location.href = "";
                  }
                  
                },
                error: function(response){
                    console.log("something went wrong");
                }
            });
    });

    //paid status update
    $("#paidStatus").change(function(){
      var paidStatus = $(this).val();
      $.ajax({
                url: "{{ route('order.changePaidStatus',$order->id) }}",
                type: 'post',
                data: {paid_status:paidStatus},
                dataType: 'json',
                success: function(response){
                  if (response.status == true) {
                    window.location.href = "";
                  }
                  
                },
                error: function(response){
                    console.log("something went wrong");
                }
            });
    });

    //send invoice email
    $("#sendInvoice").click(function(event){
      event.preventDefault();
      if(confirm("Are Youu Sure To Send Invoice Mail?")){
        $.ajax({
                  url: "{{ route('order.sendInvoiceEmail',$order->id) }}",
                  type: 'post',
                  dataType: 'json',
                  success: function(response){
                    if (response.status == true) {
                      window.location.href = "";
                    }
                    
                  },
                  error: function(response){
                      console.log("something went wrong");
                  }
              });
      }  
    });

  </script>
  <script>
    //delete order
    function cancelOrder(id) {
      var url = '{{ route('order.delete','ID ') }}'
      var newUrl = url.replace('ID', id)
      if (confirm("Are You Sure & Delete This Order ?")) {
        $.ajax({
          url: newUrl,
          type: 'delete',
          data: {},
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            if (response.status == true) {
              window.location.href = "{{ route('order.index') }}";
            }
          }
        });
      }
    }
  </script>
  @endsection