@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Penalty</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Penalty</li>
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
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  Your submission date is expired you have to pay fine $20
                </div>
                   <div class="col-lg-12">
                      <form method="post" name="penalty-form" id="penalty-form" action="{{url('user/pay-penalty')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label> Pay Penalty </label>
                          <input type="text" name="pay_penalty" class="form-control" placeholder="Enter Amount" required>
                        </div>
                      <input type="hidden" name="orderId" value="{{$id}}">  
                      <input type="hidden" name="bookId" value="{{$getDetails->book_id}}">  
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