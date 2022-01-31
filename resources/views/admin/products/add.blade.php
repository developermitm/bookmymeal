@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add New Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Product</li>
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


                  <div class="text-right">
                    <a href="{{url('products-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Product Listing</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="products-form" id="products-form" action="{{url('products/store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label> Title </label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter Product Title" required>
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
                              <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="summernote" placeholder="Enter Description" required></textarea>

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
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
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
                              <input type="number" min="1" placeholder="Sale Price" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}" required>
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
                              <input type="number" min="1" placeholder="Purchase Price" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" required>
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
                              <input type="text" placeholder="Shipping Cost" name="shipping_cost" class="form-control @error('shipping_cost') is-invalid @enderror" value="{{ old('shipping_cost') }}" required>

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
                              <input type="text" class="tags form-control @error('tags') is-invalid @enderror" value="" id="tags" name="tags[]" data-role="tagsinput" >

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
                              <input type="number" placeholder="Current Stock" min="1" value="{{ old('current_stock') }}" name="current_stock" class="form-control @error('current_stock') is-invalid @enderror">
                              
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
                                <option value="flat">Flat</option>
                                <option value="percentage">Percentage</option>
                              </select>
                              
                              @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div> -->

                          <!-- <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-lable">Discount</label>
                              <input type="text" placeholder="Discount" name="discount" value="{{ old('discount') }}" min="1" class="form-control @error('discount') is-invalid @enderror">
                              
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
                              <input type="text" class="tags form-control @error('tags') is-invalid @enderror" value="Special" id="tags" name="producttags[]" data-role="tagsinput" >
                              @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>

                        </div>
                    <div class="col-lg-12" style="margin: 0px;">
                    <div id="newFieldsAddhere" class="optionBox"></div>
                    </div>
                    <h5>Product Addon</h5>  
                    <div class="col-lg-12" style="margin: 0px;">
                      <div class="add-key-value">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="form-group">
                              <select class="form-control select2"  name="product_addon[]" id="product_addon" multiple>
                                <option value="">Please select</option>
                                <!-- @foreach($addonListing as $row)
                                  <option value="{{$row->id}}"> {{$row->name.' -(qty) '.$row->qty.'- (price ) '.$row->price}} </option>
                                @endforeach   -->
                              </select>
                            </div>
                          </div>

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Status </label>
                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="status" value="1" checked="checked">
                                <label for="radioPrimary1">Active
                                </label>
                              </div>  

                              <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="status" value="0" >
                                <label for="radioPrimary2">InActive
                                </label>
                              </div>
                            </div>    
                          </div>

                        </div>
                      </div>
                        <div id="newFieldsHtml" class="optionBox"></div>
                    </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                              <label> Specification </label>
                              <textarea class="form-control summernote @error('specification') is-invalid @enderror" name="specification" placeholder="Enter Specification"></textarea>

                              @error('specification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                            </div>    
                          </div>  
                        <div class="row">
                          <div class="col-lg-12">
                            <div id="preview"></div>
                            <div class="form-group">
                              <label>Upload Image</label>
                              <br>
                            <input type="file" class="@error('image') is-invalid @enderror" name="image[]" id="productImage" accept="image/*" multiple required>

                              @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                          </div>
                        </div>
                        </div>    
                      <div class="clearfix"></div>
                        <input type="submit" name="submit" value="submit" class="btn btn-md customBtn">  
                      </form>
                   </div>
              </div>
            </div><!-- /.card -->
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
