<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('assets/dist/imageuploadify.min.css'); ?>" rel="stylesheet">
<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}

</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Other Images</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/add-post-other-images/".$post['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  

                    <?php echo !empty($this->session->flashdata('error'))? '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>':'';
                        ?>
                    <?php echo !empty($this->session->flashdata('success'))? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>':'';
                        ?>
						<input type="hidden" name="addImages" value="1">
					
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Images</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="file" id="file-input" name="other_images[]" multiple />
                        </div>
                          <div id="preview">
                          </div>
                            
                         
                          
                    </div>
                    <?php if(!empty($post['other_images'])) {
                                $other_images = json_decode($post['other_images']);
                                ?>
                        <div class="item form-group">
                        <label class="col-md-12" for="title">Existing Other Images</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <?php foreach($other_images as $other_image){ ?>
                              
                                
                              <img src="<?php echo base_url().'/uploads/blog_images/other_images/'.$other_image; ?>" class="imageThumb" alt=''>
                              
                            <?php } ?>
                              </div>
                              </div>
                            <?php } ?>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addBlogBtn" type="submit" class="btn btn-success">Update</button>
							 
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/dist/imageuploadify.min.js'); ?>"></script>
    <script>
            $('#postTitle').on('keyup keypress blur', function() 
{  

	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#postUrl').val(myStr); 
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
function setValue(val,id) {
      //alert(val);
        $("#uploadFile").val(val);
    }
    function clickFile(val_id) {
      //alert(count);
        $("#clickFile").click();
    }


  function previewImages() {

  var preview = document.querySelector('#preview');
  
  if (this.files) {
    [].forEach.call(this.files, readAndPreview);
  }

  function readAndPreview(file) {

    // Make sure `file.name` matches our extensions criteria
    if (!/\.(jpe?g|png)$/i.test(file.name)) {
      return alert(file.name + " is not an image");
    } // else...
    
    var reader = new FileReader();
    
    reader.addEventListener("load", function() {
      var image = new Image();
      image.height = 200;
      image.title  = file.name;
      image.src    = this.result;
      image.className = "imageThumb";
      
      preview.appendChild(image);
    }, false);
    
    reader.readAsDataURL(file);
    
  }

}

document.querySelector('#file-input').addEventListener("change", previewImages, false);
</script>
				<style type="text/css">
        .big-checkbox {width: 16px; height: 16px;}
.fileUpload {
        position: relative;
        overflow: hidden;
        margin-right: -1px;
        height:34px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

input[type="file"] {
  display: block;
}

.imageThumb {
  margin-top:10px; 
  max-height: 170px;
  border: 1px solid;
  padding: 5px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
</style>