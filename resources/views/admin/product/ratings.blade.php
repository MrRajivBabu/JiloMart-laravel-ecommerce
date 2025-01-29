@extends('admin.layouts.app')
@section('title'){{'Product Ratings'}}@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reviews /</span> List</h4>
        @include('admin.message')

        <div class="row">
            <div>
                <div class="card mb-4">

                    <h5 class="card-header">
                        All Ratings

                    </h5>

                    <div class="card-body">

                        <!-- Start main content -->
                        <div class="table-responsive text-nowrap">

                            <table class="table" id="myTable">
                                <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Approve</th>
                                        <th>Remove</th>

                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="tbody">
                                    @if(!empty($ratings))
                                    @foreach ($ratings as $rating)
                                    <tr>
                                        <td>
                                            <button class="text-primary border-0 bg-transparent rating_view" data-bs-toggle="modal"
                                                data-bs-target="#single-view-rating-modal" value="{{ $rating->id }}"><strong>{{ substr($rating->productTitle, 0, 25) }}</strong></button>
                                        </td>
                                        <td>
                                            @if ($rating->rating == 5)
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            @elseif($rating->rating == 4)
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bx-star"></i>
                                            @elseif($rating->rating == 3)
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bx-star"></i>
                                            <i class="bx bx-star"></i>
                                            @elseif($rating->rating == 2)
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bx-star"></i>
                                            <i class="bx bx-star"></i>
                                            <i class="bx bx-star"></i>
                                            @else
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bx-star"></i>
                                            <i class="bx bx-star"></i>
                                            <i class="bx bx-star"></i>
                                            <i class="bx bx-star"></i>
                                            @endif
                                            ({{ number_format($rating->rating,2) }})
                                        </td>
                                        <td>"{{ substr($rating->comment, 0, 45) }}"</td>
                                        <td>{{ $rating->name }}</td>
                                        <td>
                                        @if ($rating->status == 1)
                                        <span class="badge bg-label-success">Approved</span>
                                        @else
                                        <span class="badge bg-label-danger">UnActive</span>
                                        @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                            @if($rating->status == 1)
                                                <input onclick="changeRatingStatus(0,'{{ $rating->id }}');" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                                            @else
                                                <input onclick="changeRatingStatus(1,'{{ $rating->id }}');" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                            @endif
                                            </div>
                                        </td>

                                        <td>
                                            
                                            <a href="#" onclick="deleteRating({{ $rating->id }})"><i
                                                    class="bx bx-trash"></i></a>
                                        </td>

                                    </tr>
                                    @endforeach
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
        $(document).ready(function() {
            $(document).on('click', '.rating_view', function() {
                var rating_id = $(this).val();
                //alert(rating_id);
                $.ajax({
                    type: "get",
                    url: "/admin/rating-view/"+rating_id,
                    success: function(response) {
                            //first clear data
                            $('#review_email').text();
                            $('#review_name').text();
                            $('#review_comment').html('');
                            $('#review_rating').html('');
                        if(response.status == true){
                            //show data in modal
                            $('#review_email').text(response.rating.email);
                            $('#review_name').text(response.rating.name);
                            $('#review_comment').html('"'+response.rating.comment+'"');
                            $('#review_rating').html(''+response.rating.rating+' star');
                        }
                    }
                });
            });
        });
        //data table
        $(document).ready(function() {
            $.fn.dataTableExt.sErrMode = 'throw';
            $('#myTable').DataTable({
                order: false
            });
            document.getElementById("dt-search-0").setAttribute("placeholder", "Search Here...");
        });
        //delete rating
        function deleteRating(id) {
            var url = '{{ route('ratings.delete','ID ') }}'
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
                        if (response.status == true) {
                            //redirect after create
                            location.reload();
                        }
                    }
                });
            }
        }

        // change status by on/off switch button
        function changeRatingStatus(status,id) {

                $.ajax({
                    url: "{{ route('changeRatingStatus') }}",
                    type: 'post',
                    data: {ratingStatus:status, ratingId:id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        location.reload()

                    }
                });
            
        }
        
    </script>
    @endsection