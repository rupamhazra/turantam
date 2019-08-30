<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}
span.selected{
  background: #1ABB9C !important;
}

.tag:after{
  content: none;
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
                    <h2>Edit Blog Category</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-blog-category/".$blogCategory['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                   
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Parent <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputParent" id="inputParent" class="form-control col-md-7 col-xs-12">
                                <option value="0">No Parent</option>
                                <?php if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  $selected = '';
                                  foreach($parentList as $row){ 
                                    if($blogCategory['parent_id'] == $row['id']){
                                      echo $blogCategory['parent_id'].'=='.$row['id'];
                                      $selected = ' selected';
                                      //die;
                                    }else{
                                      $selected ='';
                                    }

                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['category_name'].'</option>';

                                    if(isset($row['sub_category_details'])){
                                       
                                        foreach($row['sub_category_details'] as $row_s){
                                          if($blogCategory['parent_id'] == $row_s['id']){
                                            
                                             echo $blogCategory['parent_id'].'=='.$row_s['id'];
                                            $selected = ' selected';
                                            //die;
                                          }else{
                                      $selected ='';
                                    }
                                        $option .= '<option class="lavel-1" value="'.$row_s['id'].'"'.$selected.'>&nbsp;&nbsp;&nbsp;'.$row_s['category_name'].'</option>';
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
                            <select name="inputSubParent" class="form-control col-md-7 col-xs-12">
                                <option value="0">No Sub Parent</option>
                                
                            </select>
                        </div>
                    </div> -->
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="inputName" class="form-control col-md-7 col-xs-12 cForm"  name="inputName" placeholder="Enter Name" type="text" value="<?php echo $blogCategory['category_name']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Url <span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="inputUrl" name="inputUrl" class="form-control col-md-7 col-xs-12" value="<?php echo $blogCategory['category_url']; ?>" readonly>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Decsription <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control cForm" name="description" id="description"><?php echo $blogCategory['description']; ?></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Image </label>
                        <div class="col-md-3 col-sm-9 col-xs-12">
                           <input type="file" name="inputImage" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-9 col-xs-12">
                            <?php if(!empty($blogCategory['image'])) {?>
                            <img src="<?php echo base_url('uploads/').$blogCategory['image']; ?>" height="40"/>
                            <?php }else{ ?>
                                 <img src="<?php echo base_url('assets/img/no_image.png'); ?>" height="40"/>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Template View<span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputTemplateView" class="form-control col-md-7 col-xs-12">
                                <option value="Default List View" <?php if(!empty($blogCategory['template_view']) && $blogCategory['template_view'] == 'Default List View') echo "selected"; ?>>Default List View</option>
                                <option value="Card List View" <?php if(!empty($blogCategory['template_view']) && $blogCategory['template_view'] == 'Card List View') echo "selected"; ?>>Card List View</option>
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
                                $selected = $checked = '';
                                if($blogCategory['tags_ids']!=''){
                                  
                                  $tags = json_decode($blogCategory['tags_ids']);
                                  if(in_array($row['id'],$tags)){
                                    $selected = 'selected';
                                    $checked = 'checked';
                                  }else {
                                    $selected = $checked ='';
                                  }
                                }
                            ?>
                            <input type="checkbox" name="selected_tags[]" id="selected_tags_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" style="display: none;" <?php echo $checked; ?>>
                            <span class="tag <?php echo $selected; ?>" id="tag_id_<?php echo $row['id']; ?>" onclick="select_tags(<?php echo $row['id']; ?>);">
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



                    <!-- <div class="item form-group" id="tags_id">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Tags<span class="required" placeholder="Enter Url"></span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div>
                          <div id="tags_1_tagsinput1" class="tagsinput" style="width: auto; min-height: 250px; height: 250px;">
                          <?php if(count($tagsList)>0){ 
                        foreach($tagsList as $key => $row){
                          $selected = $checked = '';
                          if($blogCategory['tags_ids']!=''){
                            
                            $tags = json_decode($blogCategory['tags_ids']);
                            if(in_array($row['id'],$tags)){
                              $selected = 'selected';
                              $checked = 'checked';
                            }else {
                              $selected = $checked ='';
                            }
                          }
                        ?>
                        <input type="checkbox" name="selected_tags[]" id="selected_tags_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" style="display: none;" <?php echo $checked; ?>>
                        <span class="tag <?php echo $selected; ?>" id="tag_id_<?php echo $row['id']; ?>" onclick="select_tags(<?php echo $row['id']; ?>);">
                          <span id="fullname_<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                          </span>
                        </span>

                         <?php }}?>
                          </div>
                        </div>
                        </div>
                    </div> -->
                    

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary" onclick="history.back();">Back</button>
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
  }else{
     // $("span .selected").each(function() {
     //      alert($(this).val());

     //  });
     // $("#selected_tags").val();
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
var url = '<?php echo base_url() ?>';
var catgory_parent_id = '<?php echo $blogCategory["parent_id"]?>';
//console.log(catgory_parent_id)
//get_sub_category(catgory_parent_id); 
function get_sub_category(){
    var html = '<option value="0">No Sub Parent</option>';
    var id = $("#inputParent").val();
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
