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
            <div class="title_left">
              <h3>Card Category</h3>
            </div>

           
          </div>
    <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <?php
                    echo form_open(base_url() . "admin/delete-or-ac_inac-multi-card-cat", array("class" => "form-horizontal form-label-left", "name" => "Delete_Form","id" => "mmursp_deleteForm"));
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
                      <input type="button" id="doaction" class="btn btn-success"  onclick="mmursp_how_many();" value="Apply">
                    </div>
                    <div class="col-md-7">
                      
                        <?php if (isset($links)) { ?>
                          <?php echo $links ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-2">
                      <a href="<?php echo base_url('admin/add-card-category'); ?>" class="btn btn-success pull-right">Add Category</a>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                  
                   <div class="clearfix"></div>
                </div>
               <div class="x_content">
                  <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                  <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                      <tr>
                         <th width="8px"><input id="mmursp_root_checkbox_id_top" type="checkbox"  style="margin-left:0px;margin-right:5px;" value="1" onclick="mmursp_all_check_top()"></th>
                        <th>Name</th>
						<th>Url</th>
						
						<th width="80px">Status</th>
						<th width="180px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if(count($cardCategoryList)>0){
						   foreach($cardCategoryList as $row){ ?>
							   <tr>
                  <td><input id="delete_check_id_<?php echo $row['id']; ?>" class="mmursp_delete_check_class" type="checkbox" name="delete_check[]" onclick="mmursp_each_check(<?php echo $row['id']; ?>)" value="<?php echo $row['id']; ?>">  </td>
									<td><?php echo $row['category_name']; ?></td>
									<td><?php echo $row['category_url']; ?></td>
									
									<td><a class="label " <?php if($row['is_active']=='active') echo 'style="color:green;"'; else echo'style="color:red;"'; ?> href="<?php echo base_url().'admin/change-card-category-status/'.$row['id']; ?>"><?php echo ucfirst($row['is_active']); ?></a></td>
									<td><a class="label brown" href="<?php echo base_url('admin/edit-card-category').'/'. $row['id']; ?>">Edit</a> <a class="label red" href="#" onclick="confirm_modal('<?php echo base_url('admin/delete-card-category').'/'.$row['id'];?>');">Delete</a>
                  </td>
									
							   </tr>
						   <?php }
					   }
					   else{ ?>
						   <tr>
							<td colspan="5">No blog category found</td>
						   </tr>
					  <?php }  ?>
                        
                    </tbody>
                  </table>
                  
                  
               </div>
              </div>
            </div>
    </div>
</div>
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
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this Blog Category ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/multicheckbox.js"></script>
    <script type="text/javascript">
       $(document).ready( function () {
    $('#datatable').DataTable();
} );
    </script>