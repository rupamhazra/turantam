<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Package Entity Value</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Package Entity Value</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/add-package-entity-value", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
						        <div class="item form-group">
                        <label class="col-md-12" for="title">Package Entity</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputPackageEntity" id="inputPackageEntity" class="form-control col-md-7 col-xs-12">
                                <?php
                                
                                 if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  foreach($parentList as $row){ 
                                    $option .= '<option class="lavel-0" value="'.$row['id'].'">'.$row['name'].'</option>';
                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="add" id="add" value="1">
                    
    					     <div class="item form-group">
                            <label class="col-md-12" for="title">Value</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputValue" id="inputValue" class="form-control cForm">
                            </div>
                        </div>
                        
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