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
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Cashback Portal</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Cashback Portal </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-master-cashback-portal/".$masterCashBackPortal['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <input type="hidden" name="masterCashBackPortal" id="masterCashBackPortal" value="1";>
                    
    					<div class="item form-group">
                            <label class="col-md-12" for="title">Title</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputmasterCashBackPortal" id="inputmasterCashBackPortal" class="form-control cForm" value="<?php echo $masterCashBackPortal['name']; ?>">
                            </div>
                        </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           
                            <button id="addmasterCashBackPortalBtn" type="submit" class="btn btn-success">Save</button>
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
$('#inputmasterCashBackPortal').on('keyup keypress blur', function() 
{
	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputCardUrl').val(myStr); 
});
            

$("#addmasterCashBackPortalBtn").on("click",function(e){
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