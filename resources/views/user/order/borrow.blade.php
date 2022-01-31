@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Borrow Book</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Borrow Book</li>
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
                    <a href="{{url('user/order-new-book')}}" class="btn bnt-sm btn-success"> <i class="fa fa-list"></i> Book List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="post" name="category-form" id="category-form" action="{{url('user/order-book')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label> Book Return Date </label>
                          <input type="date" name="return_date" class="form-control" placeholder="Enter Category Name" required>
                        </div>
                      <input type="hidden" name="bookId" value="{{$id}}">  
                      <input type="submit" name="submit" value="submit" class="btn btn-success">  
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