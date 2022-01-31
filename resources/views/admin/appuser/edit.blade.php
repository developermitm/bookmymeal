@extends('layouts.admin')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit User Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit User Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-warning card-outline">
              <div class="card-body">
                  <style>
                      .error{
                          color :red;
                      }
                  </style>
              @if(session()->has('message'))
                    @if($message = Session::get('message'))
                        <div class="alert alert-success"> {{ $message }} </div>
                    @endif
                @endif
                   <div class="col-lg-12">

                 <form method="post" name="companyForm" class="form-horizontal" action="{{route('appuser.update',$result->id)}}" id="companyForm" autocomplete="off" enctype="multipart/form-data">
                 @method('PATCH')   
                     {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="{{ !empty($result->username) ? $result->username : '' }}" class="form-control form-control-solid" placeholder="Enter username">
                            @error('username')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" value="{{ !empty($result->email) ? $result->email : '' }}" class="form-control form-control-solid" placeholder="Enter email" >
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile_no" value="{{ !empty($result->mobile_no) ? $result->mobile_no : '' }}" class="form-control @error('mobile_no') is-invalid @enderror" placeholder="Enter Mobile Number">
                            @error('mobile_no')
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
                                    <input type="radio" id="radioPrimary1" value="1" name="status" {{($result->status == 1) ? 'checked' : ''}}>
                                    <label for="radioPrimary1">Active
                                    </label>
                                  </div>

                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary2" value="0" name="status" {{($result->status == 0) ? 'checked' : ''}}>
                                    <label for="radioPrimary2">InActive
                                    </label>
                                  </div>
                                </div>
                            </div>    
                          </div>

                    </div>
                        <button type="submit" class="btn btn-primary mr-2">Update Details</button>
                    </div>
                   </form>
              </div>
            </div>
            </div>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>
            
       
@endsection           