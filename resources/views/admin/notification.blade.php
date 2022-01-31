@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Notification</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Notification</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-12">
                @if (session()->has('success'))
               <div class="alert alert-success">
                @if(is_array(session()->get('success')))
                        <ul>
                            @foreach (session()->get('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                        @else
                            {{ session()->get('success') }}
                        @endif
                    </div>
                @endif
                 @if (count($errors) > 0)
                  @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                      {{$errors->first()}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                  @endif
                @endif
                </div> 
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="row">
                    <form class="forms-sample" action="{{route('adminNotificationSend')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                </div>
                <div class="card-body">
                     <div class="row">
                       <div class="col-md-12">
                        <div class="form-group">
                          <label>Title</label>
                          <input type="text" name="notification_title" placeholder="Enter Title" class="form-control">
                        </div>
                      </div>
                       <div class="col-md-12">
                        <div class="form-group">
                          <label>Message</label>
                          <textarea name="notification_text" class="form-control" placeholder="Enter message"></textarea>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>User</label>
                          <select name="users" id="users" class="form-control">
                            <option value="">Please Select</option>
                            @foreach($mobileuser as $row)
                            <option value="{{$row->id}}">{{$row->username.' '.$row->surname}}</option>
                            @endforeach  
                          </select>
                          
                        </div>
                      </div>

                      <div class="col-md-6">
                       <div class="form-group">
                              <label> Send to all </label>
                            <div class="form-group clearfix">
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" value="1" name="status" checked="">
                                    <label for="radioPrimary1">Yes
                                    </label>
                                  </div>

                                  <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary2" value="0" name="status" >
                                    <label for="radioPrimary2">No
                                    </label>
                                  </div>
                                </div>
                            </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-center">Send Notification</button>
                    <div class="clearfix"></div>
                  </form>

                  </div>
                </div>
              </div>
             </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<script type="text/javascript">
  
  $('#users').change(function(){
    var userId = $(this).val();
    if(userId){
      $('#radioPrimary1').attr('disabled', true);
    }else{
      $('#radioPrimary1').attr('disabled', false);
    }
  })

  $('#radioPrimary1').click(function(){
    $('#users').attr('disabled', true);
  })

  $('#radioPrimary2').click(function(){
    $('#users').attr('disabled', false);
  })

</script>
@endsection           