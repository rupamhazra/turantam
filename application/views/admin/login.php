<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin | Turantam</title>

        <!-- Bootstrap core CSS -->

        <link href="<?php echo base_url('assets'); ?>/admin/css/bootstrap.min.css" rel="stylesheet">


        <script src="<?php echo base_url('assets'); ?>/admin/js/jquery.min.js"></script>

        <!--[if lt IE 9]>
              <script src="<?php echo base_url('assets'); ?>/admin/js/ie8-responsive-file-warning.js"></script>
              <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="<?php echo base_url('assets'); ?>/admin/js/html5shiv.min.js"></script>
                <script src="<?php echo base_url('assets'); ?>/admin/js/respond.min.js"></script>
              <![endif]-->

        <style>
			</style>
            <link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
            <style type="text/css">
                .wrapper {    
                margin-top: 80px;
                margin-bottom: 20px;
            }

.form-signin {
    max-width: 420px;
    padding: 30px 38px 66px;
    margin: 0 auto;
    background-color: #fff;
    border: 3px dotted rgba(0,0,0,0.1);  
}

.form-signin-heading {
    margin-bottom: 30px;
}

.form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
}

input[type="text"] {
    margin-bottom: 20px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

input[type="password"] {
    margin-bottom: 20px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
            </style>
    </head>

    <body  class="steelBack">

        <div>
            

            <div id="wrapper">
                <div class = "container">
                    <div class="wrapper">
                        <?php
                        echo form_open(base_url() . "do-login", array("class" => "form-signin", "name" => "Login_Form"));
                        ?>   

                        <h3 class="form-signin-heading"><img src="<?php echo base_url('assets'); ?>/img/logo.png" class="img-responsive"></h3>
                        <hr class="colorgraph"><br>
                        <p><?php 
                            echo $this->session->flashdata('msg');
                            ?></p>
                        <hr>
                        <input type="text" class="form-control cForm" name="inputEmail" id="inputEmail" placeholder="Email" autofocus="" />
                        <input type="password" class="form-control cForm" name="inputPassword" placeholder="Password"/>     		  

                        <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" id="loginSubmit" type="Submit">Login</button>  			
                        <span style="color:red"><?php echo $this->session->flashdata('login_error'); ?></span>
						<?php echo form_close(); ?>
						
                    </div>
                </div>
            </div>
		
        </div>
		<script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
	<script>
		$("#loginSubmit").on("click",function(e){
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
    </body>

</html>
