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
.badge-bc{
  background-color: #5cb85c;
  color: #fff !important;
}
.alert{
  padding: 7px;
  margin-bottom: 0px;
  padding-left: 30px;
}
a.label:focus, a.label:hover {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.no_category{
      text-align: center;
    color: skyblue;
    border: 1px solid #E6E9ED;
    padding: 10px;
    font-weight: 600;
    margin-bottom: 5px;
}
</style>
<div class="">
  
      <div class="page-title">
          <div class="title_left" style="width: 15%;">
            <h3>Blog Category </h3>
          </div>
          <div class="title_left">
            <div id="alert_id"></div>
          </div>
      </div>
    <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <div class="row">
                    
                   <div class="col-sm-2 pull-right">
                     <a href="<?php echo base_url('admin/add-blog-category') ?>" class="btn btn-success">Add Category</a>
                   </div>
                  </div>          
                  
                  <div class="clearfix"></div>
                </div>
               <div class="x_content">
                  <p><?php echo $this->session->flashdata('msg');?></p>
                  <?php if(count($parentList)>0){ 
                      foreach($parentList as $key => $row){
                  ?>
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="">
                      <div class="col-sm-12">
                        <div class="col-sm-8">
                          <h2>
                            <?php if(!empty($row['image'])) {?>
                            <img src="<?php echo base_url('uploads/').$row['image']; ?>" height="40" width="40"/>&nbsp;<?php echo $row['category_name']; ?>
                            <?php } else{?>
                               <img src="<?php echo base_url('assets/img/no_image.png'); ?>" height="40" width="40"/>&nbsp;<?php echo $row['category_name']; ?>
                            <?php }?>
                          </h2>
                        </div>
                        <div class="col-sm-3">
                          <a class="label " <?php if($row['is_active']=='active') echo 'style="color:green;"'; else echo'style="color:red;"'; ?> href="javascript:void(0)" onclick="change_status(<?php echo $row['id']; ?>)" id="status_id_<?php echo $row['id']; ?>"><?php echo ucfirst($row['is_active']); ?></a>

                          <a class="label brown" href="<?php echo base_url('admin/edit-blog-category').'/'. $row['id']; ?>">Edit</a>
                          <a class="label red" href="javascript:void(0)" onclick="confirm_modal('<?php echo $row['id'];?>');">Delete</a>

                          <a class="label green" href="<?php echo base_url('admin/blog-add').'/'. $row['id']; ?>">Add Blog</a>
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
	function confirm_modal(id)
	{
    delete_url = url+'admin/delete-blog-category/'+id;
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
    <script src="<?php echo base_url(); ?>assets/js/multicheckbox_category.js"></script>
    <script type="text/javascript">
      
       $(document).ready( function () {
          $('#datatable').DataTable();
      } );

      function change_status(id){

        console.log('dsfsdfsdfsd');
                    //return true;
                    //$("#overlay").show();
                    
                    //var data = $("#booking_form");
                    //var base_url = $("base").attr("href");
                    
                    //console.log(url);
                    
                    $.ajax({
                        url : url+'admin/change-blog-category-status/'+id,
                        type : "post",
                        data : 1,
                        cache : false,
                        contentType : false,
                        processData : false,
                        success : function(response){
                            //alert(response);
                            console.log(response);
                            if(response)
                            {
                              if(response == 'Active') $('#status_id_'+id).css('color','green');
                                if(response == 'Inactive') $('#status_id_'+id).css('color','red');
                                $('#status_id_'+id).text(response);
                                $("#overlay").hide();
                                $("#alert_id").html('<div class="alert alert-success">!! Status changed to '+response+'</div>');
                            }
                        }
                    });
      }
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
       $.ajax({
                url : url+'admin/blog-parent-category-list-by-id/',
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
                          html += "<div class='col-md-8'>";
                          html += '<h4 class="panel-title"><img src="'+'<?php echo base_url('uploads/')?>'+v.image+'" width="40" height="40"/>'+'&nbsp;'+v.category_name+'</h4></div>';
                          html += "<div class='col-md-3'>";
                          if(v.is_active = 'active')
                          html += "<a class='label' style='color:green;' href='javascript:void(0)' onclick='change_status("+v.id+")' id='status_id_"+v.id+"'>Active</a>&nbsp;";
                          else
                            html += "<a class='label' style='color:red;' href='javascript:void(0)' onclick='change_status("+v.id+")' id='status_id_"+v.id+"'>Inactive</a>&nbsp;";

                          html += "<a class='label brown' href='"+'<?php echo base_url('admin/edit-blog-category/')?>'+v.id+"'>Edit</a>&nbsp;";

                          html += "<a class='label red' href='javascript:void(0)' onclick='confirm_modal("+v.id+")'>Delete</a>&nbsp;";

                          html += "<a class='label green' href='"+'<?php echo base_url('admin/blog-add/')?>'+v.id+"'>Add Blog</a>";

                          html +="</div>";
                          html += "<div class='col-md-1'><a href='javascript:void(0)' onclick='showsub_sub_categorypanel("+v.id+")'><i class='fa fa-chevron-down' id='up_down_icon_sub_id_"+v.id+"'></i></a></div>";
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
                url : url+'admin/blog-parent-category-list-by-id/',
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
                          html += '<td><img src="'+'<?php echo base_url('uploads/')?>'+v.image+'" width="40" height="40"/></td>';
                          html += '<td>'+v.category_name+'</td>';
                          html += '<td>'+v.date_created+'</td>';
                          html += '<td>';

                          if(v.is_active == 'active')
                            html += "<a class='label' style='color:green;' href='javascript:void(0)' onclick='change_status("+v.id+")' id='status_id_"+v.id+"'>Active</a>&nbsp;";
                          else
                            html += "<a class='label' style='color:red;' href='javascript:void(0)' onclick='change_status("+v.id+")' id='status_id_"+v.id+"'>Inactive</a>&nbsp;";
                          
                          html += "<a class='label brown' href='"+'<?php echo base_url('admin/edit-blog-category/')?>'+v.id+"'>Edit</a>&nbsp;";

                          html += "<a class='label red' href='javascript:void(0)' onclick='confirm_modal("+v.id+")'>Delete</a>&nbsp;";

                          html += "<a class='label green' href='"+'<?php echo base_url('admin/blog-add/')?>'+v.id+"'>Add Blog</a>"; 
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