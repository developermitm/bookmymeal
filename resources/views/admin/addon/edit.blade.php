@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Addon</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Addon</li>
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
                    <a href="{{url('admin/addon')}}" class="btn bnt-sm btn-success"> <i class="fa fa-list"></i> Addon List</a>
                  </div>
                  <br>
                </div>
                    <form method="post" name="category-form" id="category-form" action="{{route('addon.update',$getDetails->id)}}" enctype="multipart/form-data">
                      @method('PATCH')   
                     {{ csrf_field() }}
                     <div class="row">
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Category </label>
                              <select class="form-control" name="category" required>
                                    <option value="">Please Select</option>
                                    @foreach($categories as $row)
                                       <option value="{{$row->id }}" {{($getDetails->category_id == $row->id) ? "selected" : ''}} >{{$row->category_name}}</option>
                                    @endforeach
                              </select>      
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Addon Name </label>
                              <input type="text" id="addon_name" required name="addon_name" class="form-control" value="{{ !empty($getDetails->name) ? $getDetails->name : ''}}" placeholder="Enter Addon Name">
                              @error('addon_name')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                        </div>

                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Price </label>
                              <input type="number" min="1" id="price" required name="price" value="{{ !empty($getDetails->price) ? $getDetails->price : ''}}" class="form-control" placeholder="Enter Price">
                              @error('price')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                        </div>

                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Quantity </label>
                              <input type="number" id="quantity" min="1" required name="quantity" value="{{ !empty($getDetails->qty) ? $getDetails->qty : ''}}" class="form-control" placeholder="Enter Quantity">
                              @error('quantity')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                        </div>

                        

                        <div class="col-sm-4">
                            <div class="form-group">
                              <label> Status </label> <br>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" {{($getDetails->status == 1) ? 'checked' : ''}} >
                                <label for="radioPrimary1">Active
                                </label>
                              </div>  

                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" {{($getDetails->status == 0) ? 'checked' : ''}}>
                                <label for="radioPrimary2">InActive
                                </label>
                              </div>
                            </div>    
                          </div>

                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Image </label>
                              <input type="file" class="form-control"  id="addon_image" name="addon_image"  accept="image/*">
                              @error('addon_image')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                           @error('addon_image')
                           <div class="alert alert-danger" role="alert">
                              {{$message}}    
                           </div>
                           @enderror 
                          @if(!empty($getDetails->addon_image))
                            <img src="{{asset('addon/'.$getDetails->addon_image)}}" id="image" width="100px">
                          @endif 
                          <input type="hidden" name="hiddenAddonImage" value="{{$getDetails->addon_image}}">
                          <img id="image" / width="100px">
                        </div>

                        
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label>Description  </label>                           
                              <textarea class="form-control rounded-0" id="description" name="description" value="" rows="3"> {{$getDetails->addon_desc}}</textarea>
                              @error('description')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror  
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                        </div>
                        <div class="col-sm-4 ">
                           <div class="form-group ">
                              <input type="submit" name="submit"   value="submit" class="btn customBtn btn-block "> 
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <!-- /.card -->
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<script type="text/javascript">
  document.getElementById('addon_image').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>

@endsection           