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
                    <h2>Add Blog </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/blog-add", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="template_view" id="template_view" value="default_list_view">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
						<div class="item form-group">
                        <label class="col-md-12" for="title">Blog Category </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputBlogCategory" id="inputBlogCategory" class="form-control col-md-7 col-xs-12">
                               
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
                    <input type="hidden" name="blogAdd" id="blogAdd" value="1";>
                    
    					<div class="item form-group">
                            <label class="col-md-12" for="title">Blog Title </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputBlogTitle" id="inputBlogTitle" class="form-control cForm">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Blog Excerpt </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea class="form-control cForm" rows="3" name="inputExcerpt" id="inputExcerpt">
                                </textarea>
                            </div>
                        </div>
    					<div class="item form-group">
                            <label class="col-md-12" for="title">Blog Url </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputBlogUrl" id="inputBlogUrl" class="form-control" readonly>
                            </div>
                        </div>
    					<div class="item form-group">
                            <label class="col-md-12" for="title">Large Image </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="file" name="inputLargeImage" class="form-control cForm">
                            </div>
                        </div>
    					<div class="item form-group">
                            <label class="col-md-12" for="title">Image alt </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputImageAlt" class="form-control cForm">
                            </div>
                        </div>
    					<div class="item form-group mb-30">
                            <label class="col-md-12" for="title">Content </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
    						<input type="hidden" name="blogAdd" value="1">
                               <textarea name="inputContent" id="inputContent" style="width:100%; min-height:280px;"></textarea>
                            </div>
                        </div>
                        <div class="item form-group" id="tags_div">
                           <label class="col-md-12" for="title">Tags</label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                          
                          
                        
                        </div>
                        </div>
                      
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Apply Now Button</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="radio-inline"><input type="radio" value="1" name="inputApplyNowButton" class="apply_button">Yes</label>
                                <label class="radio-inline"><input type="radio" name="inputApplyNowButton" value="0" class="apply_button">No</label>
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
                           
                            <button id="addBlogBtn" type="submit" class="btn btn-success">Save</button>
							 <button type="submit" class="btn btn-primary" onclick="history.back();">Back</button>
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
    $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html 
    var fieldHTML = '<div class="dy_div mb-15 row"><div class="col-md-12"><div class="col-md-5 col-sm-12 col-xs-12"><textarea name="field_name_1[]" id="" class="form-control" rows="1"></textarea></div><div class="col-md-5 col-sm-12 col-xs-12"><textarea name="field_name_2[]" id="" class="form-control" rows="1"></textarea></div><div class="col-md-2 col-sm-12 col-xs-12"><a href="javascript:void(0);" class="remove_button btn btn-link">Remove</a></div></div></div>';
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
$(".apply_button").on('change',function(){
    if(this.value == '0')
        $("#link_div").hide();
    else
        $("#link_div").show();
});


</script>	