<style type="text/css">

.errorClass {
	border:1px solid red !important;
}

.input{	
}
.input-wide{
	width: 500px;
}

</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Mail Configuration</h3>
        </div>


    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               

                <div class="x_content">

                    <?php
                    echo form_open_multipart(base_url() . "admin/mail-config", array("class" => "form-horizontal form-label-left", "name" => "Login_Form"));
                    ?>
                    <p><?php echo $this->session->flashdata('msg');?></p>
                    <?php   $mail = json_decode($config['settings_v']); //pre($mail,1); ?>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Mail From Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="mail_from_name" id="mail_from_name" class="form-control cForm" value="<?php echo !empty($mail->mail_from_name)? $mail->mail_from_name:''; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Mail From Email</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="mail_from_email" id="mail_from_email" class="form-control cForm" value="<?php echo !empty($mail->mail_from_email)? $mail->mail_from_email:''; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Username</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="username" id="username" class="form-control cForm" value="<?php echo !empty($mail->username)? $mail->username:''; ?>">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Host</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="host" id="host" class="form-control cForm" value="<?php echo !empty($mail->host)? $mail->host:''; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-md-12" for="title">Port</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="text" name="port" id="port" class="form-control cForm"  value="<?php echo !empty($mail->port)? $mail->port:''; ?>">
                        </div>
                    </div>
                    <div class="item form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="checkbox-inline">
                               <input type="checkbox" name="ssl_tls" id="ssl_tls" class="cForm big-checkbox" value="1" style="margin-top:2px;" <?php echo !empty($mail->ssl_tls)? ($mail->ssl_tls == 1) ? 'checked':'' :''; ?>> SSL / TLS
                            </label>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="col-md-12" for="title">Password</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <input type="password" name="password" id="password" class="form-control cForm" value="<?php echo !empty($mail->password)? $mail->password:''; ?>">
                        </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <button id="addBlogBtn" type="submit" class="btn btn-success">Save</button>
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
</style>
    <script>
            $('#inputBlogTitle').on('keyup keypress blur', function() 
{  

	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputBlogUrl').val(myStr); 
});
            

$("#addBlogBtn").on("click",function(e){
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
				