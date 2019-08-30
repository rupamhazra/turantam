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
.alert{
  padding-left: 15px;
  padding-top: 8px;
  margin-bottom: 10px;
  border: 1px solid transparent;
  border-radius: 4px;
  padding-bottom: 8px;
  color: #fff;
}
</style>
<div class="">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">
             <h3>Comment List </h3>
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
                    echo form_open(base_url() . "admin/delete-or-ac-inac-multi-comment", array("class" => "form-horizontal form-label-left", "name" => "Delete_Form","id" => "mmursp_deleteForm"));
                  ?>  
                  <input type="hidden" id="mmursp_id" name="mmursp_id" value=""/> 
                  <div class="row">
                    <div class="col-md-2">
                      <select name="mmursp_select_action_top" id="bulk-action-selector-top" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete" class="">Delete</option>
                        <option value="pending" class="">Pending</option>
                        <option value="approve" class="">Approve</option>
                        <option value="unapprove" class="">Reject</option>
                      </select>
                      
                    </div>
                    <div class="col-md-1">
                      <input type="button" id="doaction" class="btn btn-success"  onclick="mmursp_how_many();" value="Apply">
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
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                      <thead>
                      <tr>
                        <th width="8px"><input id="mmursp_root_checkbox_id_top" type="checkbox"  style="margin-left:0px;margin-right:5px;" value="1" onclick="mmursp_all_check_top()"></th>
                        <th>Author</th>
                        <th width="40%">Comment</th>
                        <th>Post</th>
                        <th>Submitted On</th>
                        <th width="14%">Status</th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <?php if(count($commentList)>0){
               foreach($commentList as $row){ ?>
                 <tr>
                  <td><input id="delete_check_id_<?php echo $row['id']; ?>" class="mmursp_delete_check_class" type="checkbox" name="delete_check[]" onclick="mmursp_each_check(<?php echo $row['id']; ?>)" value="<?php echo $row['id']; ?>">  </td>
                  <td><?php echo $row['user_name']; ?></td>
                  <td><?php echo $row['title']; ?></td>
                  <td><a href="<?php echo base_url('admin/update-blog/').$row['post_id']; ?>"><?php echo $row['blog_title']; ?></a></td>
                  <td><?php echo $row['date_created']; ?></td>
                  <td> 
                      <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="is_approved" id="is_approved_<?php echo $row['id']; ?>" onchange="change_comment_status(<?php echo $row['id']; ?>)">
                            <option value="0" <?php echo ($row['is_approved']=='0')? 'selected':'';?>>Pending</option>
                            <option value="1" <?php echo ($row['is_approved']=='1')? 'selected':'';?>>Approve</option>
                             <option value="2" <?php echo ($row['is_approved']=='2')? 'selected':'';?>>Reject</option>
                            </select>
                      </div>
                      
                  </td>
                  <td><a class="label brown" href="<?php echo base_url('admin/update-comment').'/'. $row['id']; ?>">Edit</a> 
                    
                    <a class="label red" href="#" onclick="confirm_modal('<?php echo base_url('admin/delete-comment').'/'.$row['id'];?>');">Delete</a>
                    
                  </td>
                  
                 </tr>
               <?php }
             }
             else{ ?>
               <tr>
              <td colspan="7">No Comments found</td>
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

  var url = '<?php echo base_url() ?>';
       $(document).ready( function () {
    $('#datatable').DataTable();
} );

 function change_comment_status(id){
    var val = $("#is_approved_"+id).val();
    var text = $("#is_approved_"+id+" option:selected").text();
     $.ajax({
          url : url+'admin/change-comment-approve',
          type : "post",
          data : {id: id, is_approved: val},
          success : function(response){
              console.log(response);
              if(response!='')
              {
                console.log(text);
                  //$("#alert").html('');
                  $("#alert").html('').html('<strong>!! Status changed to '+text+'</strong>').show();
                 //window.location = url+'admin/comment-list';
              }
          }
        });
 }
</script>