@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Products Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products Listing</li>
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
                    <a href="{{route('products.create')}}" class="btn bnt-sm customBtn"> <i class="fa fa-plus"></i> Add New Product</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>S.NO</th>
                                   <th>Product Name</th>
                                   <th>Category</th>
                                   <th>Stock</th>
                                   <th>Sell Price</th>
                                   <th>Purchase</th>
                                   <th>Image</th>
                                   <th>Status</th>
                                   <th>Addon</th>
                                   <th>Action</th>
                                  
                               </tr>
                           </thead>
                           <tbody>
                           <?php $i = count($products); ?> 
                            @foreach($products as $row)

                            <tr>
                                  <td>{{$i--}}</td>
                                  <td>{{$row->title}} - {{$row->id}}</td>
                                  <td>{{ !empty($row->hasCategory->category_name) ? $row->hasCategory->category_name : '' }}</td>
                                  <td>{{$row->current_stock}}</td>
                                  <td>&#8377; {{$row->sale_price}}</td>
                                  <td>&#8377; {{$row->purchase_price}}</td>
                                  <td>
                                  <a href="{{asset('products/thumbnail/'.$row->main_image)}}" data-toggle="lightbox" data-title="{{$row->title}}" data-gallery="gallery">
                                    <img width="100px" src="{{asset('products/thumbnail/'.$row->main_image)}}" class="img-fluid mb-2" alt="{{$row->title}}"/>
                                  </a>

                                    <!-- <img src="{{asset('products/thumbnail/'.$row->main_image)}}" width="100px"> -->
                                  </td>
                                  <td>
                                    @if($row->status == 1)
                                      <a class="badge badge-success">Active</a>
                                    @else
                                    <a class="badge badge-warning">InActive</a>
                                    @endif  
                                  </td>
                                  <td>
                                    <?php 
                                      $sql = "SELECT GROUP_CONCAT(addon_product.name) as addon 
                                      FROM addon_product 
                                      left join product_feature on addon_product.id = product_feature.addon_id  
                                      where product_feature.product_id = $row->id";
                                      $result = DB::select($sql);
                                      echo !empty($result) ? $result[0]->addon : '';
                                    ?>                                    
                                  </td>
                                  <td>
                                    <a href="{{route('products.edit', $row->id)}}" class="btn btn-xs editButton btn-info"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('products.show', $row->id)}}" class="btn btn-xs customBtn"><i class="fa fa-eye"></i></a>
                                    <form action="{{ route('products.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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
                          {!! $products->links() !!}
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