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
            <h3>Cashback</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Cashback</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/add-cashback/", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                            <input type="hidden" name="cashback" id="cashback" value="1";>
                        <div class="item form-group">
                            <label class="col-md-12 col-sm-12 col-xs-12" for="title">Portal <span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="inputPortal" id="inputPortal" class="form-control col-md-7 col-xs-12">
                                    <option value="0">No Portal</option>
                                    <?php if(count($masterCashBackPortalList)>0){
                                      //pre($masterCashBackPortalList,1);
                                      $option = '';
                                      foreach($masterCashBackPortalList as $row){ 
                                        $option .= '<option class="lavel-0" value="'.$row['id'].'">'.$row['name'].'</option>';
                                       

                                        ?>
                                    <?php }?>
                                        <?php echo $option; ?>
                                  <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12 col-sm-12 col-xs-12" for="title">Portal Type <span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="inputPortalType" id="inputPortalType" class="form-control col-md-7 col-xs-12">
                                    <option value="0">No Type</option>
                                    <?php if(count($masterCashBackTypeList)>0){
                                      //pre($masterCashBackTypeList,1);
                                      $option = '';
                                      foreach($masterCashBackTypeList as $row){ 
                                        $option .= '<option class="lavel-0" value="'.$row['id'].'">'.$row['name'].'</option>';
                                        if(isset($row['sub_category_details'])){
                                            foreach($row['sub_category_details'] as $row_s){
                                            $option .= '<option class="lavel-1" value="'.$row_s['id'].'">&nbsp;&nbsp;&nbsp;'.$row_s['name'].'</option>';
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
                            <label class="col-md-12 col-sm-12 col-xs-12" for="title">Store <span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="inputStore" id="inputStore" class="form-control col-md-7 col-xs-12">
                                    <option value="0">No Store</option>
                                    <?php if(count($masterStoreList)>0){
                                      //pre($masterStoreList,1);
                                      $option = '';
                                      foreach($masterStoreList as $row){ 
                                        $option .= '<option class="lavel-0" value="'.$row['id'].'">'.$row['name'].'</option>';
                                        if(isset($row['sub_category_details'])){
                                            foreach($row['sub_category_details'] as $row_s){
                                            $option .= '<option class="lavel-1" value="'.$row_s['id'].'">&nbsp;&nbsp;&nbsp;'.$row_s['name'].'</option>';
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
                            <label class="col-md-12" for="title">Base Rate</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputBaseRate" id="inputBaseRate" class="form-control cForm" value="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Bonus Rate</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="text" name="inputBonusRate" id="inputBonusRate" class="form-control cForm" value="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12 col-sm-12 col-xs-12" for="title">Rate Type<span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="inputRateType" id="inputRateType" class="form-control col-md-7 col-xs-12">
                                    <option value="0">No Rate Type</option>
                                    <option value="1">%</option>
                                    <option value="2">$</option>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-md-12" for="title">Description</label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           
                            <button id="addmasterStoreBtn" type="submit" class="btn btn-success">Save</button>
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
$('#inputmasterStore').on('keyup keypress blur', function() 
{
    var myStr = $(this).val();
        myStr=myStr.toLowerCase();
        myStr=myStr.replace(/ /g,"-");
        myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
        myStr=myStr.replace(/\.+/g, "-");


    $('#inputCardUrl').val(myStr); 
});
            

$("#addmasterStoreBtn").on("click",function(e){
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