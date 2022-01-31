@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users Listing</h1>
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
               @if(session()->has('message'))
                        @if($message = Session::get('message'))
                            <div class="alert alert-success"> {{ $message }} </div>
                        @endif
                    @endif
                 <div class="text-right">
                    <a href="{{url('admin/add-user')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add New User</a>
                  </div>
                  <br>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Name</th>
                                   <th>Email</th>
                                   <th>Address</th>
                                   <th>Mobile Number</th>
                                   <th>Status</th>
                                   <th>Role</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($users as $row)
                               <tr>
                                  <td>{{$row->name}}</td>
                                  <td>{{$row->email}}</td>
                                  <td>{{$row->address}}</td>
                                  <td>{{$row->mobile_num}}</td>
                                  <td>
                                   @if($row->status == 1)
                                   <a href="javascript:void(0)" class="btn btn-sm btn-success">Active</a>
                                   @else
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning">InActive</a>
                                   @endif
                                   </td>
                                   <td> {{ucfirst($row->roleName->name)}} </td>
                                   <td>
                                    <a href="{{url('admin/edit-user/'.$row->id)}}" class="btn btn-xs show_confirm customBtn"><i class="fa fa-edit"></i></a>
                                                                      
                                 </td>
                               </tr>
                            @endforeach
                           </tbody>
                       </table>
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
            if(!confirm('Are you sure you want to edit this?')) {
                e.preventDefault();
            }
        });    
    </script>
@endsection           