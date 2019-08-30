<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Order</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Order :: <span class="label label-warning" style="color: #fff"><?php echo $order['order_no']; ?></span></h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-order/".$order['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <input type="hidden" name="edit" id="edit" value="1">
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Paid Status</label>
                        <div class="col-md-12" for="title">
                            <select name="inputIsPaid" id="inputIsPaid" class="form-control col-md-7 col-xs-12">
                                <option value="1" <?php echo ($order['is_paid'] == '1')?'selected':'' ?>>Paid</option>
                                 <option value="0" <?php echo ($order['is_paid'] == '0')?'selected':'' ?>>Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Order Date</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class='input-group date' id='myDatepicker'>
                                <input type='text' name="inputOrderDate" class="form-control" value="<?php echo $order['date_created']; ?>" />
                                <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                           <!-- <input type="text" name="inputTxnId" id="inputTxnId" class="form-control" value="<?php echo $order['date_created']; ?>"> -->
                       </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Txn Id</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputTxnId" id="inputTxnId" class="form-control" value="<?php echo $order['txn_id']; ?>">
                       </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Total Price : </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputTotalPrice" id="inputTotalPrice" class="form-control" value="<?php echo $order['total_price']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Checksumhash</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputChecksumhash" id="inputChecksumhash" class="form-control" value="<?php echo $order['checksumhash']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Customer Address</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputAdddress" id="inputAdddress" class="form-control col-md-7 col-xs-12">
                                <?php if(count($customer_address)>0){
                                  //pre($customer_address,1);
                                  $option = '';
                                  foreach($customer_address as $row){ 
                                    if($row['id'] == $order['address_id'])
                                        $selected = 'selected';
                                    else $selected = '';
                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['customer_full_address'].'</option>';
                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Customer</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputCustomer" id="inputCustomer" class="form-control col-md-7 col-xs-12">
                                <?php if(count($customer)>0){
                                  //pre($customer,1);
                                  $option = '';
                                  foreach($customer as $row){ 
                                    if($row['id'] == $order['customer_id'])
                                        $selected = 'selected';
                                    else $selected = '';
                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Payment Type</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputPaymentType" id="inputPaymentType" class="form-control col-md-7 col-xs-12">
                                <option value="1" <?php echo ($order['payment_type'] == '1')?'selected':'' ?>>Paytm</option>
                                <option value="2" <?php echo ($order['payment_type'] == '2')?'selected':'' ?>>Cash On Delivery</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Bank Txn Id</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputBankTxnId" id="inputBankTxnId" class="form-control" value="<?php echo $order['bank_txn_id']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Paytm Response</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea class="form-control" name="inputPaytmRes" id="inputPaytmRes"><?php echo $order['paytm_response']; ?></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Paytm Txn Status</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="inputPaytmTxnStatus" id="inputPaytmTxnStatus" class="form-control" value="<?php echo $order['txn_status']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Order Status</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputOrderStatus" id="inputOrderStatus" class="form-control col-md-7 col-xs-12">
                                <option value="0" <?php echo ($order['status'] == '0')?'selected':'' ?>>Pending</option>
                                 <option value="1" <?php echo ($order['status'] == '1')?'selected':'' ?>>Completed</option>
                                <option value="2" <?php echo ($order['status'] == '2')?'selected':'' ?>>Cancelled</option>
                            </select>
                        </div>
                    </div>
                     
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addBtn" type="submit" class="btn btn-success">Save</button>
							<button type="submit" class="btn btn-primary" onclick="history.back();">Back</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script>
$('#inputName').on('keyup keypress blur', function() 
{
	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputSlug').val(myStr); 
});
            

$("#addBtn").on("click",function(e){
    var proceedStep=true;
  $('.cForm').each(function(){
   if(!$.trim($(this).val())){ 
    $(this).addClass('errorClass'); 
    proceedStep = false;
   }
  });
  if(proceedStep==false){
	  e.preventDefault();
  }
});

</script>