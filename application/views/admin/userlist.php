<style>
.label{
	border:1px solid;
}
.red{
	color:red;
}
.blue{
	color:blue;
}
.brown{
	color:#a94442;
}
.select-hight{
  height: 28px !important;
}
</style>
<div class="">
    
      <div class="page-title">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">
             <h3>User List </h3>
          </div>
          <div class="col-sm-10">
            <div class="alert alert-info" id="alert" style="display: none;"></div>
          </div>
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
                    <div class="col-md-9">
                      
    				            <?php //if (isset($links)) { ?>
                          <?php //echo $links ?>
                        <?php //} ?>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                   <div class="clearfix"></div>
                </div>
               <div class="x_content">
                  <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
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
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <select class="form-control select-hight" name="is_status" id="is_status_<?php echo $row['id']; ?>" onchange="change_status(<?php echo $row['id']; ?>,'user')">
                        <option value="active" <?php echo ($row['is_active']=='active')? 'selected':'';?>>Active</option>
                        <option value="inactive" <?php echo ($row['is_active']=='inactive')? 'selected':'';?>>Inactive</option>
                        </select>
                    </div>
                   </td>
									<td><a class="label brown" href="<?php echo base_url('admin/update-user').'/'. $row['id']; ?>">Edit</a>
                    <a class="label red" href="javascript:void(0);" onclick="remove_module_single_data(<?php echo $row['id'];?>,'user');">Delete</a>
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
<script src="<?php echo base_url(); ?>assets/js/mycustom.js"></script>
