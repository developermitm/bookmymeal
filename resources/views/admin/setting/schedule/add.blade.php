@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Order Schedule</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Order Schedule</li>
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
                    <a href="{{url('order-schedule-list')}}" class="btn bnt-sm customBtn"> <i class="fa fa-list"></i> Order Schedule List</a>
                  </div>
                  <br>
                </div>
                   <div class="col-lg-12">
                      <form method="POST" name="banner-form" id="banner-form" action="{{route('order-schedule.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-sm-4"> 
                            <div class="form-group">
                                <label> Order From Time  </label>
                                <select name="order_from_time" class="form-control" required>
                                <?php 
                                    for($hours=0; $hours<12; $hours++){
                                      for($mins=0; $mins<60; $mins+=5) { 
                                          $time = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                          echo '<option value= "'.$time.'">'.$time.'</option>';
                                      } 
                                    }  
                                ?>
                                </select>
                            </div>    
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Order To Time </label>
                              <select name="order_to_time" class="form-control" required>
                                <?php 
                                    for($hours=0; $hours<12; $hours++){
                                      for($mins=0; $mins<60; $mins+=5) { 
                                          $time = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                                          echo '<option value= "'.$time.'">'.$time.'</option>';
                                      } 
                                    }  
                                ?>
                              </select>
                            </div>    
                          </div> 

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label> Status </label> <br>
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

</script>

@endsection           