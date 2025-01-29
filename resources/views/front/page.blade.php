@extends('front.layouts.app2')
@section('title'){{ $page->name }}@endsection
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
              <li class="axil-breadcrumb-item active" aria-current="page">Pages</li>
            </ul>
            <h1 class="title">{{ $page->name }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Breadcrumb Area  -->
  {{-- page content --}}
  {!! $page->content !!}
  {{-- //page content --}}
  @endsection