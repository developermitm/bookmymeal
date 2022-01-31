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
     <?php 
      $categoriesArr = [];
      foreach ($categories as $category) {
        $categoriesArr[$category->id] = $category->category_name;
      }
    ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">

                 @if(session()->has('message.level'))
                    @if ($message = Session::get('message.content'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
                  @endif
                  
                    <div class="row">
                     @foreach($books as $book)   
                     <div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                      <img class="card-img-top" src="{{url('bookImage/'.$book->book_image)}}" width="300px" height="200px" alt="Card image cap">
                      <div class="card-body">
                        <h5 class="card-title">{{$book->book_name}}</h5>
                        <p class="card-text">Category : {{ $categoriesArr[$book->categories_id]}} &nbsp;&nbsp;
                        Price : {{$book->book_price}}</p>
                    
                        @if($book->book_status == 1)
                        <a href="{{url('user/borrow-book/'.$book->id)}}" class="btn btn-primary">Borrow</a>
                        @else
                        <a href="#" class="btn btn-danger">Not Available </a>
                        @endif
                      </div>
                    </div>
                </div>
                    @endforeach
                        
                    </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

@endsection           