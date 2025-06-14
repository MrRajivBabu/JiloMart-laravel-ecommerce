@extends('admin.layouts.app')
@section('title'){{'Category List'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Category /</span> List</h4>
    @include('admin.message')

    <div class="row">
      <div>
        <div class="card mb-4">

          <h5 class="card-header">
            All Categories

            <a href="{{ route('categories.create') }}" type="button"
              class="btn btn-primary float-end upper-add-new-button"><i class="tf-icons bx bx-plus"></i> Add New</a>

          </h5>

          <div class="card-body">

            <!-- Start main content -->
            <div class="table-responsive text-nowrap">

              <table class="table" id="myTable">
                <thead>
                  <tr>

                    <th>Name</th>
                    <th></th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody">

                  @if ($categories->isNotEmpty())

                  @foreach($categories as $category)

                  <tr>

                    <td><strong>{{ $category->name }}</strong></td>
                    <td><img src="{{ asset('uploads/category/'.$category->image) }}" alt="" width="30px"></td>
                    <td>{{ $category->slug }}</td>
                    @if ($category->status == 1)
                    <td><span class="badge bg-label-success">Active</span></td>
                    @else
                    <td><span class="badge bg-label-danger">Deactive</span></td>
                    @endif
                    <td>

                      <a href="{{ route('categories.edit',$category->id) }}"><i
                          class="bx bx-edit-alt me-1"></i></a>&nbsp;
                      <a href="#" onclick="deleteCategory({{ $category->id }})"><i class="bx bx-trash me-1"></i></a>

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
    function deleteCategory(id) {
      var url = '{{ route('categories.delete','ID ') }}'
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
              window.location.href = "{{ route('categories.index') }}";
            }
          }
        });
      }
    }


  </script>
  @endsection
