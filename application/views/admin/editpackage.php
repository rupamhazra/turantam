<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Package</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Package </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-package/".$package['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
						        <div class="item form-group">
                        <label class="col-md-12" for="title">Service</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputService" id="inputService" class="form-control col-md-7 col-xs-12">
                                <?php if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  foreach($parentList as $row){ 
                                    if($row['id'] == $package['service_id'])
                                        $selected = 'selected';
                                    else $selected = '';
                                    
                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="edit" id="edit" value="1";>
                    
    					     <div class="item form-group">
                            <label class="col-md-12" for="title">Name</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputName" id="inputName" class="form-control cForm" value="<?php echo $package['name']; ?>">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Slug</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputSlug" id="inputSlug" class="form-control" readonly value="<?php echo $package['slug']; ?>">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Descrption</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea class="form-control" name="inputDescription" id="inputDescription">
                                    <?php echo !empty($package['description'])? $package['description']:''; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Price</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="inputPrice" id="inputPrice" value="<?php echo $package['price']; ?>">
                               
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Discounted Price</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="inputDiscountedPrice" id="inputDiscountedPrice" value="<?php echo $package['discounted_price']; ?>">
                            </div>
                        </div>
    					<div class="item form-group">
                        <label class="col-md-12 col-sm-12 col-xs-12" for="title">Image </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4">
                                <input type="file" name="inputImage" class="form-control">
                           </div>
                           <div class="col-md-8 col-sm-9 col-xs-12">
                            <?php if(!empty($package['image_small'])) {?>
                            <img src="<?php echo base_url('uploads/').$package['image_small']; ?>" height="40"/>
                            <?php }else{ ?>
                                 <img src="<?php echo base_url('assets/img/no_image.png'); ?>" height="40"/>
                            <?php } ?>
                        </div>
                        </div>
                        
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button id="addBtn" type="submit" class="btn btn-success">Save</button>
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