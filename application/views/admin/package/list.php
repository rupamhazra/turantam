<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    
    <div class="page-title">
      <div class="title_left" style="width: 20%;">
        <h3>Package List</h3>
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
                    echo form_open(base_url() . "admin/delete-or-ac_inac-multi-package", array("class" => "form-horizontal form-label-left", "name" => "Delete_Form","id" => "mmursp_deleteForm"));
                  ?>  
                  <input type="hidden" id="mmursp_id" name="mmursp_id" value=""/> 
                  <div class="row">
                    <div class="col-md-2">
                      <select name="mmursp_select_action_top" id="bulk-action-selector-top" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete" class="">Delete</option>
                        <option value="active" class="">Active</option>
                        <option value="inactive" class="">Inactive</option>
                      </select>
                      
                    </div>
                    <div class="col-md-1">
                      <input type="button" id="doaction" class="btn btn-success"  onclick="mmursp_how_many('package');" value="Apply">
                    </div>
                    <div class="col-md-3">
                      <select name="inputService" id="inputService" class="form-control">
                        <?php if(count($serviceList)>0){
                          //pre($serviceList,1);
                          $option = '<option value="">Select Service</option>';
                          $selected = '';
                          foreach($serviceList as $row){ 
                            $cat_id = $this->input->get('service_id');
                            if(!empty($cat_id)){
                              if($cat_id == $row['id']) $selected = 'selected';
                              else $selected='';
                            } 
                            $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                            ?>
                        <?php }?>
                            <?php echo $option; ?>  
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="inputPackage" id="inputPackage" value="<?php echo !empty($this->input->get('package_name'))? $this->input->get('package_name'):'' ;?>" placeholder="Please Enter Package Name"/>
                    </div>
                    <div class="col-md-1">
                       <input type="button" id="doaction" class="btn btn-success"  onclick="filter('package');" value="Filter">
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
                        <th>Name</th>
            						<th>Sevice</th>
                        <th>Date Created</th>
            						<th width="80px">Status</th>
            						<th width="180px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php if(count($packageList)>0){
						   foreach($packageList as $row){ ?>
							   <tr id="module_data_<?php echo $row['id']; ?>">
                  <td>
                    <input id="delete_check_id_<?php echo $row['id']; ?>" class="mmursp_delete_check_class" type="checkbox" name="delete_check[]" onclick="mmursp_each_check(<?php echo $row['id']; ?>)" value="<?php echo $row['id']; ?>">
                  </td>
									<td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['service_name']; ?></td>
									<td><?php echo $row['date_created']; ?></td>
									<td>
                      <?php if($row['is_active'] == '1') {?>
                          <a class="label active" style="color:green;" value="<?php echo $row['is_active']; ?>"href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>,'package');" id="status_id_<?php echo $row['id']; ?>">Active</a>
                        <?php }else{ ?>
                          <a class="label active" value="<?php echo $row['is_active']; ?>" style="color:red;" href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>,'package');" id="status_id_<?php echo $row['id']; ?>">Inactive</a>
                      <?php } ?>         
                  </td>
									<td><a class="label brown" href="<?php echo base_url('admin/update-package').'/'. $row['id']; ?>">Edit</a>
                    <a class="label red" href="#" onclick="confirm_modal('<?php echo $row['id'];?>','package');">Delete</a>
                  </td>
									
							   </tr>
						   <?php }
					   }
					   else{ ?>
						   <tr>
							<td colspan="7">No package found</td>
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