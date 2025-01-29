@extends('front.layouts.app2')
@section('title'){{ 'Contact' }}@endsection
@section('customCss')
<style>

</style>
@endsection
@section('content')
<main class="main-wrapper">
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">Contact</li>
                        </ul>
                        <h1 class="title">Contact With Us</h1>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start Contact Area  -->
    <div class="axil-contact-page-area axil-section-gap">
        <div class="container">
            <div class="axil-contact-page">
                <div class="row row--30">
                    <div class="col-lg-8">
                        <div class="contact-form">
                            <h3 class="title mb--10">We would love to hear from you.</h3>
                            <p>If you’ve got great products your making or looking to work with us then drop us a line.</p>
                            <form id="contactForm" name="contactForm" class="axil-contact-form">
                                <div class="row row--10">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name">Name <span>*</span></label>
                                            <input type="text" name="name" id="name">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="phone">Phone <span>*</span></label>
                                            <input type="text" name="phone" id="phone">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">E-mail <span>*</span></label>
                                            <input type="email" name="email" id="email">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="message">Your Message</label>
                                            <textarea name="message" id="message" cols="1" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb--0">
                                            <button name="submit" type="submit" id="contact-submit" class="axil-btn btn-bg-primary">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-location mb--40">
                            <h4 class="title mb--20">Our Store</h4>
                            <span class="address mb--20">8212 E. Glen Creek Street Orchard Park, NY 14127, United States of America</span>
                            <span class="phone">Phone: +123 456 7890</span>
                            <span class="email">Email: Hello@etrade.com</span>
                        </div>
                        <div class="contact-career mb--40">
                            <h4 class="title mb--20">Careers</h4>
                            <p>Instead of buying six things, one that you really like.</p>
                        </div>
                        <div class="opening-hour">
                            <h4 class="title mb--20">Opening Hours:</h4>
                            <p>Monday to Saturday: 9am - 10pm
                                <br> Sundays: 10am - 6pm
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Google Map Area  -->
            <div class="axil-google-map-wrap axil-section-gap pb--0">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="1080" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=melbourne&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"></iframe>
                    </div>
                </div>
            </div>
            <!-- End Google Map Area  -->
        </div>
    </div>
    <!-- End Contact Area  -->
@endsection
@section('customJs')
<script>
    $("#contactForm").submit(function(event) {
        event.preventDefault();
        $("#contact-submit").prop('disabled',true);//button disable
        $.ajax({
            url: "{{ route('sendContactMail') }}",
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                $("#contact-submit").prop('disabled',false);//button enable
                if (response.status == true) {
                    location.reload();
                }else{
                    var errors = response.errors;
                    if (errors.name) {
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                    }else{
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.phone) {
                        $("#phone").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.phone);
                    }else{
                        $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.email) {
                        $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                    }else{
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            }
        });
    });
</script>
@endsection