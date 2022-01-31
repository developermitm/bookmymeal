@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Upload csv</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Upload csv</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
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
                   <div class="col-lg-12">
                      <form method="POST" name="products-form" id="products-form" action="{{url('upload-csv')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label> Import csv </label>
                                <input type="file" name="csv_file" class="form-control" required accept=".csv">
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
    $('#subcategory').html('');
    $('#subcategory').append('<option value="">Select Details </option>');

     $.ajax({
      url: '{{url("getsubcategory") }}',
      type: 'POST',
      data: {"_token": "{{ csrf_token() }}", categoryId:categoryId },
      success:function(result){
       var res = JSON.parse(result); 
        $.each(res, function(key, value) { 
            $('#subcategory').append("<option  title='" + value.sub_category_name + "' value='" + value.id + "'>" + value.sub_category_name + "</option>");
                           
        });
      }
   });
  return false;
  }

function addnewHtmlRow(){
  var getHtml = $('.after-add-more').html();  
    $('#newFieldsAddhere').append(getHtml);
}

function addnewHtmlRow1(){
  var getHtml = $('.add-key-value').html();  
    $('#newFieldsHtml').append(getHtml);
}

$('.optionBox').on('click','.remove',function() {
  $(this).parent().parent().remove();
});

</script>
@endsection           
