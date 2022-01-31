@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Delivery Boy Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Delivery Boy Listing</li>
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

                
                  <div class="text-right">
                    <a href="{{route('delivery-boy.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add New Delivery Boy</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>S.No</th>
                                   <th>Name</th>
                                   <th>Mobile No</th>
                                   <th>Address</th>
                                   <th>Photo</th>
                                   <th>Joining Date</th>
                                   <th>Identity Number</th>
                                   <th>Postal Code</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                           <?php $i = count($users); ?>
                            @foreach($users as $row)
                               <tr>
                               <td>{{$i--}}</td>
                                  <td>{{$row->name}}</td>
                                  <td>{{$row->mobile_no}}</td>
                                  <td>{{$row->address}}</td>
                                  <td>
                                    @if($row->image)
                                    <img src="{{asset('public/deliveryBoy/image/'.$row->image)}}" width="100px">
                                    @endif
                                   </td>
                                   <td>{{ date('d-m-Y', strtotime($row->date_of_joining))}}</td>
                                  <td>{{$row->identity_number}}</td>
                                  <td>{{$row->zip_code}}</td>
                                  
                                  <td>
                                    @if($row->status == 1)
                                     <a class="btn-xs btn alert-success">Active</a> 
                                    @else
                                      <a class="btn-xs btn alert-warning">Inactive</a>
                                    @endif
                                  </td>
                                  <td>
                                    <a href="{{route('delivery-boy.edit', $row->id)}}" class="btn editButton btn-xs customBtn"><i class="fa fa-edit"></i></a>
  
                                    <form action="{{ route('delivery-boy.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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
                          {!! $users->links() !!}
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