@extends('admin.layouts.app')
@section('title'){{'Sub Category List'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sub Category /</span> List</h4>
    @include('admin.message')

    <div class="row">
      <div>
        <div class="card mb-4">

          <h5 class="card-header">
            All Sub Categories

            <a href="{{ route('sub-categories.create') }}" type="button"
              class="btn btn-primary float-end upper-add-new-button"><i class="tf-icons bx bx-plus"></i> Add New</a>

          </h5>

          <div class="card-body">

            <!-- Start main content -->
            <div class="table-responsive text-nowrap">

              <table class="table" id="myTable">
                <thead>
                  <tr>

                    <th>Name</th>
                    <th>Category</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody">

                  @if ($subCategories->isNotEmpty())

                  @foreach($subCategories as $sub_category)

                  <tr>

                    <td><strong>{{ $sub_category->name }}</strong></td>
                    <td>{{ $sub_category->Category_name }}</td>
                    <td>{{ $sub_category->slug }}</td>
                    @if ($sub_category->status == 1)
                    <td><span class="badge bg-label-success">Active</span></td>
                    @else
                    <td><span class="badge bg-label-danger">Deactive</span></td>
                    @endif
                    <td>

                      <a href="{{ route('sub-category.edit',$sub_category->id) }}"><i
                          class="bx bx-edit-alt me-1"></i></a>&nbsp;
                      <a href="#" onclick="deleteSubCategory({{ $sub_category->id }})"><i class="bx bx-trash me-1"></i></a>

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
    function deleteSubCategory(id) {
      var url = '{{ route('sub-category.delete','ID ') }}'
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

              window.location.href = "{{ route('sub-category.index') }}";

          }
        });
      }
    }


  </script>
  @endsection