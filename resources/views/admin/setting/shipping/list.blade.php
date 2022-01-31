@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Shipping Cost Setting</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shipping Cost Setting</li>
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
                    <a href="{{route('shipping.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add Shipping Cost</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>S.No</th>
                                   <th>Min Amount</th>
                                   <th>Shipping Cost</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                           <?php $i = count($shippings); ?>
                            @foreach($shippings as $row)
                               <tr>
                               <td>{{$i--}}</td>
                                  <td>{{$row->min_amount}}</td>
                                  <td>{{$row->shipping_cost}}</td>
                                  <td>
                                    @if($row->status == 1)
                                     <a class="btn-xs btn alert-success">Active</a> 
                                    @else
                                      <a class="btn-xs btn alert-warning">Inactive</a>
                                    @endif
                                  </td>
                                  <td>
                                    <a href="{{route('shipping.edit', $row->id)}}" class="btn editButton btn-xs customBtn"><i class="fa fa-edit"></i></a>
  
                                    <form action="{{ route('shipping.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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
                          {!! $shippings->links() !!}
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