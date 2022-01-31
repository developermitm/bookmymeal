@extends('layouts.admin')

@section('content')
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Invoice</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<style type="text/css">
   div#DataTables_Table_0_paginate {
    display: none !important;
}
div#DataTables_Table_0_length {
    display: none;
}

div#DataTables_Table_0_filter {
    display: none;
}
table.tableClass {
    width: 100%;
    /* border: solid; */
}

table.tableClass tr {
    border: solid 1px;
     padding: 4px 10px;
}

table.tableClass td {
    border: solid 1px;
     padding: 4px 10px;
}

table.tableClass th {
    border: solid 1px;
     padding: 4px 10px;
}

</style>
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Orline.
                    <small class="float-right">Date: {{date('d-m-Y')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <?php 
                $address = $productArr[0]['address'] ; ?>
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Orline, Inc.</strong><br>
                    {{!empty($adminAddress->address1) ? $adminAddress->address1 : '' }}<br>
                    {{!empty($adminAddress->address2) ? $adminAddress->address2 : '' }} {{!empty($adminAddress->city) ? $adminAddress->city : '' }} 
                    {{!empty($adminAddress->zip) ? $adminAddress->zip : '' }}<br>
                    Phone: +91 {{!empty($adminAddress->mobile) ? $adminAddress->mobile : '' }}<br>
                    Email: {{Auth()->user()->email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>{{ (!empty($address) && isset($address->firstname)) ? ucfirst($address->firstname) : '' }}</strong><br>
                    {{!empty($address) ? $address->address2 : ''}} {{!empty($address) ? $address->zip : ''}}<br>
                    Phone: {{!empty($address) ? $address->phone : ''}}<br>
                    Email: {{!empty($address) ? $address->email : ''}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #{{$productArr[0]['sale_code']}}</b><br>
                  <br>
                  <b>Order ID:</b> {{$productArr[0]['orderId']}}<br>
                  <b>Payment Due: </b> {{ !empty($productArr[0]['payment_details']->created_at) ? date ('d-m-Y', $productArr[0]['payment_details']->created_at) : '' }}<br>
                  <b>Account:</b> {{ !empty($productArr[0]['product_details']->price) ? $productArr[0]['product_details']->price : '' }}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table  class="tableClass">
                    <thead>
                    <tr>
                      <th>Serial #</th>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($productArr)
                      <?php 
                      $totalAmt = []; 
                      $shippingAmt = []; 
                      $taxAmt = []; 
                      
                      ?>
                      @foreach($productArr as $row)
                      <tr>
                        <td>{{$row['sale_code']}}</td>
                        <td>{{$row['product_details']->name}}</td>
                        <td>{{$row['product_details']->qty}}</td>
                        <td>{{ !empty($row['payment_details']->amount) ? $row['payment_details']->amount : '00'}}</td>
                        <?php 
                        $totalAmt[] =  !empty($row['payment_details']->amount) ? $row['payment_details']->amount : '00'; 
                        $shippingAmt[] = $row['product_details']->shipping; 
                        $taxAmt[] = $row['product_details']->tax; 
                        ?>
                      </tr>
                      @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="{{url('backend/')}}/dist/img/credit/visa.png" alt="Visa">
                  <img src="{{url('backend/')}}/dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="{{url('backend/')}}/dist/img/credit/american-express.png" alt="American Express">
                  <img src="{{url('backend/')}}/dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">

                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <?php $totalArr = array_merge($totalAmt, $taxAmt, $shippingAmt); ?>
                        <td>  &#8377; {{!empty($totalAmt) ? array_sum($totalAmt) : '' }}</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                          <td>  &#8377; {{!empty($taxAmt) ? array_sum($taxAmt) : '' }}</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                          <td>  &#8377; {{!empty($shippingAmt) ? array_sum($shippingAmt) : '' }}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>  &#8377; {{!empty($totalArr) ? array_sum($totalArr) : '' }}</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="javascript:void(0)" onclick="window.print();" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

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