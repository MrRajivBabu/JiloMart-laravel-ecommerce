@extends('front.layouts.app2')
@section('title'){{ 'Paypal' }}@endsection
@section('customCss')
<style>

</style>
@endsection
@section('content')
<main class="main-wrapper">
  <div class="axil-checkout-area axil-section-gap">
      <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="axil-order-summery order-checkout-summery">
                  <h5 class="title mb--20">Pay & Confirm Order</h5>
                  <div class="summery-table-wrap">
                      <table class="table summery-table">
                          <thead>
                              <tr>
                                  <th>Details</th>
                                  @if ($order_details->payment_status == "not paid")
                                  <th><a class="text-danger" href="#" style="text-decoration: underline;font-size:16px" @if ($order_details)
                                    onclick="cancelOrder({{ $order_details->id }})" @endif>
                                    Cancel Order
                                  </a></th>
                                  @elseif($order_details->payment_status == "paid")
                                  <th><span class="badge bg-success">Already Paid</span></th>
                                  @else
                                  @endif
                              </tr>
                          </thead>
                          <tbody>
                              <tr class="order-subtotal">
                                  <td>Order Id</td>
                                  <td>@if ($order_details)
                                    #{{ $order_details->id }}
                                    @endif</td>
                              </tr>
                              <tr class="order-subtotal">
                                <td>Sub Total</td>
                                <td>@if ($order_details)
                                  ${{ $order_details->subtotal }}
                                  @endif</td>
                              </tr>
                              <tr class="order-subtotal">
                                  <td>Discount</td>
                                  <td id="order_discount" class="text-danger">-@if ($order_details)
                                    ${{ $order_details->discount }}
                                    @endif</td>
                              </tr>
                              <tr class="order-shipping">
                                  <td colspan="2">
                                      <div class="shipping-amount">
                                          <span class="title">Shipping Fee</span>
                                          <span class="amount"
                                              id="totalShippingCharge">@if ($order_details)
                                              ${{ $order_details->shipping }}
                                              @endif</span>
                                      </div>

                                  </td>
                              </tr>
                              <tr class="order-total">
                                  <td>Total</td>
                                  <td class="order-total-amount" id="grandTotal">
                                    @if ($order_details)
                                    ${{ $order_details->grand_total }}
                                    @endif</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  @if ($order_details->payment_status == "not paid")
                  <div id="paypal-button"></div>
                  @else
                  @endif
              </div>
          </div>
          </div>
      </div>
  </div>
</main> 

@endsection
@section('customJs')
<script>
  //cancel order
  function cancelOrder(id) {
    var url = '{{ route('order.cancel','ID ') }}'
    var newUrl = url.replace('ID', id)
    if (confirm("Are You Sure & Cancel Order ?")) {
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
            window.location.href = "{{ route('home.index') }}";
          }
        }
      });
    }
  }
</script>



<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'sandbox', //env: production for live payment
    client: {
      sandbox: 'AfOMyE9PzwZDd1uJDzex9zTV71o1Sbf_5Uu9sIw2cN-oXaLV9suCHptG7boZs4UhvSaIsfBxvgleDN2u',
      production: 'demo_production_client_id' //here live client id
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'responsive',
      color: 'blue',
      shape: 'pill',
    },
    // Enable Pay Now checkout flow (optional)
    commit: true,
    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        transactions: [{
          amount: {
            total: '{{ $order_details->grand_total }}',
            currency: 'USD'
          }
        }]
      });
    },
 
    // Execute the payment
    onAuthorize: function(data, actions) {
      //after payment successfull
      return actions.payment.execute().then(function() {
        //send data to response
        var order_id = '{{ $order_details->id }}';
        var pament_id = data.paymentID;
        var  payer_id = data.payerID;
        var  payer_email = '{{ $order_details->email }}';
        var  amount = '{{ $order_details->grand_total }}';
        var  currency = 'USD';
        var  payment_method = 'paypal';

        $.ajax({
          url: "{{ route('paypal-data-submit') }}",
            type: 'post',
            data: {
              //send data to response
              orderId:order_id,
              paymentId:pament_id,
              payerID:payer_id,
              payerEmail:payer_email,
              grandTotal:amount,
              paymentCurrency:currency,
              paymentMethod:payment_method,

            },
            dataType: 'json',
            success: function(response) {
             
            }
        });
        // Show a confirmation message to the buyer
        // window.alert('Thank you for your purchase!');
        window.location.href = "{{ url('/thanks/') }}/" + order_id;
        
      });
    }
 
  }, '#paypal-button');
</script>
{{-- <script> 
window.setTimeout(function() {
    window.location.href = "{{ route('home.index') }}";
}, 20000);
</script> --}}
@endsection