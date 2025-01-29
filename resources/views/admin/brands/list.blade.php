@extends('admin.layouts.app')
@section('title'){{'Brand List'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Brands /</span> List</h4>
    @include('admin.message')

    <div class="row">
      <div>
        <div class="card mb-4">

          <h5 class="card-header">
            All Brands

            <a href="{{ route('brands.create') }}" type="button"
              class="btn btn-primary float-end upper-add-new-button"><i class="tf-icons bx bx-plus"></i> Add New</a>

          </h5>

          <div class="card-body">

            <!-- Start main content -->
            <div class="table-responsive text-nowrap">

              <table class="table" id="myTable">
                <thead>
                  <tr>

                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody">

                  @if ($brands->isNotEmpty())

                  @foreach($brands as $brand)

                  <tr>

                    <td><strong>{{ $brand->name }}</strong></td>
                    <td>{{ $brand->slug }}</td>
                    @if ($brand->status == 1)
                    <td><span class="badge bg-label-success">Active</span></td>
                    @else
                    <td><span class="badge bg-label-danger">Deactive</span></td>
                    @endif
                    <td>

                      <a href="{{ route('brands.edit',$brand->id) }}"><i
                          class="bx bx-edit-alt me-1"></i></a>&nbsp;
                      <a href="#" onclick="deleteBrand({{ $brand->id }})"><i class="bx bx-trash me-1"></i></a>

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
        order: false
      });
      document.getElementById("dt-search-0").setAttribute("placeholder", "Search Here...");
     
    });



    //delete
    function deleteBrand(id) {
      var url = '{{ route('brands.delete','ID ') }}'
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
            if (response['status']) {
              //redirect after create
              window.location.href = "{{ route('brands.index') }}";
            }
          }
        });
      }
    }


  </script>
  @endsection
