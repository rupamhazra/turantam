<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}
span.selected{
  background: #1ABB9C !important;
}

.tag:after{
  content: none;
}
span.tag{
  padding: 10px 12px;
  cursor: pointer;
  background-color: gray;
}
.tagsinput span.tag a{
      font-size: 18px;
}
</style>
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
                    <h2>Edit Service Category</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-service-category/".$serviceCategory['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                   
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Parent <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="inputParent" id="inputParent" class="form-control col-md-7 col-xs-12">
                                <option value="0">No Parent</option>
                                <?php if(count($parentList)>0){
                                  //pre($parentList,1);
                                  $option = '';
                                  $selected = '';
                                  foreach($parentList as $row){ 
                                    if($serviceCategory['parent_id'] == $row['id']){
                                      echo $serviceCategory['parent_id'].'=='.$row['id'];
                                      $selected = ' selected';
                                      //die;
                                    }else{
                                      $selected ='';
                                    }

                                    $option .= '<option class="lavel-0" value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';

                                    if(isset($row['sub_category_details'])){
                                       
                                        foreach($row['sub_category_details'] as $row_s){
                                          if($serviceCategory['parent_id'] == $row_s['id']){
                                            
                                             echo $serviceCategory['parent_id'].'=='.$row_s['id'];
                                            $selected = ' selected';
                                            //die;
                                          }else{
                                      $selected ='';
                                    }
                                        $option .= '<option class="lavel-1" value="'.$row_s['id'].'"'.$selected.'>&nbsp;&nbsp;&nbsp;'.$row_s['name'].'</option>';
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
                            <select name="inputSubParent" class="form-control col-md-7 col-xs-12">
                                <option value="0">No Sub Parent</option>
                                
                            </select>
                        </div>
                    </div> -->
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="inputName" class="form-control col-md-7 col-xs-12 cForm"  name="inputName" placeholder="Enter Name" type="text" value="<?php echo $serviceCategory['name']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Url <span class="required" placeholder="Enter Url">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="inputUrl" name="inputUrl" class="form-control col-md-7 col-xs-12" value="<?php echo $serviceCategory['slug']; ?>" readonly>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Decsription <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control cForm" name="description" id="description"><?php echo $serviceCategory['description']; ?></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Image </label>
                        <div class="col-md-3 col-sm-9 col-xs-12">
                           <input type="file" name="inputImage" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-9 col-xs-12">
                            <?php if(!empty($serviceCategory['image_small'])) {?>
                            <img src="<?php echo base_url('uploads/').$serviceCategory['image_small']; ?>" height="40"/>
                            <?php }else{ ?>
                                 <img src="<?php echo base_url('assets/img/no_image.png'); ?>" height="40"/>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary" onclick="history.back();">Back</button>
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
  }else{
     // $("span .selected").each(function() {
     //      alert($(this).val());

     //  });
     // $("#selected_tags").val();
  }


		});

</script>
<script type="text/javascript">
  var url = '<?php echo base_url() ?>';
</script>
