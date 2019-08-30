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
<script src="<?php echo base_url('assets/tinymce/tinymce.min.js'); ?>"></script>
  <script>
tinymice_show('#inputContent');
function tinymice_show(selector_val){
  tinymce.init({
    selector: selector_val,
    plugins: "advlist autolink link image lists charmap print preview",
    images_upload_url : '<?php echo base_url(); ?>'+'admin/tinymice-image-upload/',
    automatic_uploads : false,
    images_upload_handler : function(blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '<?php echo base_url(); ?>admin/tinymice-image-upload/');

        xhr.onload = function() {
            var json;

            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.file_path);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
    
  });
 }
  </script>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Card</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Card </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-card/".$card['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                    
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
						<input type="hidden" name="editCard" value="1">
						<div class="item form-group">
                        <label class="col-md-12" for="title">Card </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <select name="inputCardCategory" class="form-control col-md-7 col-xs-12" onChange="template_view_change(this.options[this.selectedIndex].getAttribute('template_view'));">
								<?php foreach($cardCategoryList as $row){ ?>
									<option value="<?php echo $row['id'];?>" <?php if($card['card_category_id']==$row['id']) echo 'selected="selected"'; ?> template_view ='<?php echo $row['template_view']; ?>'><?php echo $row['category_name']; ?></option>
								<?php } ?>
						   </select>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Card Title </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputCardTitle" id="inputCardTitle" class="form-control cForm" value="<?php echo $card['card_title'];?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Card Excerpt </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea class="form-control cForm" rows="3" name="inputExcerpt" id="inputExcerpt"><?php echo $card['card_excerpt'];?>
                            </textarea>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Card Url </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputCardUrl" id="inputCardUrl" class="form-control cForm" value="<?php echo $card['card_url'];?>">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Large Image </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="file" name="inputLargeImage" class="form-control">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Image alt </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputImageAlt" class="form-control" value="<?php echo $card['card_image_alt'];?>">
                        </div>
                    </div>
                    
					<div class="item form-group">
                        <label class="col-md-12" for="title">Content </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
						<input type="hidden" name="cardAdd" value="1">
                           <textarea name="inputContent" id="inputContent" style="width:100%; min-height:280px;"><?php echo $card['card_content'];?></textarea>
                        </div>
                    </div>
                    <div id="template_card_list_view" style="display: none;">

                    <div class="item form-group field_wrapper">
                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                        <a href="javascript:void(0);" class="add_button form-control btn btn-link" title="Add field">+ Add More</a>
                        </div>
                        <?php if(!empty($card['custom_fields'])) {?>
                        <?php
                            $custom_field_details = json_decode($card['custom_fields']);
                            //pre($product_details,1);
                            foreach ($custom_field_details as $key => $value) {
                                # code...
                                $value = explode('=',$value);
                        ?>
                        <div class="dy_div mb-15 row">
                            <div class="col-md-12">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                   <label>Label</label>
                                   <textarea name="field_name_1[]" id="" class="form-control" rows="1"><?php echo $value[0]; ?></textarea>
                                </div>
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label>Value</label>
                                   <textarea name="field_name_2[]" id="" class="form-control" rows="1"><?php echo $value[1]; ?></textarea>
                                </div>
                                <?php if($key > 0) {?>
                                <div class="col-md-2 col-sm-12 col-xs-12"><a href="javascript:void(0);" class="remove_button btn btn-link">Remove</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }}else{ ?>
                            <div class="dy_div mb-15 row">
                            <div class="col-md-12">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                   <label>Label</label>
                                   <textarea name="field_name_1[]" id="" class="form-control" rows="1"></textarea>
                                </div>
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label>Value</label>
                                   <textarea name="field_name_2[]" id="" class="form-control" rows="1">></textarea>
                                </div>
                                
                            </div>
                        </div>
                    <?php }?>
                    </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           
                            <button id="addCardBtn" type="submit" class="btn btn-success">Update</button>
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
var g_view = '<?php echo $card['template_view']; ?>';
template_view_change(g_view)
function template_view_change(view)
{
    //alert(view);
    console.log(view)
    if(view == "Card List View"){
    tinymice_show('#inputContent');
    $("#template_card_list_view").show();
    //$("#template_view").val('card_list_view');

    }else{
    tinymice_show('#inputContent');
    $("#template_card_list_view").hide();
    //$("#template_view").val('default_list_view');

    }
}
            $('#inputCardTitle').on('keyup keypress blur', function() 
{  

	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputCardUrl').val(myStr); 
});
            

$("#addCardBtn").on("click",function(e){
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
<script>
    $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html 
    var fieldHTML = '<div class="dy_div mb-15 row"><div class="col-md-12"><div class="col-md-5 col-sm-12 col-xs-12"><textarea name="field_name_1[]" id="" class="form-control" rows="1"></textarea></div><div class="col-md-5 col-sm-12 col-xs-12"><textarea name="field_name_2[]" id="" class="form-control" rows="1"></textarea></div><div class="col-md-2 col-sm-12 col-xs-12"><a href="javascript:void(0);" class="remove_button btn btn-link">Remove</a></div></div></div>';
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