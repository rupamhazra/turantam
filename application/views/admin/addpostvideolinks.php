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
            <h3>Video Links</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-sm-10">
                        <h2>Add Links </h2>
                        </div>
                        <div class="col-sm-2">
                        <div class="col-md-2 col-sm-12 col-xs-12">   
                            <a href="javascript:void(0);" class="add_button form-control btn btn-link" title="Add field">+ Add More</a>
                        </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/add-post-video-links/".$post['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    <input type="hidden" name="addVideoLinks" id="addVideoLinks" value="1">
                    <?php echo $this->session->flashdata('msg');?>
                    
                    
					
					<div class="item form-group field_wrapper">
                       
                            <!-- <div class="col-md-5 col-sm-12 col-xs-12">
                               
                               <textarea name="field_name_1[]" id="" class="form-control cForm" rows="1"></textarea>
                            </div> -->
                            <?php if(!empty($post['video_links'])) {?>
                            <?php 
                                $video_links = json_decode($post['video_links']);
                                $count_video_links = count($video_links);
                                foreach ($video_links as $key => $value) {

                                    //$value = explode('=',$value);
                            ?>
                            <div class="dy_div row mb-15">
                           
                            <div class="col-md-10 col-sm-12 col-xs-12">
                             <input type="url" name="field_name[]" id="" class="form-control cForm" value="<?php echo $value; ?>">
                            </div>
                            <?php if($key>0) {?>
                            <div class="col-md-2 col-sm-12 col-xs-12"><a href="javascript:void(0);" class="remove_button btn btn-link">Remove</a></div>
                            <?php } ?>
                            <div class="clearfix" ></div>
                            </div>
 
                            <?php } } else{?>   
                            <div class="dy_div row mb-15"> 
                            <div class="col-md-10 col-sm-12 col-xs-12">
                               <input type="url" name="field_name[]" id="" class="form-control cForm">
                            </div>
                            
                            </div>
                            <?php } ?>
                            
                        </div>
                    </div>

                   <!--  <div class="item form-group">
                        <label class="col-md-12   col-sm-12 col-xs-12">Existing Parameters</label>
                       <?php if(!empty($post['video_links'])) {?>
                                <table class="table table-bordered">
                                    <tbody>
                                    <?php 
                                        $video_links = json_decode($post['video_links']);
                                        foreach ($video_links as $value) {
                                            //$value = explode('=',$value);
                                        ?>
                                      <tr>
                                        <td>
                                            <input type="url" name="field_name[]" id="" class="form-control cForm" value="<?php echo $value; ?>">
                                        </td>
                                      </tr>
                                    <?php } ?>
                             </tbody>
                              </table>
                        <?php } ?>
                    </div> -->
                    <div class="clearfix" ></div>
                   <div class="ln_solid"></div>
                    <div class="form-group" style="float: left">
                        <div class="col-md-12 col-md-offset-2">
                           
                            <button id="addBlogBtn" type="submit" class="btn btn-success">Save</button>
							 <!-- <button type="submit" class="btn btn-primary" onclick="history.back();">Back</button> -->
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
</style>
    <script>
    $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html 
    var fieldHTML = '<div class="dy_div row mb-15"><div class="col-md-10 col-sm-12 col-xs-12"><input type="text" name="field_name[]" id="" class="form-control cForm"></div><div class="col-md-2 col-sm-12 col-xs-12"><a href="javascript:void(0);" class="remove_button btn btn-link">Remove</a></div></div>';
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
				