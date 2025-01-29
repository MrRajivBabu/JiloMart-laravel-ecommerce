@extends('admin.layouts.app')
@section('title'){{'Product Stockout'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Stock Out</h4>
    @include('admin.message')

    <div class="row">
      <div>
        <div class="card mb-4">

          <h5 class="card-header">
            Out Of Stock Products

          </h5>

          <div class="card-body">

            <!-- Start main content -->
            <div class="table-responsive text-nowrap">

              <table class="table" id="myTable">
                <thead>
                  <tr>

                    <th>Products</th>
                    <th>SKU</th>
                    <th>Thumbnail</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Gallery </i><i class="bx bx-images"></i></th>
                    <th>Action <i class='bx bx-mouse'></i></th>

                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody">

                  @if ($products->isNotEmpty())

                  @foreach($products as $product)

                  <tr>

                    <td><strong>{{ substr($product->title, 0, 25) }}</strong></td>
                    <td>{{ $product->sku }}</td>
                    <td><img src="{{ asset('uploads/product/thumbnail/'.$product->image) }}" alt="" width="40px"></td>
                    <td>{{ $product->price }} $</td>
                    <td>{{ $product->qty }}</td>
                    @if ($product->status == 1)
                    <td><span class="badge bg-label-success">Active</span></td>
                    @else
                    <td><span class="badge bg-label-danger">Deactive</span></td>
                    @endif
                    <td>
                    <a href="{{ route('products-image.upload',$product->id) }}"><i class='bx bx-plus-circle'></i></a>
                    @if($product->product_images->isNotEmpty())
                    @foreach($product->product_images as $product_image)
                    <img src="{{ asset($product_image->image) }}" alt="" width="25px" style="margin-left:5px">
                    @endforeach()
                    @endif
                    </td>
                    <td>

                      <a href="{{ route('products.edit',$product->id) }}"><i class="bx bx-edit-alt me-1"></i></a>&nbsp;
                      <a href="#" onclick="deleteProduct({{ $product->id }})"><i class="bx bx-trash me-1"></i></a>

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

  @endsection

  @section('customJs')
  <script>
    //data table
    $(document).ready(function() {
      $.fn.dataTableExt.sErrMode = 'throw';
      $('#myTable').DataTable({
        order: false,

      });
      document.getElementById("dt-search-0").setAttribute("placeholder", "Search Here...");

    });



    //delete
    function deleteProduct(id) {
      var url = '{{ route('products.delete','ID ') }}'
      var newUrl = url.replace('ID', id)
      if (confirm("Are You Sure & Want To Delete ?")) {
        $.ajax({
          url: newUrl,
          type: 'delete',
          data: {},
          dataType: 'json',
          success: function(response) {
            if (response['status']) {
              //redirect after create
              window.location.href = "{{ route('products.index') }}";
            }
          }
        });
      }
    }


  </script>
  @endsection
