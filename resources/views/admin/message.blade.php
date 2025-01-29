@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span>{{ Session::get('error') }} </span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <span> {{ Session::get('success') }} </span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<script>
    // flash message js
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
</script>
