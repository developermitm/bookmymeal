@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Activity Log</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activity</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php 
    $usersArr = [];
    $mobileArr = [];
    if(isset($users) && !empty($users)){
      foreach ($users as $user) {
        $usersArr[$user->id] = ucfirst($user->name);
      }
    } 

    if(isset($mobileuser) && !empty($mobileuser)){
      foreach ($mobileuser as $row) {
        $mobileArr[$row->id] = ucfirst($row->username);
      }
    }
    
    ?>
    
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="row">
                  <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                     <thead>
                       <tr>
                         <th>Log Name</th>
                         <th>Description</th>
                         <th>UserBy</th>
                         <th>New properties</th>
                         <th>Old properties</th>
                       </tr>
                     </thead>

                     <tbody>
                      @foreach($activityLog as $row)
                      <?php 
                        $jsonData = json_decode($row->properties);
                        $jsonDecodeData = $jsonData->attributes;
                        $josnOldData = !empty($jsonData->old) ? $jsonData->old : array(); 
                      ?>
                       <tr>
                         <td>{{$row->log_name}}</td>
                         <td>{{$row->description}}</td>
                         <td>
                          @if($row->log_name == 'AppUser')
                           {{ !empty($mobileArr[$row->causer_id]) ? $mobileArr[$row->causer_id] : '' }}
                          @else
                          {{ !empty($usersArr[$row->causer_id]) ? $usersArr[$row->causer_id] :'' }}
                          @endif
                        
                        </td>
                       <td>
                              <?php 
                               foreach ($jsonDecodeData as $key => $row2) {
                                  echo $key .' - '. $row2.'</br>';
                                }
                              ?>
                            </td>

                              <td>
                              <?php 
                               foreach ($josnOldData as $key => $row2) {
                                  echo $key .' - '. $row2.'</br>';
                                } 

                              ?>
                                
                              </td>
                       </tr>
                      @endforeach 
                     </tbody>
                   </table> 
                  <div class="d-flex justify-content-center">
                    {!! $activityLog->links() !!}
                  </div>

                  </div>
                </div>
              </div>
             </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

@endsection           