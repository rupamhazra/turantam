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
</style>
<div class="">
    
       <div class="page-title">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">
             <h3>Sliders </h3>
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
                    echo form_open(base_url() . "admin/delete-or-ac_inac-multi-home-page-slider", array("class" => "form-horizontal form-label-left", "name" => "Delete_Form","id" => "mmursp_deleteForm"));
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
                    <div class="col-md-8">
                      <input type="button" id="doaction" class="btn btn-success"  onclick="mmursp_how_many('home-page-slider');" value="Apply">
                    </div>
                    <div class="col-md-2">
                      <a href="<?php echo base_url('admin/add-home-page-slider') ?>" class="btn btn-success">Add Slider</a>
                    </div>
                    <!-- <div class="col-md-9">
                      
    				            <?php //if (isset($links)) { ?>
                          <?php //echo $links ?>
                        <?php //} ?>
                    </div> -->
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
                        <th width="8px"><input id="mmursp_root_checkbox_id_top" type="checkbox"  style="margin-left:0px;margin-right:5px;" value="1" onclick="mmursp_all_check_top()"></th>
                        <th>Title</th>
                        <th>Description</th>
            						<th width="80px">Status</th>
            						<th width="180px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if(count($bannerList)>0){
						   foreach($bannerList as $row){ ?>
							   <tr id="module_data_<?php echo $row['id']; ?>">
                  <td><input id="delete_check_id_<?php echo $row['id']; ?>" class="mmursp_delete_check_class" type="checkbox" name="delete_check[]" onclick="mmursp_each_check(<?php echo $row['id']; ?>)" value="<?php echo $row['id']; ?>">  </td>
									<td><?php echo $row['title']; ?></td>
                  <td><?php echo $row['description']; ?></td>
									<td>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <select class="form-control select-hight" name="is_status" id="is_status_<?php echo $row['id']; ?>" onchange="change_status(<?php echo $row['id']; ?>,'home-page-slider')">
                        <option value="active" <?php echo ($row['is_active']=='active')? 'selected':'';?>>Active</option>
                        <option value="inactive" <?php echo ($row['is_active']=='inactive')? 'selected':'';?>>Inactive</option>
                      </select>
                    </div>         
                  </td>
									<td><a class="label brown" href="<?php echo base_url('admin/update-home-page-slider').'/'. $row['id']; ?>">Edit</a>
                    <a class="label red" href="javascript:void(0);" onclick="remove_module_single_data(<?php echo $row['id'];?>,'home-page-slider');">Delete</a>
                  </td>
									
							   </tr>
						   <?php }
					   }
					   else{ ?>
						   <tr>
							<td colspan="6">No sliders found</td>
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
<script type="text/javascript">
	function confirm_modal(delete_url)
	{
		$('#modal-4').modal('show', {backdrop: 'static'});
		document.getElementById('delete_link').setAttribute('href' , delete_url);
	}
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this card Category ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo base_url(); ?>assets/js/mycustom.js"></script>