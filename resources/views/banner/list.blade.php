@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Banner Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Banner Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-warning card-outline ">
              <div class="card-body">
                <div class="col-lg-12">

                    @if(session()->has('message'))
                        @if($message = Session::get('message'))
                            <div class="alert alert-success"> {{ $message }} </div>
                        @endif
                    @endif

                   @if(session()->has('message.level'))
                        @if ($message = Session::get('message.content'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                  @endif


                  <div class="text-right">
                    <a href="{{route('banner.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add New Banner</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Page</th>
                                   <th>Place</th>
                                   <th>Order No</th>
                                   <th>Product Name </th>
                                   <th>From Time</th>
                                   <th>Image</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($banners as $row)
                               <tr>
                                  <td>{{$row->id}}</td>
                                  <td>{{$row->page}}</td>
                                  <td>{{$row->place}}</td>
                                  <td>{{$row->num}}</td>
                                  <td>{{ !empty($row->product_id) ?  $row->getProduct->title : '' }}</td>
                                  <td>{{ !empty($row->from_time) ? date('d-m-Y', $row->from_time) : '' }}</td>
                                  <td>
                                    @if($row->image_ext)
                                    <img src="{{url('/banner/'.$row->image_ext)}}" width="100px">
                                    @endif
                                   </td>
                                  <td>
                                    @if($row->status == 1)
                                     <a class="btn-xs btn alert-success">Active</a> 
                                    @else
                                      <a class="btn-xs btn alert-warning">Inactive</a>
                                    @endif
                                  </td>
                                  <td>
                                    <a href="{{route('banner.edit', $row->id)}}" class="btn editButton btn-xs customBtn"><i class="fa fa-edit"></i></a>
  
                                    <form action="{{ route('banner.destroy', $row->id) }}" method="POST" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn btn-xs btn-danger show_confirm"><i class="fa fa-trash-alt"></i></button>
                                    </form>
                                    
                                  </td>
                                </tr>
                            @endforeach
                           </tbody>
                       </table>
                       <div class="d-flex justify-content-center">
                          {!! $banners->links() !!}
                      </div>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<script type="text/javascript">
    $('.show_confirm').click(function(e) {
        if(!confirm('Are you sure you want to delete this?')) {
            e.preventDefault();
        }
    });    

    $('.editButton').click(function(e) {
        if(!confirm('Are you sure you want to edit this?')) {
            e.preventDefault();
        }
    });
</script>

@endsection           