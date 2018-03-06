<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
        <!-- Open Graph data -->
        <meta property="og:title" content="Aileensoul" />
        <meta  property="og:type" content="Email" />
        <meta  property="og:image" content="<?php echo SITEURL.('images/favicon.png'); ?>"/>

        
        <link rel="icon" href="<?php echo SITEURL.('images/favicon.png'); ?>">
        <title><?= $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url('admin/bootstrap/css/bootstrap.min.css'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
        <!-- Ionicons -->
        <!--  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('admin/dist/css/AdminLTE.css'); ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url('admin/dist/css/skins/_all-skins.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url('admin/plugins/iCheck/flat/blue.css'); ?>">
        <!-- Morris chart -->
        <!--<link rel="stylesheet" href="<?php // echo base_url('admin/plugins/morris/morris.css');   ?>">-->

        <!-- Fancybox Css Start -->
        <link rel="stylesheet" href="<?php echo SITEURL.('css/jquery.fancybox.css') ?>" />
        <!-- Fancybox Css End -->

        <!-- Date Picker -->
        <!--<link rel="stylesheet" href="<?php //echo base_url('admin/plugins/datepicker/datepicker3.css'); ?>">-->
        <!-- Daterange picker -->
        <!--<link rel="stylesheet" href="<?php //echo base_url('admin/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">-->
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
  

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!--ALL JS Start Here-->
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url('admin/plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
        <!-- jQuery UI 1.11.4 -->
         <!--<script src="<?php // echo base_url('admin/plugins/jQuery/jquery-ui.min.1.11.4.js');   ?>"></script>-->

        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url('admin/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <!-- Morris.js charts -->
     <!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> // Ankit   -->
    <!--    <script src="<?php //echo base_url('admin/plugins/morris/morris.min.js');   ?>"></script>-->
        <!-- Sparkline -->
        <!-- jvectormap -->
        <!-- jQuery Knob Chart -->
        <script src="<?php echo base_url('admin/plugins/knob/jquery.knob.js'); ?>"></script>
        <!-- daterangepicker -->
    <!---     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script> // Ankit  -->  
        <!--<script src="<?php //echo base_url('admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>-->
        <!-- datepicker -->
        <!--<script src="<?php //echo base_url('admin/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>-->
        
        <!-- Bootstrap WYSIHTML5 -->
       <script src="<?php echo base_url('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>

        <!-- Slimscroll -->
        <script src="<?php echo base_url('admin/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url('admin/plugins/fastclick/fastclick.min.js'); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('admin/dist/js/app.min.js'); ?>"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="<?php //echo base_url('admin/dist/js/pages/dashboard.js'); ?>"></script>-->
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url('admin/dist/js/demo.js'); ?>"></script>
        <!-- CK Editor -->
        <script src="<?php echo base_url('admin/plugins/ckeditor/ckeditor.js'); ?>"></script>
        <!--<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>-->
        <!--for arrow of sorting-->
        <!-- Form Validation -->
        <script type="text/javascript" src="<?php echo base_url('admin/plugins/validation/jquery.validate.min.js'); ?>"></script>


        <!-- DataTables -->
        <script src="<?php echo base_url('admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('admin/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('admin/plugins/datatables/dataTables.bootstrap.css'); ?>">

         <!-- Date And Times -->
        <script src="<?php echo base_url('admin/bootstrap/js/bootstrap-datetimepicker.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('admin/bootstrap/css/bootstrap-datetimepicker.min.css'); ?>">
        <!-- Date And Times -->
        
        <!-- Me Extra added CSS Start-->
        <link rel="stylesheet" href="<?php echo base_url('admin/dist/css/admin.css'); ?>">
       <!-- Me Extra added CSS End-->

        <!--          Resolve conflict in jQuery UI tooltip with Bootstrap tooltip 
            <script>
              $.widget.bridge('uibutton', $.ui.button);
            </script>-->

        <!-- Fancybox Js Start -->
       <script src="<?php echo SITEURL.('js/jquery.fancybox.js'); ?>"></script>
        <!-- Fancybox Js End -->

        <!--for multiple delete-->
        <script type="text/javascript">

            $(document).ready(function () {
                $('#confirm-delete').on('show.bs.modal', function (e) {
                    $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
                });
                $('#search_btn').click(function () {
                    $('#search_frm').submit();
                });
                $('#checkedall').click(function (event) {
                    if (this.checked) {
                        // Iterate each checkbox
                        $('.deletes').each(function () {
                            this.checked = true;
                        });
                    }
                    else {
                        $('.deletes').each(function () {
                            this.checked = false;
                        });
                    }
                });
                $('.deletes').click(function (event) {
                    var flag = 0;
                    $('.deletes').each(function () {
                        if (this.checked == false) {
                            flag++;
                        }
                    });
                    if (flag) {
                        $('.checkedall').prop('checked', false);
                    }
                    else {
                        $('.checkedall').prop('checked', true);
                    }
                });
            });
        </script>
        
<!--        <link rel="stylesheet" type="text/css" href="<?php //echo base_url('admin/plugins/clockpicker/bootstrap-clockpicker.min.css'); ?>">
        <script type="text/javascript" src="<?php //echo base_url('admin/plugins/clockpicker/bootstrap-clockpicker.min.js'); ?>"></script>-->


    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">

                    </span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Admin </b>Aileensoul</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->


                            <!-- User Account: style can be found in dropdown.less -->
                            <!--                        <li class="dropdown user user-menu">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <span class="hidden-xs"><?php echo $loged_in_user[0]['admin_name']; ?> </span><span class=" fa fa-angle-down"></span>
                                                            </a>-->
                            <li class="user user-menu">
                                <a href="<?php echo base_url('dashboard/logout'); ?>" class="dropdown-toggle">
                                    <span class="hidden-xs">Sign Out</span>
                                </a>
                                <?php
                                /*
                                  ?>
                                  <ul class="dropdown-menu">
                                  <!-- User image -->
                                  <li class="user-header" style="height:65px;">
                                  <p>
                                  <?php echo $loged_in_user[0]['admin_name']; ?>
                                  <!--- Web Developer-->
                                  <!--                                            <small>Member since Nov. 2012</small>-->
                                  </p>
                                  </li>


                                  <li class="user-body">
                                  <div class="col-xs-1 text-center">
                                  <a href="#"></a>
                                  </div>
                                  <div class="col-xs-10 text-center">
                                  <a href="<?= base_url('dashboard/change_password') ?>">Change Password</a>
                                  </div>
                                  <div class="col-xs-1 text-center">
                                  <a href="#"></a>
                                  </div>
                                  </li>
                                  <!-- Menu Footer-->
                                  <li class="user-footer">
                                  <div class="pull-left">
                                  <a href="<?= base_url('setting') ?>" class="btn btn-default btn-flat">Setting</a>
                                  </div>
                                  <div class="pull-right">
                                  <a href="<?php echo base_url('dashboard/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                  </div>
                                  </li>
                                  </ul>

                                  <?php
                                 */
                                ?>
                            </li>

                        </ul>
                    </div>
                </nav>
            </header>