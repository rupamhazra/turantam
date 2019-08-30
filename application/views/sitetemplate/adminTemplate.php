<!DOCTYPE html>
<html lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Administrator | Turantam </title>

        <!-- Bootstrap core CSS -->

        <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/admin/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- bootstrap-datetimepicker -->
        <link href="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/animate.min.css" rel="stylesheet">

        <!-- Datatables -->
        <link href="<?php echo base_url(); ?>assets/js/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/js/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/js/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/js/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/js/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>assets/admin/css/custom.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/icheck/flat/green.css" rel="stylesheet">
         <link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
    

        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>

        <!--[if lt IE 9]>
              <script src="<?php echo base_url(); ?>admin/js/ie8-responsive-file-warning.js"></script>
              <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="<?php echo base_url(); ?>admin/js/html5shiv.min.js"></script>
                <script src="<?php echo base_url(); ?>admin/js/respond.min.js"></script>
              <![endif]-->

        <?php
        if (!empty($stylesheets)) {
            foreach ($stylesheets as $stylesheet) {
                ?>
                <link href="<?php echo base_url() . $stylesheet; ?>" type="text/css" rel="stylesheet" media="screen,projection">
                <?php
            }
        }
        ?>

    </head>


    <body class="nav-md steelBack">

        <div class="container body">


            <div class="main_container">

                <div class="col-md-3 left_col steelBack">
                    <div class="left_col scroll-view steelBack">

                       <!--  <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo base_url();?>admin-dashboard" class="site_title"><img src="<?php echo base_url().'assets/img/ERP-solutions.png'; ?>"  height="40"/></a>
                        </div> -->
                        <div class="navbar nav_title steelBack" style="border: 0;" >
                          <a href="<?php echo base_url();?>admin-dashboard" class="site_title"><img src="<?php echo base_url('assets'); ?>/img/logo.png" class="img-responsive"></a>
                        </div>
                        <div class="clearfix"></div>

                        <br>
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                            <div class="menu_section ">

                                <ul class="nav side-menu">
                                    <!-- <li><a><i class="fa fa-newspaper-o"></i> PAGES <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">

                                            <li><a href="<?php echo base_url() . "admin-dashboard"; ?>">List Pages</a>
                                            <li><a href="<?php echo base_url() . "admin/add-page"; ?>">Add Page</a>
                                            </li>

                                        </ul>
                                    </li> -->
                                    <li><a><i class="fa fa-pencil-square-o "></i> MANAGE USER <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <li><a href="<?php echo base_url() . "admin/list-user";?>">List</a>
                                            </li>
                                            <!-- <li><a href="<?php echo base_url() . "admin/add-user"; ?>">Add </a>
                                            </li> -->
                                        </ul>
                                    </li>
                                      <li><a><i class="fa fa-pencil-square-o "></i> MANAGE SERVICE <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">

                                            <li><a href="<?php echo base_url() . "admin/service-category"; ?>">Service Category </a>
                                            </li>
                                     
											 <li><a href="<?php echo base_url() . "admin/list-service"; ?>">Service List </a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/add-service"; ?>">Add Service</a>
                                            </li>
                                          
                                        </ul>
                                    </li>
                                     <li><a><i class="fa fa-pencil-square-o "></i> MANAGE PACKAGE <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                             <li><a href="<?php echo base_url() . "admin/list-package"; ?>">Package List </a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/add-package"; ?>">Add Package</a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/list-package-entity"; ?>">Package Entity </a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/list-package-entity-value"; ?>">Package Entity Value</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-pencil-square-o "></i> MANAGE ORDER <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                             <li><a href="<?php echo base_url() . "admin/list-order"; ?>">Order List </a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/list-order-details"; ?>">Order Details </a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/list-customer-address"; ?>">Customer Address </a>
                                            </li>
                                        </ul>
                                    </li>
                                    </li>
                                    <li><a><i class="fa fa-pencil-square-o "></i> MANAGE MASTER <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                             <li><a href="<?php echo base_url() . "admin/list-country"; ?>">Country</a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/list-location"; ?>">Location</a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/list-state"; ?>">State</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-gear"></i> SETTINGS <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                             <li><a href="<?php echo base_url() . "admin/list-gallery"; ?>">Gallery</a>
                                            </li>
                                            <li><a href="<?php echo base_url() . "admin/mail-config"; ?>">Mail</a>
                                            </li>
                                             <li><a href="<?php echo base_url() . "admin/list-template";?>">Mail Templates</a>
                                        </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <!-- <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>

                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url('log-out');?>">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div> -->
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                 <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url('uploads/').$this->session->userdata('profile_image'); ?>" alt=""><?php echo $this->session->userdata('name'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!-- <li><a href="javascript:;"> Profile</a></li> -->
                    <!-- <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li> -->
                    <!-- <li><a href="javascript:;">Help</a></li> -->
                    <li><a href="<?php echo base_url('log-out');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <!-- <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
				<?php echo $body; ?>

                </div>
<!-- /page content -->
</div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/js/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>assets/js/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/js/icheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url(); ?>assets/js/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- bootstrap-datetimepicker -->    
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="<?php echo base_url(); ?>assets/js/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>assets/js/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="<?php echo base_url(); ?>assets/js/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="<?php echo base_url(); ?>assets/js/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url(); ?>assets/js/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="<?php echo base_url(); ?>assets/js/starrr/dist/starrr.js"></script>

     <!-- Datatables -->
    <script src="<?php echo base_url(); ?>assets/js/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pdfmake/build/vfs_fonts.js"></script>



    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

<?php
if (!empty($javascripts)) {
    foreach ($javascripts as $javascript) {
        ?>
        <script type="text/javascript" src="<?php echo base_url() . $javascript; ?>"></script>
        <?php
    }
}
?>

<script>
    $('#inputName').on('keyup keypress blur', function()
	{

	var myStr = $(this).val();
		myStr=myStr.toLowerCase();
		myStr=myStr.replace(/ /g,"-");
		myStr=myStr.replace(/[^a-zA-Z0-9.\.]+/g,"-");
		myStr=myStr.replace(/\.+/g, "-");


    $('#inputUrl').val(myStr);
});
$('#myDatepicker').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss'
});
</script>


</body>

</html>
