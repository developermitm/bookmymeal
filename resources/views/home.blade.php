@extends('layouts.app')

@section('content')
@include('header')
<div class="container-flude ">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner image-div">
  <div class="container-flude bg-white ">
    <div class="carousel-item active">
      <img class="d-block w-100 image-item" src="{{asset('images/laptop.jpg')}}" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
      <h5>...</h5>
      <p>...</p>
      </div>
    </div>

    <div class="carousel-item">
      <img class="d-block w-100 image-item" src="{{asset('images/radio.jpg')}}" alt="Second slide">
      <div class="carousel-caption d-none d-md-block">
      <h5>...</h5>
      <p>...</p>
    </div>
    </div>

    <div class="carousel-item">
      <img class="d-block w-100 image-item" src="{{asset('images/camera.jpg')}}" alt="Third slide">
      <div class="carousel-caption d-none d-md-block">
      <h5>...</h5>
      <p>...</p>
     </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

 
<br><br>




</div>
    



@endsection
