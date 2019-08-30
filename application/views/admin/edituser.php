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
.big-checkbox {width: 16px; height: 16px;}
</style>
<div class="">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">
             <h3>User </h3>
          </div>
          <div class="col-sm-10">
            
          </div>
        </div>
      </div>    
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit User </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/update-user/".$user['id'], array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                   
                   
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <input type="hidden" name="userEdit" id="userEdit" value="1">
                    
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputName" id="inputName" class="form-control cForm" value="<?php echo $user['name']; ?>">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Email</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputEmail" id="inputEmail" class="form-control cForm" value="<?php echo $user['email']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Phone</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputPhone" id="inputPhone" class="form-control cForm" value="<?php echo $user['contact']; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                            <label class="col-md-12" for="title">Profile Image </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" name="inputProfileImage" id="inputProfileImage" class="form-control">
                                
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php if(!empty($user['profile_image'])) {?>
                            <img src="<?php echo base_url('uploads/').$user['profile_image']; ?>"  width="50"/>
                            <?php } else{?>
                               <img src="<?php echo base_url('assets/img/no-profile-image.png'); ?>"  width="50" />
                      <?php }?>
                            </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">

                           <input type="checkbox" class="big-checkbox" name="is_admin" id="is_admin"  value="1" <?php echo ($user['is_admin'] == '1')?'checked':'';?>>
                       Is admin</label>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           
                            <button id="addCompanyBtn" type="submit" class="btn btn-success">Save</button>
							 <button type="submit" class="btn btn-primary" onclick="history.back();">Back</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="margin-bottom: 50px;">
                <div class="x_title">
                    <h2>Change Password</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <input type="hidden" name="userEdit" id="userEdit" value="1">
                    <div class="col-md-12">
                        <label class="col-md-2 control-label" style="text-align: right;" for="title">New Password : </label>
                        <div class="col-md-7">
                        <input type="password" name="inputPassword" id="inputPassword" class="form-control cForm1"><br/>
                        <div class="" id="alert" style="display: none;color:green;"></div>
                        </div>
                        <div class="col-md-3">
                             <button id="change_password" type="button" class="btn btn-success" onclick="change_password(<?php echo $user['id'];?>);">Change Password</button>
                        </div>
                    </div>
                    
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script>
$('#inputCompanyTitle').on('keyup keypress blur', function() 
{
	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputCardUrl').val(myStr); 
});
            

$("#addCompanyBtn").on("click",function(e){
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
function change_password(id){
    var proceedStep=true;
    $('.cForm1').each(function(){
       if(!$.trim($(this).val())){ 
        $(this).addClass('errorClass'); 
        proceedStep = false;
       }
    });
    if(proceedStep == true)
    {
        $("#change_password").text('Processing...');
        base_url = '<?php echo base_url();?>';
        console.log('change password');
        var password = $("#inputPassword").val();
        $.ajax({
            url : base_url+'admin/change-password',
            type : "post",
            data : {id: id, password: password},
            success : function(response){
                console.log(response);
                if(response!='')
                {
                    $("#change_password").text('Change Password');
                    $("#inputPassword").val('');
                    $("#alert").html('').html('<strong>!! Password changed successfully </strong>').show();
                }
            }
        });
    }
}
</script>