
<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}
.mb-15{
    margin-bottom: 15px;
}
.mb-30{
    margin-bottom: 30px;
}
hr{
    margin-bottom: 0px;
    margin-top: 10px;
}
.big-checkbox {width: 16px; height: 16px;}
</style>
<script src="<?php echo base_url('assets/admin/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
 <script>
  tinymce.init({
    selector: '#inputContent',
    plugins: "code,preview,image imagetools media",
    media_live_embeds: true,
    //toolbar : 'undo redo | link image | code',
         // add custom filepicker only to Image dialog
  //file_picker_types: 'image',
  // file_picker_callback: function(cb, value, meta) {
  //   var input = document.createElement('input');
  //   input.setAttribute('type', 'file');
  //   input.setAttribute('accept', 'image/*');

  //   input.onchange = function() {
  //     var file = this.files[0];
  //     var reader = new FileReader();
      
  //     reader.onload = function () {

  //       var id = 'blobid' + (new Date()).getTime();
  //       var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
  //       var base64 = reader.result.split(',')[1];
  //       var blobInfo = blobCache.create(id, file, base64);
  //       blobCache.add(blobInfo);

  //       // call the callback and populate the Title field with the file name
  //       cb(blobInfo.blobUri(), { title: file.name });
  //     };
  //     reader.readAsDataURL(file);
  //   };
    
  //   input.click();
  // }
    
  });
 //console.log('sssversion:'+tinyMCE.majorVersion + '.' + tinyMCE.minorVersion);
  </script>
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
                    <h2>Edit Blog </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-blog/".$blog['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="template_view" id="template_view" value="<?php echo str_replace(' ','_',strtolower($blog['template_view'])); ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
						<input type="hidden" name="editBlog" value="1">
						<div class="item form-group">
                        <label class="col-md-12" for="title">Blog Category</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputBlogCategory" id="inputBlogCategory" class="form-control col-md-7 col-xs-12" onchange="change_fields_config()">
                               
                                <?php if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  $selected = '';
                                  foreach($parentList as $row){ 
                                    if($blog['blog_category_id'] == $row['id']){
                                      echo $blog['blog_category_id'].'=='.$row['id'];
                                      $selected = ' selected';
                                      //die;
                                    }else{
                                      $selected ='';
                                    }

                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['category_name'].'</option>';

                                    if(isset($row['sub_category_details'])){
                                       
                                        foreach($row['sub_category_details'] as $row_s){
                                          if($blog['blog_category_id'] == $row_s['id']){
                                            
                                             echo $blog['blog_category_id'].'=='.$row_s['id'];
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
					<div class="item form-group">
                        <label class="col-md-12" for="title">Blog Title </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputBlogTitle" id="inputBlogTitle" class="form-control cForm" value="<?php echo $blog['blog_title'];?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Blog Excerpt </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea class="form-control cForm" rows="3" name="inputExcerpt" id="inputExcerpt"><?php echo $blog['blog_excerpt'];?>
                            </textarea>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Blog Url </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputBlogUrl" id="inputBlogUrl" class="form-control" value="<?php echo $blog['blog_url'];?>" readonly>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Large Image </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="file" name="inputLargeImage" class="form-control">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Image alt </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputImageAlt" class="form-control" value="<?php echo $blog['blog_image_alt'];?>">
                        </div>
                    </div>
                    
					<div class="item form-group mb-30">
                        <label class="col-md-12" for="title">Content </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
						<input type="hidden" name="blogAdd" value="1">
                           <textarea name="inputContent" id="inputContent" style="width:100%; min-height:280px;"><?php echo $blog['blog_content'];?></textarea>
                        </div>
                    </div>
                    
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Apply Now Button</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="radio-inline"><input type="radio" value="1" name="inputApplyNowButton" class="apply_button" <?php echo ($blog['apply_button']=='1')? 'checked':''; ?>>Yes</label>
                            <label class="radio-inline"><input type="radio" name="inputApplyNowButton" class="apply_button" value="0" <?php echo ($blog['apply_button']=='0')? 'checked':''; ?>>No</label>
                        </div>
                    </div>
                    <div class="item form-group" id="link_div" style="display: none;">
                        <label class="col-md-12" for="title">Link</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="inputApplyNowButtonLink" class="form-control">
                        </div>
                    </div>
                    

                    <div class="item form-group" style="display: none;">
                        <label class="col-md-12" for="title">Deals Validity</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                  <input type="text" name="reservation-time" id="reservation-time" class="form-control" value="<?php echo !empty($blog['deals_start_datetime'])? $blog['deals_start_datetime'].' - '.$blog['deals_end_datetime']: '01-01-2016 - 01-25-2016'?>" />
                                </div>
                              </div>
                            </div>
                          </fieldset>
                        </div>
                    </div>
                    
                    

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           
                            <button id="addBlogBtn" type="submit" class="btn btn-success">Update</button>
							 <button type="button" class="btn btn-primary" onclick="history.back();">Back</button>
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
$('#inputBlogTitle').on('keyup keypress blur', function() 
{  

	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputBlogUrl').val(myStr); 
});
            

$("#addBlogBtn").on("click",function(e){
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
<script>
$(".apply_button").on('change',function(){
    if(this.value == '0')
        $("#link_div").hide();
    else
        $("#link_div").show();
});

function change_fields_config(){
    var category_id = $("#inputBlogCategory").val();
    var category_text = $("#inputBlogCategory option:selected").text();
    if(category_text == 'Deals'){

    }else{

    }
}
</script>   

