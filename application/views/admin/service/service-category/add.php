<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Service</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Service Category</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/save-service-category", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="parent_id_confirm" id="parent_id_confirm" value="">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Parent <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="hidden" name="parent_slug" id="parent_slug" value="">
                            <select name="inputParent" id="inputParent" class="form-control col-md-7 col-xs-12" onChange="setCatSlug()">
                                <option value="0">No Parent</option>
                                <?php if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  foreach($parentList as $row){ 
                                    $option .= '<option class="lavel-0" slug="'.$row['slug'].'" value="'.$row['id'].'">'.$row['name'].'</option>';
                                    if(isset($row['sub_category_details'])){
                                        foreach($row['sub_category_details'] as $row_s){
                                        $option .= '<option class="lavel-1" slug="'.$row_s['slug'].'" value="'.$row_s['id'].'">&nbsp;&nbsp;&nbsp;'.$row_s['name'].'</option>';
                                      }
                                    }

                                    ?>
                                <?php }?>
                                    <?php echo $option; ?>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
					<!-- <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Sub Parent <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputSubParent" id="inputSubParent" class="form-control col-md-7 col-xs-12" onchange="get_sub_sub_parent();">
								<option value="0">No Sub Parent</option>
								
							</select>
                        </div>
                    </div> -->
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="inputName" class="form-control col-md-7 col-xs-12 cForm"  name="inputName" placeholder="Enter Name" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Url <span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="inputUrl" name="inputUrl" class="form-control col-md-7 col-xs-12" readonly>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Decsription <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control cForm" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Image </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="file" name="inputImage" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Location <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?php if($locationList>0) {
                              foreach ($locationList as $row) {
                            ?>
                            <label class="checkbox-inline">
                            <input type="checkbox" name="inputLocation[]" id="inputLocation_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" required><?php echo $row['name'] ?>
                            </label>
                            
                            <?php }}?>
                        </div>
                    </div>
                    <!-- <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Template View<span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputTemplateView" class="form-control col-md-7 col-xs-12">
                                <option value="Default List View">Default List View</option>
                                <option value="Card List View">Card List View</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
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
<script type="text/javascript">
var url = '<?php echo base_url() ?>';  
setCatSlug();
function setCatSlug(){
  var parent_slug = $("#inputParent option:selected").attr('slug');
  $("#parent_slug").val(parent_slug);
}
</script>
