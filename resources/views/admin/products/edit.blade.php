@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Product Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <style type="text/css">
    .bootstrap-tagsinput{
        width: 100%;
    }
    .label-info{
        background-color: #17a2b8;

    }
    .label {
        display: inline-block;
        padding: .25em .4em;
        font-size: 100%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,
        border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
</style>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="col-lg-12">
                    @if(session()->has('message'))
                        @if($message = Session::get('message'))
                            <div class="alert alert-success"> {{ $message }} </div>
                        @endif
                    @endif

                  <div class="text-right">
                    <a href="{{url('products-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> &nbsp; Product Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="products-form" id="products-form" action="{{route('products.update', $getDetails->id)}}" enctype="multipart/form-data">
                        @method('PATCH') 
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" name="title" value="{{!empty($getDetails->title) ? $getDetails->title : '' }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Product Title" required>
                              @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>    
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label> Description </label>
                              <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="summernote" placeholder="Enter Description" required>{{!empty($getDetails->description) ? $getDetails->description : ''}}</textarea>

                              @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>    
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Category </label> <br>
                              <select class="form-control @error('category') is-invalid @enderror" name="category" id="category" onchange="getSusbcategory(this)" required>
                                <option value="">Please select</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{($category->id == $getDetails->category) ? 'selected' : ''}} >{{$category->category_name}}</option>
                                @endforeach
                              </select> 
                              @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>    
                          </div>
                         
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Sale Price</label>
                              <input type="number" min="1" value="{{!empty($getDetails->sale_price) ? $getDetails->sale_price : '' }}" placeholder="Sale Price" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" required>
                              @error('sale_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Purchase Price</label>
                              <input type="number" min="1" value="{{!empty($getDetails->purchase_price) ? $getDetails->purchase_price : '' }}" placeholder="Purchase Price" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" required>
                              @error('purchase_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>

                          <!-- <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Shipping Cost</label>
                              <input type="text" value="{{!empty($getDetails->shipping_cost) ? $getDetails->shipping_cost : '' }}" placeholder="Shipping Cost" name="shipping_cost" class="form-control @error('shipping_cost') is-invalid @enderror" required>

                              @error('shipping_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div> -->
                       
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Tags </label>
                              <input type="text" class="form-control @error('tags') is-invalid @enderror" value="{{!empty($getDetails->tag) ? $getDetails->tag : '' }}" id="tags" name="tags[]" data-role="tagsinput">

                              @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>
                          
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Current Stock</label>
                              <input type="number" value="{{!empty($getDetails->current_stock) ? $getDetails->current_stock : '' }}" placeholder="Current Stock" min="1" name="current_stock" class="form-control @error('current_stock') is-invalid @enderror" required>
                              
                              @error('current_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div>

                          <!-- <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Discount Type</label>
                              <select class="form-control" name="discount_type" id="discount_type">
                                <option>Please Select</option>
                                <option value="flat" {{($getDetails->discount_type == 'flat') ? "selected" : ''}} >Flat</option>
                                <option value="percentage" {{($getDetails->discount_type == 'percentage') ? "selected" : ''}}>Percentage</option>
                              </select>
                              
                              @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Discount</label>
                              <input type="number" value="{{!empty($getDetails->discount) ? $getDetails->discount : '' }}" placeholder="Discount" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                              
                              @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>
                          </div> -->

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Product Tag</label>
                              <input type="text" class="tags form-control @error('tags') is-invalid @enderror" value="{{!empty($getDetails->featured) ? $getDetails->featured : '' }}" id="tags" name="producttags[]" data-role="tagsinput" >
                              @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>

                  <h5>Product Addon</h5>  
                    <div class="col-lg-12" style="margin: 0px;">
                      <div class="add-key-value">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="form-group">
                              <select class="form-control select2" name="product_addon[]" id="product_addon" multiple>
                                <option value="">Please select</option>
                                @foreach($addonListing as $row)
                                  <option value="{{$row->id}}" {{(in_array($row->id, $addonsArr)) ? "selected" : '' }} > {{$row->name.' -(qty) '.$row->qty.'- (price ) '.$row->price}} </option>
                                @endforeach  
                              </select>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Status </label>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" {{($getDetails->status == 1) ? "checked" : '' }}>
                                <label for="radioPrimary1">Active
                                </label>
                              </div>  

                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" {{($getDetails->status == 0) ? "checked" : '' }} >
                                <label for="radioPrimary2">InActive
                                </label>
                              </div>
                            </div>    
                          </div>

                        </div>
                      </div>
                       
                    </div>
                   
                        <div class="col-sm-12">
                            <div class="form-group">
                              <label> Specification </label>
                              <textarea class="form-control summernote @error('specification') is-invalid @enderror" name="specification" placeholder="Enter Specification">{{$getDetails->additional_fields}} </textarea>
                            </div>    
                          </div>  
                          </div>  
                        <div class="row">
                          <div class="col-lg-12">
                          @if(!empty($getDetails->getProductImages))
                            <div id="preview">
                          @foreach($getDetails->getProductImages as $key => $image)
                            <img src="{{url('products/'.$image->image)}}" width="100px">
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary{{$key}}" title="Click to set default thumbnail" name="setMainImage" onclick="setthumbnailImage('{{$getDetails->id}}', '{{$image->image}}', '{{$getDetails->main_image}}')" {{($getDetails->main_image == $image->image) ? 'checked' : '' }} >
                                <label title="Click to set default thumbnail" for="radioPrimary{{$key}}"> </label>
                              </div>
                           
                          @endforeach
                            </div>
                          @endif
                       
                            <div id="preview"></div>
                            <div class="form-group">
                              <label>Upload Image </label>
                              <br>
                            <input type="file" class="@error('image') is-invalid @enderror" name="image[]" id="productImage" accept="image/*" multiple>

                              @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                          </div>
                        </div>
                        </div>
                        <input type="hidden" name="totalImage" value="{{ !empty($getDetails->getProductImages) ? count($getDetails->getProductImages) : '' }}">
                        <input type="submit" name="submit" value="submit" class="btn btn-md customBtn">  
                      </form>
                   </div>
              </div>
            </div><!-- /.card -->
          </div>

                    <div id="cloneHtmlContainer" class="col-lg-12" style="margin: 0px; display: none;">
                      <div class="after-add-more">
                        <input type="hidden" name="id[]" value="">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Size </label>
                              <input type="text" class="form-control @error('size') is-invalid @enderror" value="" name="size[]" placeholder="Size">
                            </div>
                          </div>
                          
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Color</label>
                              <input type="text" placeholder="Color" name="color[]" class="form-control @error('color') is-invalid @enderror" value="">
                            </div>
                          </div>

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-lable">Quantity</label>
                              <input type="number" value="" placeholder="Quantity" name="quantity[]" min="1" class="form-control @error('quantity') is-invalid @enderror">
                            </div>
                          </div>
                          
                          <div class="col-md-1"><br>
                            <button type="button" class="btn btn-sm btn-danger remove">  <i class="fa fa-times"></i></button>
                          </div>

                        </div>
                      </div>
                        <div id="newFieldsAddhere" class="optionBox"></div>
                    </div>

                    <div id="cloneHtmlContainer1" class="col-lg-12" style="margin: 0px; display: none;">
                      <div class="after-add-more">
                        <input type="hidden" name="extraId[]" value="">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Label </label>
                              <input type="text" class="form-control @error('label') is-invalid @enderror" value="" name="label[]" placeholder="Size">
                            </div>
                          </div>
                          
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Value</label>
                              <input type="text" placeholder="Color" name="value[]" class="form-control @error('value') is-invalid @enderror" value="">
                            </div>
                          </div>
 
                          <div class="col-md-1"><br>
                            <button type="button" class="btn btn-sm btn-danger remove">  <i class="fa fa-times"></i></button>
                          </div>

                        </div>
                      </div>
                        <div id="newFieldsHtml" class="optionBox"></div>
                    </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<script type="text/javascript">
  
  function previewImages() {

  var preview = document.querySelector('#preview');
  
  if (this.files) {
    [].forEach.call(this.files, readAndPreview);
  }

  function readAndPreview(file) {

    // Make sure `file.name` matches our extensions criteria
    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
      return alert(file.name + " is not an image");
    } // else...
    
    var reader = new FileReader();
    
    reader.addEventListener("load", function() {
      var image = new Image();
      image.height = 100;
      image.width = 100;
      image.title  = file.name;
      image.src    = this.result;
      preview.appendChild(image);
    });
    
    reader.readAsDataURL(file);
    
  }

}

document.querySelector('#productImage').addEventListener("change", previewImages);

  function setthumbnailImage(productId, productImage, dest) {
    $.ajax({
      url: '{{url("set-main-image") }}',
      type: 'POST',
      data: {"_token": "{{ csrf_token() }}", productId : productId, productImage : productImage, dest : dest },
      success:function(result){
        var res = JSON.parse(result);
        toastr.success(res.msg);
      }
   });
  return false;
  }
  
  function getSusbcategory(element) {
    var categoryId = $(element).val();
    $('#product_addon').html('');
    $('#product_addon').append('<option value="">Select Details </option>');

     $.ajax({
      url: '{{url("category-addon") }}',
      type: 'POST',
      data: {"_token": "{{ csrf_token() }}", categoryId:categoryId },
      success:function(result){
        $.each(result, function(key, value) { 
            $('#product_addon').append("<option  title='" + value.name + "' value='" + value.id + "'>" + value.name +' (qty) : '+value.qty+' , (Price) ' +value.price+"</option>");
                           
        });
      }
   });
  return false;
  }

</script>
@endsection           