@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Service Location</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Service Location</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="col-lg-12">
                    @if(session()->has('message'))
                        @if($message = Session::get('message'))
                            <div class="alert alert-success"> {{ $message }} </div>
                        @endif
                    @endif

                  <div class="text-right">
                    <a href="{{url('service-location-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Location List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="banner-form" id="banner-form" action="{{route('service-location.update', $getDetails->id)}}" enctype="multipart/form-data">
                        @method('PATCH')
                        {{ csrf_field() }}
                        <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                              <label> Address </label>
                              <input type="text" name="address" id="address" value="{{$getDetails->location}}" autocomplete="on" class="form-control" placeholder="Enter Address" required>
                            </div>    
                          </div>


                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Status </label> <br>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" {{($getDetails->status == 1) ? 'checked' : '' }} >
                                <label for="radioPrimary1">Active
                                </label>
                              </div>  

                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" {{($getDetails->status == 0) ? 'checked' : '' }} >
                                <label for="radioPrimary2">InActive
                                </label>
                              </div>
                            </div>    
                          </div>
                        </div>
                        
                      <input type = "hidden" id ="lat" name="lat" value="{{$getDetails->lat}}">
                      <input type = "hidden" id ="lang" name="lang" value="{{$getDetails->lang}}">
                      
                      <input type="submit" name="submit" value="submit" class="btn btn-md customBtn">  
                      </form>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<script type="text/javascript">
  document.getElementById('bannerImage').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>

@endsection           