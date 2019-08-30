<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
  
      <div class="page-title">
          <div class="title_left" style="width: 20%;">
            <h3>Service Category </h3>
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
            <div class="row">
              
             <div class="col-sm-2 pull-right">
               <a href="<?php echo base_url('admin/add-service-category') ?>" class="btn btn-success">Add Category</a>
             </div>
            </div>          
            
            <div class="clearfix"></div>
          </div>
         <div class="x_content">
            
            <?php if(count($parentList)>0){ 
                foreach($parentList as $key => $row){
            ?>
           <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <div class="">
                <div class="col-sm-12">
                  <div class="col-sm-9">
                    <h2>
                      <?php if(!empty($row['image_small'])) {?>
                      <img src="<?php echo base_url('uploads/').$row['image_small']; ?>" height="40" width="40"/>&nbsp;<?php echo $row['name']; ?>
                      <?php } else{?>
                         <img src="<?php echo base_url('assets/img/no_image.png'); ?>" height="40" width="40"/>&nbsp;<?php echo $row['name']; ?>
                      <?php }?>
                    </h2>
                  </div>
                  <div class="col-sm-2">
                    <?php if($row['is_active'] == '1') {?>
                      <a class="label" style="color:green;" value="<?php echo $row['is_active']; ?>"href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>,'service-category');" id="status_id_<?php echo $row['id']; ?>">Active</a>
                    <?php }else{ ?>
                      <a class="label" value="<?php echo $row['is_active']; ?>" style="color:red;" href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>,'service-category');" id="status_id_<?php echo $row['id']; ?>">Inactive</a>
                    <?php } ?>
                    <a class="label brown" href="<?php echo base_url('admin/edit-service-category').'/'. $row['id']; ?>">Edit</a>
                    <a class="label red" href="javascript:void(0)" onclick="confirm_modal('<?php echo $row['id'];?>','service-category');">Delete</a>

                   <!--  <a class="label green" href="<?php echo base_url('admin/add-service').'/'. $row['id']; ?>">Add service</a> -->
                  </div>
                  <div class="col-sm-1">
                    <a href="javascript:void(0)" onclick="showsubcategorypanel(<?php echo $row['id']; ?>)"><i class="fa fa-chevron-down" id="up_down_icon_id_<?php echo $row['id']; ?>"></i></a>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" id="x_content_id_<?php echo $row['id']; ?>" style="display: none;">

              <!-- start accordion -->
              <div class="accordion" id="accordion_<?php echo $row['id']; ?>" role="tablist" aria-multiselectable="true">
               
                
                
              </div>
              <!-- end of accordion -->


            </div>
          </div>
        </div>
          <?php }} ?>
         </div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
  var url = '<?php echo base_url() ?>';
	// function confirm_modal(id)
	// {
 //    delete_url = url+'admin/delete-service-category/'+id;
	// 	$('#modal-4').modal('show', {backdrop: 'static'});
	// 	document.getElementById('delete_link').setAttribute('href' , delete_url);
	// }
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this service Category ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/multicheckbox_category.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/mycustom.js"></script>
<script type="text/javascript">
  var base_url = '<?php echo base_url(); ?>';
</script>
  
