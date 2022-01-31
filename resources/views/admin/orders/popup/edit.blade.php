<div class="modal-content">
 
   <div class="modal-header btn btn-success">
                <h4 class="modal-title" id="vcenter">Update Order Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
    <div class="modal-body">
        <div id="successMsg"></div>
         <form  id="orderStausUpdate" class="form-horizontal" method="post" onsubmit="return updateOrderDetails()" autocomplete="off">
            {{ csrf_field() }} 
            <?php 
            $address = !empty($getDetails->shipping_address) ? json_decode($getDetails->shipping_address) : '' ;
            $details = json_decode($getDetails->product_details); 
            $status = json_decode($getDetails->payment_status); ?>

            @foreach($details as $row)
            <div class="form-group col-md-12 mycompany">
                <label for="recipient-name" class="control-label">Product Name</label>
                <input type="text" value="{{$row->name}}" class="form-control" readonly>
            </div>
            <div class="row">
            <div class="form-group col-md-4 mycompany">
                <label for="recipient-name" class="control-label">Qty</label>
                <input type="text" value="{{$row->qty}}" class="form-control" readonly>
            </div>

            <div class="form-group col-md-4 mycompany">
                <label for="recipient-name" class="control-label">price</label>
                <input type="text" value="{{$row->price}}" class="form-control" readonly>
            </div>

            <div class="form-group col-md-4 mycompany">
                <label for="recipient-name" class="control-label">tax</label>
                <input type="text" value="{{$row->tax}}" class="form-control" readonly>
            </div>
        </div>
            <div class="form-group mycompany">
                <input type="hidden" value="{{$getDetails->id}}" class="form-control" name="orderId">
            </div>
            <?php 

            ?>
            @endforeach
            
          <div class="form-group">
            <label>Order Status </label>
         
                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary1" value="placed" name="status" {{($status[0]->status == 'placed') ? 'checked' : '' }} >
                    <label for="radioPrimary1">Placed &nbsp;
                    </label>
                  </div>

                  <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" value="delivered" name="status" {{($status[0]->status == 'delivered') ? 'checked' : '' }} >
                    <label for="radioPrimary2">Delivered &nbsp;
                    </label>
                  </div>

                  <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary3" value="cancelled" name="status" {{($status[0]->status == 'cancelled') ? 'checked' : '' }} >
                    <label for="radioPrimary3">Cancel
                    </label>
                  </div>
                </div>
            </div>
                <label>Change Shipping Address</label>

            <div class="row">
                <div class="col-md-6">
                    <label>First Name</label>
                    <input type="text" name="firstName" value="{{!empty($address->firstname) ? $address->firstname : '' }}" class="form-control">
                </div>
                 <div class="col-md-6">
                    <label>Last Name </label>
                    <input type="text" name="lastName" value="{{!empty($address->lastname) ? $address->lastname : '' }}" class="form-control">
                </div>
                
                <div class="col-md-6">
                    <label>Address 1</label>
                    <input type="text" name="address1" value="{{!empty($address->address1) ? $address->address1 : '' }}" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>Address 2</label>
                    <input type="text" name="address2" value="{{!empty($address->address2) ? $address->address2 : '' }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Zip Code</label>
                    <input type="text" name="zip" maxlength="10" value="{{!empty($address->zip) ? $address->zip : '' }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" value="{{!empty($address->phone) ? $address->phone : '' }}" maxlength="10" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{!empty($address->email) ? $address->email : '' }}" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label>Comment</label>
                <textarea class="form-control" name="comment" required></textarea>
            </div>
            </div>

             <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
        </form>
    </div>
    <div class="modal-footer">
       
    </div>
</div>

<script type="text/javascript">
  
    function updateOrderDetails(){
        var formData = $('form#orderStausUpdate').eq(0).serialize();
        formData = formData+'&_token='+"{{ csrf_token() }}"; 
        
        $.ajax({
          url: '{{url("admin/update-order-details")}}',
          type: 'post', 
          data: formData,
          success: function(data){
           var res = JSON.parse(data)
           if(res.status == 'success'){
               toastr.success(res.msg);
               $('#modal-default').modal('hide');
           }

          }
        });
        return false;
    }
</script>