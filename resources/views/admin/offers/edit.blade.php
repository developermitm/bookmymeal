@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit New Offer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Offer</li>
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
                    <a href="{{url('offer-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Offers List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="brand-form" id="brand-form" action="{{route('offer.update', $getDetails->id)}}" enctype="multipart/form-data">
                        @method('PATCH')
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label> Title  </label>
                                <input type="text" name="offer_title" value="{{!empty($getDetails->title) ? $getDetails->title : '' }}" class="form-control" placeholder="Enter Title" required>
                            </div>    
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Description </label>
                              <input type="text" class="form-control" value="{{!empty($getDetails->spec) ? $getDetails->spec : '' }}" name="description" placeholder="Enter Description">
                            </div>    
                          </div> 

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Validity </label>
                              <input type="text" name="validity" value="{{!empty($getDetails->till) ? $getDetails->till : '' }}" class="form-control offerDate" placeholder="Validity" required>
                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label> Offer Id </label> <br>
                               <input type="text" name="offer_code" class="form-control" value="{{!empty($getDetails->code) ? $getDetails->code : '' }}" id="offer_code" required placeholder="Enter offer code">
                            </div>    
                          </div> 

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label> Status </label> <br>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" {{($getDetails->status == 1) ? 'checked' : '' }}>
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

@endsection           