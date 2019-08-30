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
</style>
<script src="<?php echo base_url('assets/tinymce/tinymce.min.js'); ?>"></script>
  <script>
tinymice_show('#inputContent');
function tinymice_show(selector_val){
  tinymce.init({
    selector: selector_val,
    plugins: "advlist autolink link image lists charmap print preview",
    images_upload_url : '<?php echo base_url(); ?>'+'admin/tinymice-image-upload/',
    automatic_uploads : false,
    images_upload_handler : function(blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '<?php echo base_url(); ?>admin/tinymice-image-upload/');

        xhr.onload = function() {
            var json;

            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.file_path);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
    
  });
 }
  </script>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Comment</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Comment </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-comment/".$comment['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    
                    
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
						<input type="hidden" name="editComment" value="1">
						<div class="item form-group">
                        <label class="col-md-12" for="title">Author </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <select name="user_id" class="form-control col-md-7 col-xs-12">
								<?php foreach($userList as $row){ ?>
									<option value="<?php echo $row['id'];?>" <?php if($comment['user_id']==$row['id']) echo 'selected="selected"'; ?>><?php echo $row['name']; ?></option>
								<?php } ?>
						   </select>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Comment</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <textarea class="form-control cForm" rows="3" name="title" id="title"><?php echo $comment['title'];?>
                            </textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Status</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="is_approved">
                            <option value="0" <?php echo ($comment['is_approved']==0)? 'selected':'';?>>Pending</option>
                            <option value="1" <?php echo ($comment['is_approved']==1)? 'selected':'';?>>Approved</option>
                            <option value="2" <?php echo ($comment['is_approved']==2)? 'selected':'';?>>Reject</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           
                            <button id="addCardBtn" type="submit" class="btn btn-success">Update</button>
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



            $('#inputCardTitle').on('keyup keypress blur', function() 
{  

	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputCardUrl').val(myStr); 
});
            

$("#addCardBtn").on("click",function(e){
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

</script>   