<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    
    <div class="page-title">
      <div class="title_left" style="width: 15%;">
        <h3>Order List</h3>
      </div>
      <div class="title_left">
      <div id="alert_id">
        <?php if($this->session->flashdata('msg')) echo '<div class="alert alert-success">'.$this->session->flashdata('msg').'</div>'; ?>
      </div>
      </div>
           
    </div>
    <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <?php
                    echo form_open(base_url() . "admin/delete-or-ac_inac-multi-order", array("class" => "form-horizontal form-label-left", "name" => "Delete_Form","id" => "mmursp_deleteForm"));
                  ?>  
                  <input type="hidden" id="mmursp_id" name="mmursp_id" value=""/> 
                  <div class="row">
                    <div class="col-md-2">
                      <select name="mmursp_select_action_top" id="bulk-action-selector-top" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete" class="">Delete</option>
                        <option value="pending" class="">Pending</option>
                        <option value="completed" class="">Completed</option>
                        <option value="cancelled" class="">Cancelled</option>
                      </select>
                      
                    </div>
                    <div class="col-md-1">
                      <input type="button" id="doaction" class="btn btn-success"  onclick="mmursp_how_many('order');" value="Apply">
                    </div>
                    <div class="col-md-3">
                      <select name="inputCustomer" id="inputCustomer" class="form-control col-md-7 col-xs-12">
                        <option value="">Select Customer</option>
                        <?php if(count($customer)>0){
                          //pre($customer,1);
                          $option = $selected = '';
                          foreach($customer as $row){ 
                            $customer_id = $this->input->get('customer_id');
                            if(!empty($customer_id)){
                              if($row['id'] == $customer_id)
                                  $selected = 'selected';
                              else $selected = '';
                            }
                            $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                            ?>
                        <?php }?>
                            <?php echo $option; ?>
                      <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <select name="inputOrderStatus" id="inputOrderStatus" class="form-control col-md-7 col-xs-12">
                        <option value="">Select Status</option>
                        <?php  $order_status = $this->input->get('order_status'); ?>
                        <option value="0" <?php echo ($order_status == '0')?'selected':'' ?>>Pending</option>
                         <option value="1" <?php echo ($order_status == '1')?'selected':'' ?>>Completed</option>
                        <option value="2" <?php echo ($order_status == '2')?'selected':'' ?>>Cancelled</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <select name="inputPaymentType" id="inputPaymentType" class="form-control col-md-7 col-xs-12">
                        <option value="">Payment Type</option>
                        <?php 
                          $payment_type = '';
                          if(!empty($this->input->get('payment_type'))) {
                          $payment_type = $this->input->get('payment_type'); } 
                        ?>
                        <option value="1" <?php echo ($payment_type == '1')?'selected':'' ?>>Paytm</option>
                         <option value="2" <?php echo ($payment_type == '2')?'selected':'' ?>>Cash On Delivery</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-2">
                      <select name="inputPaidStatus" id="inputPaidStatus" class="form-control col-md-7 col-xs-12">
                        <option value="">Paid Status</option>
                        <?php
                          $paid_status = $this->input->get('paid_status');
                        ?>
                        <option value="1" <?php echo ($paid_status == '0')?'selected':'' ?>>Paid</option>
                         <option value="2" <?php echo ($paid_status == '1')?'selected':'' ?>>Pending</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="inputOrderNo" id="inputOrderNo" value="<?php echo !empty($this->input->get('order_no'))? $this->input->get('order_no'):'' ;?>" placeholder="Search By Order No"/>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="inputTxnId" id="inputTxnId" value="<?php echo !empty($this->input->get('txn_id'))? $this->input->get('txn_id'):'' ;?>" placeholder="Search By Txn. Id"/>
                    </div>
                    <div class="col-md-1">
                       <input type="button" id="doaction" class="btn btn-success"  onclick="filter('order');" value="Filter">
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                   <div class="clearfix"></div>
                </div>
               <div class="x_content">
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                      <thead>
                      <tr>
                        <th width="8px"><input id="mmursp_root_checkbox_id_top" type="checkbox"  style="margin-left:0px;margin-right:5px;" value="1" onclick="mmursp_all_check_top()"></th>
                        <th>Order No.</th>
                        <th>Price</th>
                        <th>Txn. Id</th>
                        <th>Customer Name</th>
                        <th>Payment Type</th>
                        <th>Paid Status</th>
                        <th>Order Date</th>
            						<th width="80px">Status</th>
            						<th width="180px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if(count($orderList)>0){
						   foreach($orderList as $row){ ?>
							   <tr id="module_data_<?php echo $row['id']; ?>">
                  <td>
                    <input id="delete_check_id_<?php echo $row['id']; ?>" class="mmursp_delete_check_class" type="checkbox" name="delete_check[]" onclick="mmursp_each_check(<?php echo $row['id']; ?>)" value="<?php echo $row['id']; ?>">
                  </td>
									<td><?php echo $row['order_no']; ?></td>
                  <td><?php echo $row['total_price']; ?></td>
                  <td><?php echo $row['txn_id']; ?></td>
                  <td><?php echo $row['customer_name']; ?></td>
                  <td>
                      <?php echo ($row['payment_type'] == '1')? 'Paytm':'Cash On Delivery'; ?>
                  </td>
                  <td>
                      <?php echo ($row['is_paid'] == '0')? 'Pending':'Paid'; ?>
                  </td>
									<td><?php echo $row['date_created']; ?></td>
									<td>
                      <?php if($row['status'] == '0') {?>
                          <a class="label active" style="color:blue;" value="<?php echo $row['status']; ?>"href="javascript:void(0)" id="status_id_<?php echo $row['id']; ?>">Pending</a>
                        <?php }else if($row['status'] == '1'){ ?>
                          <a class="label active" value="<?php echo $row['status']; ?>" style="color:green;" href="javascript:void(0)" id="status_id_<?php echo $row['id']; ?>">Completed</a>
                      <?php } else if($row['status'] == '2'){?> 
                        <a class="label active" value="<?php echo $row['status']; ?>" style="color:red;" href="javascript:void(0)" id="status_id_<?php echo $row['id']; ?>">Cancelled</a>
                      <?php } ?>        
                  </td>
									<td><a class="label brown" href="<?php echo base_url('admin/update-order').'/'. $row['id']; ?>">Edit</a>
                    <a class="label red" href="#" onclick="confirm_modal('<?php echo $row['id'];?>','order');">Delete</a>
                  </td>
									
							   </tr>
						   <?php }
					   }
					   else{ ?>
						   <tr>
							<td colspan="7">No order found</td>
						   </tr>
					  <?php }  ?>
                        
                    </tbody>
                  </table>
                  
                  
               </div>
               <?php //if (isset($links)) { ?>
                <?php //echo $links ?>
            <?php //} ?>
              </div>
            </div>
    </div>
</div>
<style type="text/css">
  .pagination span{
    padding-right: 10px;
    border: 1px solid green;
    padding: 8px;
    margin-right: 5px;
  }
  .pagination {
    float: right;
    margin: 5px 0;
  }
</style>

    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;"></h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo base_url(); ?>assets/js/mycustom.js"></script>