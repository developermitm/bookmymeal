@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Order Placed Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Orders Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<?php 
  $customerArr = [];
  foreach ($customer as $row) {
    $customerArr[$row->id]  = ucfirst($row->username);
  }

?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-warning card-outline">
              <div class="card-body">
             
               <div class="col-lg-12">
                      <table id="example" class="table table-bordered table-striped" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>Order Id</th>
                                   <th>Buyer</th>
                                   <th>Product details</th>
                                   <th>VAT</th>
                                   <th>Shipping </th>
                                   <th>Payment Type </th>
                                   <th>Payment Status </th>
                                   <th>Grand Total </th>
                                   <th>Sale Datetime</th>
                                   <th>Action</th>
                                   <th>Shipping Address</th>
                               </tr>
                           </thead>
                           <tbody>

                            @foreach($orders as $row)
                               <tr>
                                   <td>{{$row->id }}</td>
                                   <td>{{ ($row->buyer == 'guest') ? 'guest' : (!empty($customerArr[$row->buyer]) ? $customerArr[$row->buyer] : '')  }}</td>
                                   <td> 
                                    <?php 
                                        $data = json_decode($row->product_details) ; 
                                        foreach ($data as $key => $value) {
                                          echo($value->name) ; } ?>
                                    </td>
                                   <td>{{$row->vat}}</td>
                                   <td>{{$row->shipping}}</td>
                                   <td>{{$row->payment_type}}</td>
                                   <td>
                                    <?php

                                     $status =  json_decode($row->payment_status); 
                                      $status =  !empty($status[0]->status) ? ($status[0]->status) : '' ;
                                      echo '<a class="btn btn-sm btn-success">'.ucfirst($status).'</a>'
                                    ?>
                                     
                                   </td>
                                   <td>{{$row->grand_total}}</td>
                                   <td>{{date('d-m-Y H:i', $row->sale_datetime)}}</td>
                                   <td> 
                                    <a class="btn btn-xs customBtn" onclick="editOrderDetails('{{$row->id}}')"> <i class="fa fa-edit"></i> </a>   
                                    <a class="btn btn-xs btn-success" href="{{url('admin/invoice/'.$row->orderId)}}"> <i class="fas fa-file-invoice"></i> </a> 
                                  </td>
                                   <td> <?php 
                                    $address = !empty($row->shipping_address) ? json_decode($row->shipping_address) : '';
                                    $firstname = (!empty($address) && isset($address->firstname)) ? $address->firstname : '';
                                    $lastname = (!empty($address) && isset($address->lastname)) ? $address->lastname : '';
                                    echo '<strong>Name :</strong> '.$firstname .' '. $lastname.'<br>';
                                    echo '<strong>Address :</strong> '.$address->address1 .' '. $address->address2.' '.$address->zip.'<br>';
                                    echo '<strong>Email :</strong> '.$address->email.'<br>';
                                    echo '<strong>Phone :</strong> '.$address->phone;
                                   ?>
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
  function editOrderDetails(id) {
     $.ajax({
      url: '{{url("admin/edit-order-details")}}',
      type:'post',
      data: {"_token": "{{ csrf_token() }}", id : id},
      success: function(data){
        $('#modal-default .modal-content').html(data);
        $('#modal-default').modal('show');
      }
   });
    return false; 
  }
</script>

@endsection           