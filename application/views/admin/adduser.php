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
        <div class="title_left">
            <h3>User</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add User </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/add-user", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>  
                   
                   
                    <p><?php
                        echo $this->session->flashdata('msg');
                        ?></p>
                    <input type="hidden" name="userAdd" id="userAdd" value="1">
                    
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputName" id="inputName" class="form-control cForm">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Email</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputEmail" id="inputEmail" class="form-control cForm">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Phone</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputPhone" id="inputPhone" class="form-control cForm">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Password</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="inputPassword" id="inputPassword" class="form-control cForm">
                        </div>
                    </div>
                    <div class="item form-group">
                            <label class="col-md-12" for="title">Profile Image </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                               <input type="file" name="inputProfileImage" id="inputProfileImage" class="form-control">
                            </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">
                           <input type="checkbox" class="big-checkbox" name="is_admin" id="is_admin"  value="1">
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