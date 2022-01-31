@extends('layouts.layouts')

@section('content')
<!--end::Top-->
<!--begin::Bottom-->

</div>
<style type="text/css">
    .error{color: red;}
    .add_company_div{
        background-color: #fff;
        min-height: 400px;
    }
    #companyForm{
            margin-left: 6%;
    }
    #kt_content{
        background-color: #fff;
    }
</style>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <h4>Create company account</h4>
                @if(session()->has('message.level'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>Company Created successfully !</strong>
                    </div>
                 @endif
                <div class="text-right">
                    <a href="{{'company-account-list'}}"> <span class="menu-text"><i class="icon-md fas fa-list"></i>&nbsp;&nbsp;&nbsp;Listing</span> </a>
                </div>
                
                <div class="row mt-0 mt-lg-3 add_company_div">
                 <form method="post" name="companyForm" class="form-horizontal" action="{{url('super-admin/add-company-account')}}" id="companyForm" autocomplete="off" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                           <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Username :</label>
                                    <input type="text" name="username" value="{{ old('username') }}" class="form-control form-control-solid" placeholder="Enter username" required="" autocomplete="off">
                                    @error('username')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email address:</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-solid" placeholder="Enter email" required="">
                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="password" class="form-control form-control-solid" placeholder="Enter password" required="">
                            @error('password')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                            </div>
                       
                        

                        
                    </div>
                    <div class="row">
                            <div class="col-md-4">
                        <div class="form-group">
                            <label>Company name:</label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control form-control-solid" placeholder="Enter company name" required="">
                            @error('company_name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                                                <div class="col-md-4">
                        <div class="form-group">
                            <label>Location:</label>
                            <input type="text" name="location" class="form-control form-control-solid" placeholder="Enter location" value="{{ old('location') }}" required="">
                            @error('location')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div> 
                    </div>
                                                <div class="col-md-4">
                        <div class="form-group">
                            <label>Company logo:</label>
                            <input type="file" class="form-control form-control-solid" 
                            name="company_logo" id="company_logo" accept="image/*">
                            @error('company_logo')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    </div>
                        <button type="submit" class="btn btn-primary mr-2">Add Details</button>
                    </div>
                   </form>
              </div>
            </div>
           
        </div>
        
    </div>
    

@endsection           