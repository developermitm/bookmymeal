@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Banner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Banner</li>
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
                    <a href="{{url('banner-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Banner List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="banner-form" id="banner-form" action="{{url('banner/store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                                <label> Page  </label>
                                <input type="text" name="page" class="form-control" placeholder="Enter Page eg. Home" required>
                            </div>    
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Place </label>
                              <input type="text" class="form-control" name="place" placeholder="eg . after_slider" required>
                            </div>    
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Order Number </label>
                              <input type="number" min="1" name="order_num" class="form-control" placeholder="Order Number" required>
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


                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Product </label> <br>
                              <select class="form-control" name="product" required style="width: 100%;">
                                <option value="">Please select</option>
                                @foreach($products as $row)
                                <option value="{{$row->id}}">{{$row->title}}</option>
                                @endforeach                                
                              </select> 
                            </div>    
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>From time </label> <br>
                              <input type="text" class="form-control offerDate" name="fromTime" required>
                            </div>    
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                               <label>Image </label>
                              <input type="file" class="form-control" name="bannerImage" id="bannerImage" accept="image/*" required> 
                            </div>    
                            <img id="image" width="100px">
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

<script type="text/javascript">
  document.getElementById('bannerImage').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>

@endsection           