<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Gallery</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Gallery Image</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-gallery/".$gallery['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <input type="hidden" name="edit" id="edit" value="1">
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputName" id="inputName" class="form-control cForm" value="<?php echo $gallery['name']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Image </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="file" id="inputImage" class="form-control" name="inputImage">
                            
                        </div>
                    </div>
                </div>
                     <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="item form-group">
                        <!-- <label class="col-md-12" for="title">Banner Image </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="file" id="inputImage" class="form-control" name="inputImage">
                            
                        </div> -->
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                            <?php if(!empty($gallery['image_large'])) {?>
                            <img src="<?php echo base_url('uploads/').$gallery['image_large']; ?>" height="155" width="400"/>
                            <?php }else{ ?>
                                 <img src="<?php echo base_url('assets/img/no_image.png'); ?>" height="155" width="400"/>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                    <div class="clearfix"></div>
                <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addBtn" type="submit" class="btn btn-success">Save</button>
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
$('#inputName').on('keyup keypress blur', function() 
{
    var myStr = $(this).val();
        myStr=myStr.toLowerCase();
        myStr=myStr.replace(/ /g,"-");
        myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
        myStr=myStr.replace(/\.+/g, "-");


    $('#inputSlug').val(myStr); 
});
            

$("#addBtn").on("click",function(e){
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