@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit User</li>
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
                    <a href="{{url('admin/user-listing')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> &nbsp;Users List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="brand-form" id="brand-form" action="{{url('admin/edit-user')}}" enctype="multipart/form-data">
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
                                <label>Address </label>
                                <input type="text" name="address" value="{{ $getDetails->address }}" class="form-control" placeholder="Enter Address">
                            </div>    
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Mobile No </label>
                             <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $getDetails->mobile_num }}" placeholder="Enter Mobile No.">
                              @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>    
                          </div> 

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Role </label>
                              <select class="form-control" name="user_role">
                                <option value="">Please select</option>
                                @foreach($roles as $role)
                                  <option value="{{$role->id}}" {{($role->id == $getDetails->user_role) ? 'selected' : ''}} >{{ucfirst($role->name)}}</option>
                                @endforeach
                              </select>

                              @error('user_role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>    
                          </div>


                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Status </label>
                            <div class="form-group clearfix">
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" value="1" name="status" {{($getDetails->status == 1) ? 'checked' : ''}}>
                                    <label for="radioPrimary1">Active
                                    </label>
                                  </div>

                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary2" value="0" name="status" {{($getDetails->status == 0) ? 'checked' : ''}}>
                                    <label for="radioPrimary2">InActive
                                    </label>
                                  </div>
                                </div>
                            </div>    
                          </div>
                        </div>
                    <input type="hidden" name="userId" value="{{$getDetails->id}}">                        
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