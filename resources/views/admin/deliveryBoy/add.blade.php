@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Delivery User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Delivery User</li>
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
                   @if(session()->has('message.level'))
                        @if ($message = Session::get('message.content'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                  @endif

                  <div class="text-right">
                    <a href="{{url('delivery-boy-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Delivery User List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="banner-form" id="banner-form" action="{{route('delivery-boy.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label> Name  </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter Name" required>
                                @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror

                            </div>    
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Mobile Number </label>
                              <input type="text" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no') }}" name="mobile_no" placeholder="Enter Mobile Number" required>
                              @error('mobile_no')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>    
                          </div>
                          
                          <!-- <div class="col-sm-3">
                            <div class="form-group">
                              <label> Password </label>
                              <input type="text" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="Enter Password" required>
                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>    
                          </div> -->


                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Address </label>
                              <input type="text" name="address" id="address" autocomplete="on" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Enter Address" required>
                              @error('address')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Postal Code </label>
                              <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" value="{{ old('zip_code') }}" placeholder="Enter Postal Code" required>
                              @error('zip_code')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Joining Date </label>
                              <input type="date" name="date_of_joining" class="form-control" placeholder="Enter Joining Date" required>
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                               <label>Image </label>
                              <input type="file" class="form-control" name="deliveryBoyImage" id="deliveryBoyImage" accept="image/*" required> 
                            </div>    
                            <img id="image" width="100px">
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                               <label>Document <small> (Aadhar Card, Driving Licence) </small> </label>
                              <input type="file" class="form-control" name="documents[]" id="documents" accept="image/*" multiple required> 
                            </div>    
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Status </label> <br>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" checked="checked">
                                <label for="radioPrimary1">Active
                                </label>
                              </div>  

                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" >
                                <label for="radioPrimary2">InActive
                                </label>
                              </div>
                            </div>    
                          </div>
                        </div>

                      <input type = "hidden" id ="lat" name="lat" value="">
                      <input type = "hidden" id ="lang" name="lang" value="">
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
  document.getElementById('deliveryBoyImage').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}

</script>

@endsection           