<script type="text/javascript">
  function showsubcategorypanel(id){
    if($("#x_content_id_"+id).is(':visible')){
        $("#up_down_icon_id_"+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        //$("#x_content_id_"+id).hide();
        $("#x_content_id_"+id).slideUp(function() {$(this).css('display', 'none');});
    }
    else
    {
      $("#up_down_icon_id_"+id).removeClass('fa-chevron-down').addClass('fa-chevron-up');
      
      var html = '';
      var module_s = 'service-category';
       $.ajax({
                url : url+'admin/service-parent-category-list-by-id/',
                type : "post",
                data : {id: id},
                // cache : false,
                // contentType : false,
                // processData : false,
                success : function(response){
                    //alert(response);
                    console.log(response);
                    response = JSON.parse(response);
                    if(response!='')
                    {
                      $.each(response,function(k,v){
                          html += '<div class="panel" id="panel_id_'+v.id+'">'; 
                          html += "<div class=''>";
                          html += "<div class='col-md-12 panel-heading' style='margin-bottom: 10px;'>";
                          html += "<div class='col-md-9'>";
                          html += '<h4 class="panel-title"><img src="'+'<?php echo base_url('uploads/')?>'+v.image_small+'" width="40" height="40"/>'+'&nbsp;'+v.name+'</h4></div>';
                          html += "<div class='col-md-2'>";
                          if(v.is_active = 'active')
                          html += "<a class='label' style='color:green;' href='javascript:void(0)' onclick='change_status(\""+v.id+"\",\""+module_s+"\")' id='status_id_"+v.id+"'>Active</a>&nbsp;";
                          else
                            html += "<a class='label' style='color:red;' href='javascript:void(0)' onclick='change_status(\""+v.id+"\",\""+module_s+"\")' id='status_id_"+v.id+"'>Inactive</a>&nbsp;";

                          html += "<a class='label brown' href='"+'<?php echo base_url('admin/edit-service-category/')?>'+v.id+"'>Edit</a>&nbsp;";
                          html += "<a class='label red' href='javascript:void(0)' onclick='confirm_modal(\""+v.id+"\",\""+module_s+"\")'>Delete</a>&nbsp;";
                          //html += '<a class="label red" href="javascript:void(0)"';
                          //html += 'onclick="confirm_modal('+v.id+'",service-category"'+')"';

                          //html += '>Delete</a>&nbsp;';

                          html +="</div>";
                          //html += "<div class='col-md-1'><a href='javascript:void(0)' onclick='showsub_sub_categorypanel("+v.id+")'><i class='fa fa-chevron-down' id='up_down_icon_sub_id_"+v.id+"'></i></a></div>";
                          html += "</div></div>";
                          html += '' ;
                          html +='<div id="collapse_'+v.id+'" class="" role="tabpanel" aria-labelledby="" style="display:none;"> <div class="panel-body" id="panel_body_id_'+v.id+'"></div></div></div>';
                      });
                      
                       $("#accordion_"+id).html(html);
                       //$("#x_content_id_"+id).slideDown(function() {$(this).css('display', 'block');});
                    }
                    else
                    {
                      $("#x_content_id_"+id).html('<div class="col-md-12 no_category">No Sub Category Found</div>');
                    }
                    $("#x_content_id_"+id).slideDown(function() {$(this).css('display', 'block');});
                }
            });
    }
  }

   function showsub_sub_categorypanel(id){
    if($("#collapse_"+id).is(':visible')){
        $("#up_down_icon_sub_id_"+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        //$("#collapse_"+id).hide();
        $("#collapse_"+id).slideUp(function() {$(this).css('display', 'none');});
    }
    else
    {
      
       $("#up_down_icon_sub_id_"+id).removeClass('fa-chevron-down').addClass('fa-chevron-up');
      var html = '';
       $.ajax({
                url : url+'admin/service-parent-category-list-by-id/',
                type : "post",
                data : {id: id},
                // cache : false,
                // contentType : false,
                // processData : false,
                success : function(response){
                    //alert(response);
                    console.log(response);
                    response = JSON.parse(response);
                    if(response!='')
                    {
                      html +="<table class='table table-bordered'> <thead> <tr> <th>Image</th><th width='48%'>Name</th><th>Date Created</th><th>Action</th> </tr></thead> <tbody>";
                      $.each(response,function(k,v){
                          html += '<tr>';
                          html += '<td><img src="'+'<?php echo base_url('uploads/')?>'+v.image_small+'" width="40" height="40"/></td>';
                          html += '<td>'+v.name+'</td>';
                          html += '<td>'+v.date_created+'</td>';
                          html += '<td>';

                          if(v.is_active == 'active')
                            html += "<a class='label' style='color:green;' href='javascript:void(0)' onclick='change_status("+v.id+")' id='status_id_"+v.id+"'>Active</a>&nbsp;";
                          else
                            html += "<a class='label' style='color:red;' href='javascript:void(0)' onclick='change_status("+v.id+")' id='status_id_"+v.id+"'>Inactive</a>&nbsp;";
                          
                          html += "<a class='label brown' href='"+'<?php echo base_url('admin/edit-service-category/')?>'+v.id+"'>Edit</a>&nbsp;";

                          html += "<a class='label red' href='javascript:void(0)' onclick='confirm_modal("+v.id+")'>Delete</a>&nbsp;";

                          html += "<a class='label green' href='"+'<?php echo base_url('admin/service-add/')?>'+v.id+"'>Add service</a>"; 
                          html += "</td>";
                          html += '</tr>';
                      });
                      html +="</tbody> </table>";
                       $("#panel_body_id_"+id).html(html);
                    }
                    else
                    {
                      $("#collapse_"+id).html('<div class="col-md-12 no_category">No Sub Category Found</div>');
                    }
                    $("#collapse_"+id).slideDown(function() {$(this).css('display', 'block');});
                }
            });
     }
  }
</script>