@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Profile</li>
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
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="brand-form" id="brand-form" action="{{url('admin/profile')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Name </label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Enter Username" value="{{ $getDetails->name}}" required>
                                @error('username')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror

                            </div>    
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Email </label>
                             <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" value="{{ $getDetails->email }}" required>

                             @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror

                            </div>    
                          </div> 

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Password </label>
                             <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" value="{{$getDetails->user_pass}}">
                             @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror

                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Address1 </label>
                                <input type="text" name="address1" value="{{ !empty($address->address1) ? $address->address1 : '' }}" class="form-control" placeholder="Enter Address">
                            </div>    
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Address2 </label>
                                <input type="text" name="address2" value="{{ !empty($address->address2) ? $address->address2 : '' }}" class="form-control" placeholder="Enter Address">
                            </div>    
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>City </label>
                                <input type="text" name="city" value="{{ !empty($address->city) ? $address->city : '' }}" class="form-control" placeholder="Enter City">
                            </div>    
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>Zip </label>
                                <input type="text" name="zip" value="{{ !empty($address->zip) ? $address->zip : '' }}" class="form-control" placeholder="Enter Zip">
                            </div>    
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                                <label>State </label>
                                <input type="text" name="state" value="{{ !empty($address->state) ? $address->state : '' }}" class="form-control" placeholder="Enter State">
                            </div>    
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Mobile No </label>
                             <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ !empty($address->mobile) ? $address->mobile : '' }}" placeholder="Enter Mobile No.">
                              @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>    
                          </div> 
                        </div>
                    <input type="hidden" name="addressId" value="{{ !empty($address->id) ? $address->id : '' }}">                        
                      <input type="submit" name="submit" value="Update" class="btn btn-md customBtn">  
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
  document.getElementById('brand_image').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>
@endsection           