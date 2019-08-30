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
<script src="<?php echo base_url('assets/admin/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
 <script>
  tinymce.init({
    selector: '#inputContent',
    plugins: "code,preview,image imagetools media",
    valid_children : "+body[style]"
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
            <h3>Mail Template</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Template</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/add-template", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            &nbsp;
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <strong><?php echo $this->session->flashdata('msg'); ?></strong>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Template Code
                        </label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input id="template_code" class="form-control col-md-7 col-xs-12 cForm"  name="template_code" placeholder="" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="url">Subject
                        </label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input type="text" id="subject" name="subject" class="form-control col-md-7 col-xs-12 cForm">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="title">Content
                        </label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <textarea id="inputContent" rows="20" class="form-control col-md-7 col-xs-12" name="content"></textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-2">
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
<style type="text/css">
.fileUpload {
        position: relative;
        overflow: hidden;
        margin-right: 3px;
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
</style>
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
