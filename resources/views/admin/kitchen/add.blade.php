@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Kitchen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Kitchen</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<style>
  .error{
    color:red;
  }
</style>
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
                    <a href="{{url('kitchen-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Kitchen List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="banner-form" id="banner-form" action="{{route('kitchens.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label> Owner Name  </label>
                                <input type="text" name="owner_name" class="form-control" placeholder="Enter Owner Name" required>
                            </div>    
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Kitchen Name </label>
                              <input type="text" class="form-control @error('kitchen_name') is-invalid @enderror" name="kitchen_name" placeholder="Enter Kitchen Name" required>
                              @error('kitchen_name')
                                  <p class="error">{{ $message }}</p>
                              @enderror
                            </div>    
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Mobile Number </label>
                              <input type="text"  name="mobile_num" class="form-control @error('mobile_num') is-invalid @enderror"  placeholder="Mobile Number" required>
                              @error('mobile_num')
                                  <p class="error">{{ $message }}</p>
                              @enderror
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Address </label>
                              <input type="text" name="address" id="address" autocomplete="on" class="form-control" placeholder="Enter Address" required>
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                               <label>Kitchen Image </label>
                              <input type="file" class="form-control" name="kitchen_image" id="kitchen_image" accept="image/*" required> 
                            </div>    
                            <img id="image" width="100px">
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
  document.getElementById('bannerImage').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>

@endsection           