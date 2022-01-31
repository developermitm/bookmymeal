@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline ">
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
                    <a href="{{url('products-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Product Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                          
                           <tbody>
                               <tr>
                                  <th>Id</th>
                                  <td>{{$getDetails->id}}</td>
                                </tr>
                                  <tr>
                                    <th> Title</th>
                                  <td>{{$getDetails->title}}</td>
                                  </tr>
                                </tr>
                                  <tr>
                                    <th>Description </th>
                                    <td>{!! $getDetails->description !!}</td>
                                  </tr>
                                  <tr>
                                    <th>Category </th>
                                    <td>{{ !empty($getDetails->hasCategory->category_name) ?  $getDetails->hasCategory->category_name : '' }}</td>
                                  </tr>
                                  <tr>
                                  
                                   <tr>
                                    <th>Sale Price </th>
                                    <td>{{$getDetails->sale_price}}</td>
                                  </tr>  

                                  <tr>
                                    <th>Purchase Price </th>
                                    <td>{{$getDetails->purchase_price}}</td>
                                  </tr>   

                                  <tr>
                                    <th>Shipping Cost </th>
                                    <td>{{$getDetails->shipping_cost}}</td>
                                  </tr>   
                                  
                                  <tr>
                                    <th>Tags </th>
                                    <td>{{$getDetails->tag}}</td>
                                  </tr>    

                                  <tr>
                                    <th>SEO Title </th>
                                    <td>{{$getDetails->seo_title}}</td>
                                  </tr>     

                                  <tr>
                                    <th>SEO Description </th>
                                    <td>{{$getDetails->seo_description}}</td>
                                  </tr>      

                                  <tr>
                                    <th>Current Stock </th>
                                    <td>{{$getDetails->current_stock}}</td>
                                  </tr>   

                                  <tr>
                                    <th>Discount </th>
                                    <td> {{$getDetails->discount}}</td>
                                  </tr>     

                                  <tr>
                                    <th>Images </th>
                                    <td>  @if(!empty($getDetails->getProductImages))
                                        <div id="preview">
                                      @foreach($getDetails->getProductImages as $image)
                                        <img src="{{asset('products/'.$image->image)}}" width="100px">
                                      @endforeach
                                        </div>
                                      @endif
                        </td>
                                  </tr>  
                             
                           </tbody>
                       </table>
                     
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

        </div>
       
      </div><!-- /.container-fluid -->
    </div>

@endsection           