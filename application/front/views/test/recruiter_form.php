<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/test.css'); ?>">
       <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header; ?>
        <?php if ($recdata[0]['re_step'] == 3) { ?>
            <?php echo $recruiter_header2_border; ?>
        <?php } ?>

        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>

            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="common-form1">
                    <div class="col-md-3 col-sm-4"></div>

                    <?php
                    if ($recdata[0]['re_step'] == 3) {
                        ?>
                        <div class="col-md-6 col-sm-8"><h3>You are updating your Recruiter Profile.</h3></div>

                    <?php } else {
                        ?>
                        <div class="col-md-6 col-sm-8"><h3>You are making your Recruiter Profile.</h3></div>

                    <?php } ?>
                </div>
               
                <div class="container">
                    <div class="row row4">
                        <div class="col-md-3 col-sm-4">
                            <div class="left-side-bar">
                                <ul class="left-form-each">

                                    <li <?php if ($this->uri->segment(1) == 'recruiter') { ?> class="active init" <?php } ?>>
                                        <!--<a href="#">Basic Information</a>-->
                                         <a title="Post" href="javascript:void(0);" onclick="ChangeUrl('Page1', '<?php echo base_url('test/basic') ?>');">Basic information</a>
                                    </li>

                                    <li  class="custom-none <?php
                                    if ($recdata[0]['re_step'] < '1') {
                                        echo "khyati";
                                    }
                                    ?>">
                                        <!--<a href="<?php echo base_url('recruiter/company-information'); ?>">Company Information</a>-->
                                         <a title="Post" href="javascript:void(0);" onclick="ChangeUrl('Page2', '<?php echo base_url('test/contact') ?>');">Company Information</a>
                               </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-8">

                            <div>
                                <?php
                                if ($this->session->flashdata('error')) {
                                    echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                }
                                if ($this->session->flashdata('success')) {
                                    echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                }
                                ?>
                            </div>

                            <!--MIDDLE CHANGES DATA THAT ONLY REFRESH START-->
                            <div id="screen"></div>
                            <!--MIDDLE CHANGES DATA THAT ONLY REFRESH END-->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php echo $footer; ?>
        <!-- END FOOTER -->

        <!-- FIELD VALIDATION JS START -->
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.wallform.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/demo/jquery-1.9.1.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/demo/jquery-ui-1.9.1.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var data1 = <?php echo json_encode($de); ?>;
            var data = <?php echo json_encode($demo); ?>;
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!-- FIELD VALIDATION JS END -->
       <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
       <script>
            function ChangeUrl(title, url) {
                                                     if (typeof (history.pushState) != "undefined") {
                                                         var obj = {Title: title, Url: url};
                                                         history.pushState(obj, obj.Title, obj.Url);
                                                         $("#screen").load(url);
                                                     } else {
                                                         alert("Browser does not support HTML5.");
                                                     }
                                                 }
                                                 
       jQuery(document).ready(function ($) {
           
           
           
      var recstep = '<?php echo $recdata[0]['re_step']; ?>';
      
      
      if(recstep < 1 || recstep == 3){
      var title = 'page2';
      var url = '<?php echo base_url('test/recruiter_form//basic'); ?>';
    } else if(recstep == 1){
       var title = 'page2';
      var url = '<?php echo base_url('test/recruiter_form/contact'); ?>';
     
    }
    
    if (typeof (history.pushState) != "undefined") {
                                                         var obj = {Title: title, Url: url};
                                                         history.pushState(obj, obj.Title, obj.Url);
                                                         $("#screen").load(url);
                                                     } else {
                                                         alert("Browser does not support HTML5.");
                                                     }
      
   });
       </script>
    </body>
</html>