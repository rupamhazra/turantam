<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>State</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit State</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-state/".$state['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <input type="hidden" name="edit" id="edit" value="1">
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Country</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="inputCountry" id="inputCountry" class="form-control col-md-7 col-xs-12">
                                <?php
                                 if(count($countryList)>0){
                                  //pre($countryList,1);
                                  $option = '';
                                  foreach($countryList as $row){ 
                                    if($state['country_id'] == $row['id'])
                                        $selected = 'selected';
                                    else $selected = '';
                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['country_name'].'</option>';
                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputName" id="inputName" class="form-control cForm" value="<?php echo $state['state_name']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Code</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputCode" id="inputCode" class="form-control" value="<?php echo $state['state_code']; ?>">
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