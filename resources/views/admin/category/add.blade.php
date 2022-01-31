@extends('layouts.admin')
@section('content')
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Add Category</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Home</a></li>
               <li class="breadcrumb-item active">Add Category</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
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
                        <a href="{{url('category-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Category Listing</a>
                     </div>
                     <br>
                  </div>
                  <form method="post" name="category-form" id="category-form" action="{{url('category/store')}}" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <div class="row">
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Category </label>
                              <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name " required>
                              @error('category_name')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label> Order Number </label>
                              <input type="number" id="orderNo" min="1" name="orderNo" class="form-control" placeholder="Category Sorting number eg 1 or 2">
                              @error('orderNo')
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
                       
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label> Image </label>
                              <input type="file" class="form-control"  id="category_image" name="category_image" required accept="image/*">
                              @error('category_image')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror
                           </div>
                           @error('banner')
                           <div class="alert alert-danger" role="alert">
                              {{$message}}    
                           </div>
                           @enderror  
                           <img id="image" / width="100px">
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label>Description  </label>                           
                              <textarea class="form-control rounded-0" id="description" name="description" placeholder="Enter description" rows="3"></textarea>
                              @error('description')
                              <div class="alert alert-danger" role="alert">
                                 {{$message}}    
                              </div>
                              @enderror  
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-4">
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
  document.getElementById('category_image').onchange = function () {
  var src = URL.createObjectURL(this.files[0])
  document.getElementById('image').src = src
}
</script>
@endsection