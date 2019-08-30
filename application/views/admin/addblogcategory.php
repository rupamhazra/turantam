<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}
.tag:after{
  content: none;
}
span.selected{
  background: #1ABB9C !important;
}
span.tag{
  padding: 10px 12px;
  cursor: pointer;
  background-color: gray;
}
.tagsinput span.tag a{
      font-size: 18px;
}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Blog</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Blog Category</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/save-blog-category", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="parent_id_confirm" id="parent_id_confirm" value="">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Parent <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputParent" id="inputParent" class="form-control col-md-7 col-xs-12" >
                                <option value="0">No Parent</option>
                                <?php if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  foreach($parentList as $row){ 
                                    $option .= '<option class="lavel-0" value="'.$row['id'].'">'.$row['category_name'].'</option>';
                                    if(isset($row['sub_category_details'])){
                                        foreach($row['sub_category_details'] as $row_s){
                                        $option .= '<option class="lavel-1" value="'.$row_s['id'].'">&nbsp;&nbsp;&nbsp;'.$row_s['category_name'].'</option>';
                                      }
                                    }

                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
					<!-- <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Sub Parent <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputSubParent" id="inputSubParent" class="form-control col-md-7 col-xs-12" onchange="get_sub_sub_parent();">
								<option value="0">No Sub Parent</option>
								
							</select>
                        </div>
                    </div> -->
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="inputName" class="form-control col-md-7 col-xs-12 cForm"  name="inputName" placeholder="Enter Name" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Url <span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="inputUrl" name="inputUrl" class="form-control col-md-7 col-xs-12" readonly>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Decsription <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control cForm" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Image </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="file" name="inputImage" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Template View<span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputTemplateView" class="form-control col-md-7 col-xs-12">
                                <option value="Default List View">Default List View</option>
                                <option value="Card List View">Card List View</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Tags<span class="required" placeholder="Enter Url"></span>
                        </label>
                        <div class="col-md-8 col-xs-8 col-xs-12">
                            <div class="">
                              <div class="x_content">
                                  
                                  <input id="tags_1" type="text" name="tag_name" class="tags form-control" value="" />
                                    
                                    <div class="row" style="float: left;margin-left: -34px;">
                                    
                                    </div>
                                    
                              </div>   
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-1 col-xs-12">
                            <div class="form-group">
                              
                                  <button id="addPage" type="button" class="btn btn-success" onclick="addTags()">Add Tag</button>
                              
                            </div>
                        </div>
                    </div>
                    <div class="item form-group" id="tags_id">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url"><span class="required" placeholder="Enter Url"></span>
                        </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <div id="tags_1_tagsinput1_exist" class="tagsinput exist_tag" style="width: auto; border:none;">
                          <?php if(count($tagsList)>0){ 
                        foreach($tagsList as $key => $row){
                        ?>
                            <input type="checkbox" name="selected_tags[]" id="selected_tags_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" style="display: none;">
                            <span class="tag" id="tag_id_<?php echo $row['id']; ?>" onclick="select_tags(<?php echo $row['id']; ?>);">
                              <span id="fullname_<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                                &nbsp;&nbsp;&nbsp;
                              </span>
                              <a href="javascript:void(0)" title="Removing tag" onclick="removeTag(<?php echo $row['id']; ?>);">x</a>
                            </span>

                             <?php }}?>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addPage" type="submit" class="btn btn-success">Submit</button>
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
$("#addPage").on("click",function(e){
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
<script type="text/javascript">
  var url = '<?php echo base_url() ?>';  
  function addTags(){
    var tag_name = $(".tags ").val();
    var html = '';
    var html1 = '';
    console.log(tag_name);
    $.ajax({
        url : url+'admin/add-tags',
        type : "post",
        data : {tag_name: tag_name,ajax: "on"},
        success : function(response){
            response = JSON.parse(response);
            console.log(response);
            if(response!='')
            {
              $.each(response,function(key,value){
                console.log(value);
                 html += "<span class='tag' id='tag_id_"+value.id+"' onclick='select_tags("+value.id+");'><span id='fullname_"+value.id+"'>"+value.name+"</span>&nbsp;&nbsp;&nbsp;";
                 html += "<a href='javascript:void(0)' title='Removing tag' onclick='removeTag("+value.id+");'>x</a></span>";
                  html += "<input type='checkbox' name='selected_tags[]' id='selected_tags_"+value.id+"' value='"+value.id+"' style='display: none;'>";
                  
              });
              $("#tags_1").val('');
              $('#tags_1_tagsinput').find('span').remove();
              $('#tags_1_tagsinput1_exist').prepend(html);
             
              
            }
        }
      });
  }
  // function addTags(){
  //   var tag_name = $(".tags ").val();
  //   var html = '';
  //   var html1 = '';
  //   console.log(tag_name);
  //   $.ajax({
  //       url : url+'admin/add-tags',
  //       type : "post",
  //       data : {tag_name: tag_name,ajax: "on"},
  //       success : function(response){
  //           //alert(response);
  //           console.log(response);
  //           if(response!='')
  //           {
  //             $.ajax({
  //                     url : url+'admin/tags',
  //                     type : "post",
  //                     data : {ajax: "on"},
  //                     success : function(response){
  //                       response = JSON.parse(response);
  //                       console.log(response);
  //                       $.each(response,function(key,value){
  //                         console.log(value);
  //                          html += "<span class='tag' id='tag_id_"+value.id+"' onclick='select_tags("+value.id+");'><span id='fullname_"+value.id+"'>"+value.name+"</span>&nbsp;&nbsp;&nbsp;";
  //                          html += "<a href='javascript:void(0)' title='Removing tag' onclick='removeTag("+value.id+");'>x</a></span>";
  //                           html += "<input type='checkbox' name='selected_tags[]' id='selected_tags_"+value.id+"' value='"+value.id+"' style='display: none;'>";
                            
  //                       });
  //                       $("#tags_1").val('');
  //                       $('#tags_1_tagsinput').find('span').remove();
  //                       $('#tags_1_tagsinput1_exist').html(html);
  //                     }
  //                 });
              
  //           }
  //       }
  //     });
  // }
  function removeTag(id){
    $.ajax({
        url : url+'admin/delete-tag/'+id,
        type : "POST",
        data : {ajax: 'on'},
        success : function(response){
          console.log(response);
          if(response){
            $("#tag_id_"+id).remove();
            $("#selected_tags_"+id).remove();
          }
        }
    });
  }
</script>
<script type="text/javascript">
 
function get_sub_category(){
    var html = '<option value="0">No Sub Parent</option>';
    var id = $("#inputParent").val();
    $("#parent_id_confirm").val(id);
    $.ajax({
          url : url+'admin/blog-parent-category-list-by-id',
          type : "post",
          data : {id: id},
          // cache : false,
          // contentType : false,
          // processData : false,
          success : function(response){
              //alert(response);
              
              response = JSON.parse(response);
              console.log(response);
              if(response!='')
              {
                
                $.each(response,function(key,value){
                  console.log(value.category_name);
                    html+='<option value="'+value.id+'">'+value.category_name+'</option>';
                    
                });
                

                $("#inputSubParent").html(html);

                
              }
              else{
                
                
               
              }

          }
        });
}
$("#inputSubParent").change('on',function(){
    $("#tags_id").show();
});
function get_sub_sub_parent(){
  var id = $("#inputSubParent").val();
  $("#parent_id_confirm").val(id);
}

// function get_tags(){
//   var class_name = $("#inputParent option:selected").attr('class').toString();
//   console.log(class_name);
//   if(class_name === "lavel-0")
//   {
//     $("#tags_id").show();
//   }
//   else{
//     $("#tags_id").hide();
//   }
// }
function select_tags(id){
  if($("#tag_id_"+id).hasClass('selected'))
  {
      $("#tag_id_"+id).removeClass('selected');
      $("#selected_tags_"+id).attr('checked',false);
  }
  else
  {
    $("#tag_id_"+id).addClass('selected');
    $("#selected_tags_"+id).attr('checked',true);
    
  }
}
</script>
