<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
  <div class="page-title">
      <div class="title_left" style="width: 15%;">
        <h3>User List</h3>
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
                    echo form_open(base_url() . "admin/delete-or-ac_inac-multi-user", array("class" => "form-horizontal form-label-left", "name" => "Delete_Form","id" => "mmursp_deleteForm"));
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
                      <input type="button" id="doaction" class="btn btn-success"  onclick="mmursp_how_many('user');" value="Apply">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="uname_or_email" id="uname_or_email" value="<?php echo !empty($this->input->get('user_or_email'))? $this->input->get('user_or_email'):'' ;?>" placeholder="Please Enter Name or Email Id"/>
                    </div>
                    <div class="col-md-1">
                       <input type="button" id="doaction" class="btn btn-success"  onclick="filter('user');" value="Filter">
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                   <div class="clearfix"></div>
                </div>
               <div class="x_content">
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                      <thead>
                      <tr>
                        <th width="2%"><input id="mmursp_root_checkbox_id_top" type="checkbox"  style="margin-left:0px;margin-right:5px;" value="1" onclick="mmursp_all_check_top()"></th>
                        <th width="5%">Profile Pic</th>
                        <th width="25%">Name</th>
                        <th width="25%">Email</th>
            						<th width="5%">Status</th>
            						<th width="35%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if(count($userList)>0){
						   foreach($userList as $row){ ?>
							   <tr id="module_data_<?php echo $row['id']; ?>">
                  <td><input id="delete_check_id_<?php echo $row['id']; ?>" class="mmursp_delete_check_class" type="checkbox" name="delete_check[]" onclick="mmursp_each_check(<?php echo $row['id']; ?>)" value="<?php echo $row['id']; ?>">  </td>
                  <td>
                      <?php if(!empty($row['profile_image'])) {?>
                            <img src="<?php echo base_url('uploads/').$row['profile_image']; ?>" height="50" width="50"/>
                            <?php } else{?>
                               <img src="<?php echo base_url('assets/img/no-profile-image.png'); ?>"  width="50" height="50"/>
                      <?php }?>
                  </td>
									<td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['email']; ?></td>
									<td>
                     <?php if($row['is_active'] == '1') {?>
                          <a class="label active" style="color:green;" value="<?php echo $row['is_active']; ?>"href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>,'user');" id="status_id_<?php echo $row['id']; ?>">Active</a>
                        <?php }else{ ?>
                          <a class="label active" value="<?php echo $row['is_active']; ?>" style="color:red;" href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>,'user');" id="status_id_<?php echo $row['id']; ?>">Inactive</a>
                      <?php } ?>
                   </td>
									<td><a class="label brown" href="<?php echo base_url('admin/update-user').'/'. $row['id']; ?>">Edit</a>
                    <a class="label red" href="#" onclick="confirm_modal('<?php echo $row['id'];?>','user');">Delete</a>
                  </td>
									
							   </tr>
						   <?php }
					   }
					   else{ ?>
						   <tr>
							<td colspan="6">No user found</td>
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
    
<!-- (Normal Modal)-->
<script src="<?php echo base_url(); ?>assets/js/mycustom.js"></script>
