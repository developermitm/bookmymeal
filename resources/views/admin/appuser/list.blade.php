@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">AppUsers Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-warning card-outline">
              <div class="card-body">
              @if (\Session::has('success'))
                      <div class="alert alert-success"> {!! \Session::get('success') !!} </div>
                    @endif
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>S.No</th>
                                   <th>Name</th>
                                   <th>Email</th>
                                   <th>Mobile Number</th>
                                   <th>Address</th>
                                   <th>City</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                           <?php $i = count($users); ?>
                            @foreach($users as $row)
                               <tr>
                               <td>{{$i--}}</td> 
                                  <td>{{$row->username.' '.$row->surname}}</td>
                                   <td>{{$row->email}}</td>
                                   <td>{{$row->mobile_no}}</td>
                                   <td>{{$row->address1}}</td>
                                   <td>{{$row->city}}</td>
                                   <td>
                                     @if($row->status == 1)
                                      <a class="btn btn-sm btn-success">Active</a>
                                     @else
                                     <a class="btn btn-sm btn-danger">InActive</a>
                                     @endif
                                   </td>
                                   <td>
                                   <a href="{{route('appuser.edit', $row->id)}}" class="btn editButton btn-xs customBtn"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('appuser.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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
    </script>
@endsection           