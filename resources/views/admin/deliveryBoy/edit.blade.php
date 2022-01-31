@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Delivery User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Delivery User</li>
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
                    <a href="{{url('delivery-boy-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Delivery Boy List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="banner-form" id="banner-form" action="{{route('delivery-boy.update', $getDetails->id)}}" enctype="multipart/form-data">
                        @method('PATCH')
                        {{ csrf_field() }}
                        <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label> Name  </label>
                                <input type="text" name="name" class="form-control" value="{{$getDetails->name}}" placeholder="Enter Name" required>
                            </div>    
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Mobile Number </label>
                              <input type="text" class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no" value="{{$getDetails->mobile_no}}" placeholder="Enter Mobile Number" required>
                              @error('mobile_no')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror

                            </div>    
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Address </label>
                              <input type="text" min="1" name="address" id="address" value="{{$getDetails->address}}" autocomplete="on" class="form-control" placeholder="Enter Address" required>
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Postal Code </label>
                              <input type="text" min="1" name="zip_code" class="form-control" value="{{$getDetails->zip_code}}" placeholder="Enter Postal Code" required>
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Joining Date </label>
                              <input type="date" min="1" name="date_of_joining" class="form-control" value="{{$getDetails->date_of_joining}}" placeholder="Enter Joining Date" required>
                            </div>    
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                               <label>Image </label>
                              <input type="file" class="form-control" name="deliveryBoyImage" id="deliveryBoyImage" accept="image/*"> 
                              <input type="hidden" name="hiddenPic" value="{{$getDetails->image}}">
                            </div>    
                            <img id="image" width="100px" src="{{url('deliveryBoy/image/'.$getDetails->image)}}" >
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                               <label>Document <small> (Aadhar Card, Driving Licence) </small> </label>
                              <input type="file" class="form-control" name="documents[]" id="documents" accept="image/*" multiple> 
                            </div>    
                            @if($docs)
                            @foreach($docs as $doc)
                            <?php 
                              $file_parts = pathinfo(public_path('deliveryBoy/doc/'.$doc->document)); ?>
                              @if($file_parts['extension'] == 'jpg' || $file_parts['extension'] == 'jpeg' || $file_parts['extension'] == 'jpg')
                                <img id="image" width="50px" height="50px" style="margin:2px !important" src="{{url('deliveryBoy/image/'.$getDetails->image)}}" >
                              @endif
                              <a href="{{url('deliveryBoy/doc/'.$doc->document)}}" download> <i class="fa fa-download" aria-hidden="true"></i> {{$doc->document}}</a>
                              <a class="btn btn-sm btn-danger" onclick="return removeImage({{$doc->id}}, '{{$doc->document}}')"> <i class="fa fa-trash-alt" aria-hidden="true"></i></a> <br>
                              @endforeach
                            @endif
                          </div> 

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label> Status </label> <br>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1"  {{($getDetails->status == 1) ? 'checked' : ''}}>
                                <label for="radioPrimary1">Active
                                </label>
                              </div>  

                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" {{($getDetails->status == 0) ? 'checked' : ''}} >
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

function removeImage(id, doc){
  $.ajax({
      url: '{{url("delete-deliveryBoy-doc") }}',
      type: 'POST',
      data: {"_token": "{{ csrf_token() }}", id : id, doc : doc },
      success:function(result){
        var res = JSON.parse(result);
        toastr.success(res.msg);
        setTimeout(() => {
          window.location.reload();    
        }, 100);
      
      }
   });
  return false;
}

</script>

@endsection           