<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>

        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter/rec_common_header.min.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <!-- END HEAD -->
    <style>
        /***  commen css  ***/
        .p0{padding: 0;} .p5{padding: 5px;} .p10{padding: 10px;} .p15{padding: 15px;} .p20{padding: 20px;}
        .pr0{padding-right: 0;} .pr5{padding-right: 5px;} .pr10{padding-right: 10px;} .pr15{padding-right: 15px;} .pr20{padding-right: 20px;}
        .pl0{padding-left: 0;} .pl5{padding-left: 5px;} .pl10{padding-left: 10px;} .pl15{padding-left: 15px;} .pl20{padding-left: 20px;}
        .pt0{padding-top: 0;} .pt5{padding-top: 5px;} .pt10{padding-top: 10px;} .pt15{padding-top: 15px;} .pt20{padding-top: 20px;}
        .pb0{padding-bottom: 0;} .pb5{padding-bottom: 5px;} .pb10{padding-bottom: 10px;} .pb15{padding-bottom: 15px;} .pb20{padding-bottom: 20px;}
        .main-inner .btn-right .btn3:hover{text-decoration: none;}

        .fs12{font-size:12px;}

        .pb0{padding-bottom: 0;} .pb5{padding-bottom: 5px;} .pb10{padding-bottom: 10px;} .pb15{padding-bottom: 15px;} 
        .pb20{padding-bottom: 20px;}


        .fs12{font-size:12px;}
        .red{color:#ff0000;}
        .ttc{text-transform:capitalize !important; text-align: center;}
        /*.login-frm{width:480px !important;}*/
        /***  buttons  ***/
        .btn1{
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9)); 
            background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
            background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
            background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3bb0ac', endColorstr='#1b8ab9',GradientType=0 ); 
            font-size:16px;
            color:#fff;
            padding:5px 25px;
            text-align:center;
            border-radius: 4px;
            border:2px solid #1b8ab9;

        }
        .btn1:hover{
            border:2px solid #1b8ab9;
            color:#fff;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #1b8ab9), color-stop(56%, #3bb0ac), color-stop(100%, #3bb0ac)); 
            background: -webkit-linear-gradient(96deg, #3bb0ac 0%, #3bb0ac 44%, #1b8ab9 100%); 
            background: -o-linear-gradient(96deg, #3bb0ac 0%, #3bb0ac 44%, #1b8ab9 100%);
            background: -ms-linear-gradient(96deg, #3bb0ac 0%, #3bb0ac 44%, #1b8ab9 100%); 
            background: linear-gradient(354deg, #3bb0ac 0%, #1b8ab9 44%, #1b8ab9 100%); 
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1b8ab9', endColorstr='#3bb0ac',GradientType=0 ); 

        }

        .btn1:focus{
            opacity:0.6;
        }

        .btn2{
            background:#fff;
            font-size:16px;
            color:#1b8ab9;
            padding:8px 25px;
            text-align:center;
            border-radius:4px;
            display:inline-block;
            border:1px solid #fff;
            font-family: 'robotolight';
            line-height:1;
        }
        .btn2:hover{
            border:1px solid #fff;
            background:transparent;
            color:#fff;
            text-decoration:none;
        }
        .btn3{
            font-size:16px;
            color:#fff;
            padding:8px 25px;
            text-align:center;
            border-radius:4px;
            display:inline-block;
            border:1px solid #fff;
            font-family: 'robotolight';
            line-height:1;
        }
        .btn3:hover {
            background: #fff;
            color: #1b83b9;
        }
        .clr-c a{color:#999;}
        .main-login{
            background-color:#fff;
        }
        .login-frm .login form{padding: 16px 60px 15px;}
        /***  header  ***/
        header{
            z-index: 10;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* ff3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9)); /* safari4+,chrome */
            background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* safari5.1+,chrome10+ */
            background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* opera 11.10+ */
            background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* ie10+ */
            background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* w3c */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3bb0ac', endColorstr='#1b8ab9',GradientType=0 ); /* ie6-9 */
            padding:15px 0;
        }
        header .logo a{
            color:#fff;
        }
        header .logo a:focus, header .logo a:hover {
            text-decoration:none;
        }
        header h2{
            margin:0; 
            font-weight:bold;
        }
        .header-login .input{   
            width:28%;    
            float:left;   
            margin-right:20px;    
        }
        .header-login input{
            background:transparent;
            border:none;
            border-bottom:1px solid #fff;
            border-radius:0px;
            box-shadow:none;
            font-size:14px;
            color:#fff;
            height:32px;

        }
        .header-login input:focus{
            box-shadow:none;
        }
        .header-login .btn1{
            font-size:15px;
            padding-top:8px;
            padding-bottom:8px;
            line-height:1;
            background:none;
            color:#fff;
            border:1px solid #fff;
        }
        .header-login .btn1:hover{
            background:#fff;
            color:#1b8ab9;
            border:1px solid #fff;
        }
        .header-login input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            color: #ddd;
        }
        .header-login input::-moz-placeholder { /* Firefox 19+ */
            color: #ddd;
        }
        .header-login input:-ms-input-placeholder { /* IE 10+ */
            color: #ddd;
        }
        .header-login input:-moz-placeholder { /* Firefox 18- */
            color: #ddd;
        }
        .header-login .f-pass{
            color:#fff;
            padding-left:10px;
        } 
        .header-login .f-pass:hover{
            text-decoration:underline;
        }
        a:hover{
            /*text-decoration:none;*/
        }
        /*.pt-100{padding-top: 100px;}*/
        /***  middle part  ***/
        /*.middle-main{height:90vh;}*/

        .main-login .middle-main{
            padding:100px 0;
            background:url('../img/bg.png') no-repeat;
            background-size:100%;

        }
        .main-login .middle-main .container{height:100%; position:relative;}
        .top-middle{
            padding:45px 0 10px 50px;
            min-height:190px;
        }
        .top-middle h3{
            font-size:30px; 
            color:#505050; 
            line-height:1.5;
            margin:0;
        }
        .top-middle .output {
            display:none;
        }
        .top-middle .active:after {
            content: '_';
        }
        /***  login form css  ***/
        .login{
            /*background:#fff;*/
            width:100%;
            margin:0 auto;
            border:1px solid #c7c7c7;
            border-radius:5px;
            -webkit-box-shadow: 0px 0px 10px -1px rgba(217,217,217,1);
            -moz-box-shadow: 0px 0px 10px -1px rgba(217,217,217,1);
            box-shadow: 0px 0px 10px -1px rgba(217,217,217,1);
            height: auto !important;
        } 
        .inner-form .login {
            background: #fff !important;
            width: 80%;
            margin: 0 auto;
            border: 1px solid #c7c7c7;
        }
        .login h4{
            color:#1b8ab9;
            background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding:15px; 
            text-align:center;
            margin:0;
            color:#1b8ab9;
            border-bottom:1px solid #c7c7c7;
            font-size:28px;
            font-family: 'robotoregular';
        }
        .login form{
            padding:16px 30px 15px;
        }
        .login .form-group input, .login .form-group select, .login .form-group textarea {
            border:none;
            border-bottom:1px solid #d9d9d9;
            border-radius:0px;
            box-shadow:none;
            font-size:15px;
            color:#848484;
            height:35px;
            padding-left: 6px;
        }
        .login .form-group select{
            width:65px;
            margin-right:15px;
            -webkit-appearance: none;
            -moz-appearance:    none;
            appearance:         none;
            position:relative;
            background:url('../img/down-arrow.png') no-repeat;
            background-position:right;   

        }
        .login .form-group select:focus{
            width:65px;
            margin-right:15px;
            -webkit-appearance: none;
            -moz-appearance:    none;
            appearance:         none;
            position:relative;
            background:url('../img/down-arrow-hover.png') no-repeat;
            background-position:right;  
        }

        .login .form-group select.year{
            width:70px;
        }
        .login .form-group select.gender{
            width:100px;
        }
        .form-text{
            font-size:12px;
            color:#3b3a3a;
            padding-top:10px;
            padding-bottom:10px;
        }
        .form-text a{
            color:#b5b5b5;
        }
        .login .btn1{
            display:inline-block;
            width:100%;
        }


        /*onclick*/
        .form-group textarea:focus {
            border-bottom: 1px solid #1b8ab9 !important;
            color: #1b8ab9!important;
        }
        /* label focus color */
        .form-group textarea[type=text]:focus + label {
            color: #1b8ab9!important;
        }
        /* label underline focus color */
        .form-group textarea[type=text]:focus {
            border-bottom: 1px solid #1b8ab9;
            color: #1b8ab9!important;

        }
        .form-group input:focus {
            border-bottom: 1px solid #1b8ab9 !important;
            color: #1b8ab9!important;
        }
        /* label focus color */
        .form-group input[type=text]:focus + label {
            color: #1b8ab9!important;
        }
        /* label underline focus color */
        .form-group input[type=text]:focus {
            border-bottom: 1px solid #1b8ab9;
            color: #1b8ab9!important;

        }
        .form-group input::-webkit-input-placeholder {
            color: #999;
        }
        textarea:focus::-webkit-input-placeholder
        {
            color:    #1b8ab9;
        }

        .form-group input:focus::-webkit-input-placeholder {
            color: #1b8ab9;
        }
        /* Firefox < 19 */

        .form-group input:focus:-moz-placeholder {
            color: #1b8ab9;
        }
        /* Firefox > 19 */

        .form-group input:focus::-moz-placeholder {
            color: #1b8ab9;
        }

        /* Internet Explorer 10 */

        .form-group input:focus:-ms-textarea-placeholder {
            color: #1b8ab9;
        }
        /*second*/
        .no-login .left_side_posrt label{margin-bottom: 6px;}
        .no-login .left_side_posrt  a {color: #5c5c5c;}
        .no-login .left_side_posrt  a:hover{color: #1b8ab9 !important;}
        .job_active{color: #1b8ab9 !important;}
        .no-login .left_side_posrt .lbpos input{width: 10% !important; }
        .no-login .left_side_posrt .profile-boxProfileCard-cover{height: 210px;border: none;}







    </style>
    <body class="page-container-bg-solid page-boxed no-login freeh3">

        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 col-xs-4 left-header fw-479">
                        <h2 class="logo"><a href="<?php echo base_url(); ?>" title="Aileensoul">Aileensoul</a></h2>
                    </div>
                    <div class="col-md-8 col-sm-9 col-xs-8 right-header fw-479">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_profile();" class="btn2" title="Login">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3" title="Create an account">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row4">

                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">

                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a href="<?php echo base_url("jobs"); ?>" title="All Jobs">All Jobs</a>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs/?city=Ahmedabad"); ?>" <?php if ($_GET['city'] == 'Ahmedabad') { ?> class="job_active" <?php } ?> title="Ahmedabad Jobs">Ahmedabad Jobs</a>
                                            </label>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs/?city=Bengaluru"); ?>" <?php if ($_GET['city'] == 'Bengaluru') { ?> class="job_active" <?php } ?> title="Bengaluru Jobs">Bengaluru Jobs</a>
                                            </label>
                                            <label for="City" class="lbpos fw"> 
                                                <a href="<?php echo base_url("jobs/?city=Chennai"); ?>" <?php if ($_GET['city'] == 'Chennai') { ?> class="job_active" <?php } ?> title="Chennai Jobs">Chennai Jobs</a>
                                            </label>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs/?city=Delhi"); ?>" <?php if ($_GET['city'] == 'Delhi') { ?> class="job_active" <?php } ?> title="Delhi Jobs">Delhi Jobs</a>
                                            </label>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs/?city=Hyderabad"); ?>" <?php if ($_GET['city'] == 'Hyderabad') { ?> class="job_active" <?php } ?> title="Hyderabad Jobs">Hyderabad Jobs</a>
                                            </label>

                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs/?city=Mumbai"); ?>" <?php if ($_GET['city'] == 'Mumbai') { ?> class="job_active" <?php } ?> title="Mumbai Jobs">Mumbai Jobs</a>
                                            </label>

                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs/?city=pune"); ?>" <?php if ($_GET['city'] == 'pune') { ?> class="job_active" <?php } ?> title="Pune Jobs">Pune Jobs</a>
                                            </label>


                                            <!--                                                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="javascript:void(0);" onclick="register_profile();" tabindex="-1" 
                                                                                                                           aria-hidden="true" rel="noopener">
                                                                                                                            <div class="bg-images no-cover-upload"> 
                                            <?php
                                            $image_ori = $recdata[0]['profile_background'];
                                            $filename = $this->config->item('rec_bg_main_upload_path') . $recdata[0]['profile_background'];
                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                            if ($info && $recdata[0]['profile_background'] != '') {
                                                ?>
                                                                                                                                                                            <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $recdata[0]['profile_background']; ?>" name="image_src" id="image_src" />
                                                <?php
                                            } else {
                                                ?>
                                                                                                                                                                            <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" >
                                                <?php
                                            }
                                            ?>
                                                                                                                            </div>
                                                                                                                        </a>-->
                                        </div>
                                        <!--                                                                        <div class="profile-boxProfileCard-content clearfix">
                                                                                                                    <div class="left_side_box_img buisness-profile-txext">
                                                                        
                                                                                                                        <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="javascript:void(0);" onclick="register_profile();" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                        <?php
                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image'];
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                        if ($recdata[0]['recruiter_user_image'] != '' && $info) {
                                            ?>
                                                                                                                                                                        <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata[0]['recruiter_user_image']; ?>" alt="" >
                                            <?php
                                        } else {


                                            $a = $recdata[0]['rec_firstname'];
                                            $acr = substr($a, 0, 1);

                                            $b = $recdata[0]['rec_lastname'];
                                            $acr1 = substr($b, 0, 1);
                                            ?>
                                                                                                                                                                        <div class="post-img-profile">
                                            <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>
                                                                                                                
                                                                                                                                                                        </div>
                                                                                                                
                                            <?php
                                        }
                                        ?>
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                    <div class="right_left_box_design ">
                                                                                                                        <span class="profile-company-name ">
                                                                                                                            <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                                                                                                        </span>
                                                                        
                                        <?php //$category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;   ?>
                                                                                                                        <div class="profile-boxProfile-name">
                                                                                                                            <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">
                                        <?php
                                        if (ucfirst(strtolower($recdata[0]['designation']))) {
                                            echo ucfirst(strtolower($recdata[0]['designation']));
                                        } else {
                                            echo "Designation";
                                        }
                                        ?></a>
                                                                                                                        </div>
                                                                                                                        <ul class=" left_box_menubar">
                                                                                                                            <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="javascript:void(0);" onclick="register_profile();"> Details</a>
                                                                                                                            </li>                                
                                                                                                                            <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="javascript:void(0);" onclick="register_profile();">Post</a>
                                                                                                                            </li>
                                                                                                                            <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="javascript:void(0);" onclick="register_profile();">Saved </a>
                                                                                                                            </li>
                                                                        
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                </div>-->
                                    </div>                             
                                </div>



                                <?php echo $left_footer; ?>
                                




                            </div>

                        </div>

                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="common-form">
                                <div class="job-saved-box">
                                    <h3>
                                        <?php if ($_GET['city']) { ?> All Jobs of
                                            <?php
                                            echo $_GET['city'];
                                        } else {
                                            ?>
                                            All Jobs
<?php } ?>
                                    </h3>

                                    <div class="contact-frnd-post">
                                        <?php
                                        if ($postdata) {
                                            foreach ($postdata as $post) {
                                                ?>
                                                <div class="job-contact-frnd ">
                                                    <div class="profile-job-post-detail clearfix" id="<?php echo "removepost" . $post['post_id']; ?>">
                                                        <!-- vishang 14-4 end -->
                                                        <div class="profile-job-post-title clearfix">
                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-details col-md-12">
                                                                    <ul>
                                                                        <li class="fr date_re">
                                                                            Created Date : <?php echo date('d-M-Y', strtotime($post['created_date'])); ?>
                                                                        </li>

                                                                        <?php
                                                                        $cache_time = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                                                        if ($cache_time) {
                                                                            $cache_time;
                                                                        } else {
                                                                            $cache_time = $post['post_name'];
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($cache_time != '') {
                                                                            $text = strtolower($this->common->clean($cache_time1));
                                                                        } else {
                                                                            $text = '';
                                                                        }
                                                                        $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                                        if ($cityname != '') {
                                                                            $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                                                                        } else {
                                                                            $cityname = '';
                                                                        }
                                                                        ?>

                                                                        <li class="">
                                                                            <div class="post_title">
                                                                                <a class="" href="<?php echo base_url('recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '?page=all_jobs'); ?>" title="<?php echo $cache_time; ?>"> <?php echo $cache_time; ?>
                                                                                </a>  
                                                                            </div>
                                                                        </li>

                                                                        <li>  
                                                                            <?php
                                                                            $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                                            $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                                            ?> 

                                                                            <?php
                                                                            if ($cityname || $countryname) {
                                                                                ?>

                                                                                <div class="fr lction">
                                                                                    <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>

                                                                                        <?php
                                                                                        if ($cityname) {
                                                                                            echo $cityname . ', ';
                                                                                        }
                                                                                        ?>
            <?php echo $countryname; ?> 
                                                                                    </p>

                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <a class="display_inline" title="<?php echo $post['re_comp_name'] ?>" href="javascript:void(0)">
                                                                                <?php
                                                                                $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                                                echo $out;
                                                                                ?> </a>
                                                                        </li>
                                                                        <li class="fw"><a class="display_inline" title="Recruiter Name" href="javascript:void(0)"> <?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?> </a></li>
                                                                        <!-- vishang 14-4 end -->    
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="profile-job-profile-menu">
                                                                <ul class="clearfix">
                                                                    <li> <b> Skills</b> <span> 
                                                                            <?php
                                                                            $comma = ", ";
                                                                            $k = 0;
                                                                            $aud = $post['post_skill'];
                                                                            $aud_res = explode(',', $aud);

                                                                            if (!$post['post_skill']) {

                                                                                echo $post['other_skill'];
                                                                            } else if (!$post['other_skill']) {


                                                                                foreach ($aud_res as $skill) {

                                                                                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                                                                                    if ($cache_time != " ") {
                                                                                        if ($k != 0) {
                                                                                            echo $comma;
                                                                                        }echo $cache_time;
                                                                                        $k++;
                                                                                    }
                                                                                }
                                                                            } else if ($post['post_skill'] && $post['other_skill']) {
                                                                                foreach ($aud_res as $skill) {
                                                                                    if ($k != 0) {
                                                                                        echo $comma;
                                                                                    }
                                                                                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                                    echo $cache_time;
                                                                                    $k++;
                                                                                } echo "," . $post['other_skill'];
                                                                            }
                                                                            ?>     

                                                                        </span>
                                                                    </li>
                                                                    <!-- <li><b>Other Skill</b><span> <?php
                                                                    if ($post['other_skill'] != '') {
                                                                        echo $post['other_skill'];
                                                                    } else {
                                                                        echo PROFILENA;
                                                                    }
                                                                    ?></span>
                                                                    </li> -->
                                                                    <li><b>Job Description</b><span><pre><?php echo $this->common->make_links($post['post_description']); ?></pre></span>
                                                                    </li>
                                                                    <li><b>Interview Process</b><span>


                                                                                <?php if ($post['interview_process'] != '') { ?>
                                                                                <pre>
                                                                                <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                                                <?php
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?> 

                                                                        </span>
                                                                    </li>

                                                                    <!-- vishang 14-4 start -->
                                                                    <li>
                                                                        <b>Required Experience</b>
                                                                        <span>
                                                                            <p title="Min - Max">
                                                                                <?php
                                                                                if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                                                    echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " , " . "Fresher can also apply.";
                                                                                } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                                                    echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                                                                                } else {
                                                                                    echo "Fresher";
                                                                                }
                                                                                ?> 

                                                                            </p>  
                                                                        </span>
                                                                    </li>


                                                                    <li><b>Salary</b><span title="Min - Max" >
                                                                            <?php
                                                                            $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                                            if ($post['min_sal'] || $post['max_sal']) {
                                                                                echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?></span>
                                                                    </li>



                                                                    <li><b>No of Position</b><span><?php echo $post['post_position'] . ' ' . 'Position'; ?></span>
                                                                    </li>

                                                                    <li><b>Industry Type</b> <span>
                                                                            <?php
                                                                            $cache_time = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                                            echo $cache_time;
                                                                            ?>
                                                                        </span> 
                                                                    </li>



        <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>

                                                                        <li> <b>Education Required</b> <span> 



                                                                                <?php
                                                                                $comma = ", ";
                                                                                $k = 0;
                                                                                $edu = $post['degree_name'];
                                                                                $edu_nm = explode(',', $edu);

                                                                                if (!$post['degree_name']) {

                                                                                    echo $post['other_education'];
                                                                                } else if (!$post['other_education']) {


                                                                                    foreach ($edu_nm as $edun) {
                                                                                        if ($k != 0) {
                                                                                            echo $comma;
                                                                                        }
                                                                                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                                        echo $cache_time;
                                                                                        $k++;
                                                                                    }
                                                                                } else if ($post['degree_name'] && $post['other_education']) {
                                                                                    foreach ($edu_nm as $edun) {
                                                                                        if ($k != 0) {
                                                                                            echo $comma;
                                                                                        }
                                                                                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                                        echo $cache_time;
                                                                                        $k++;
                                                                                    } echo "," . $post['other_education'];
                                                                                }
                                                                                ?>     

                                                                            </span>
                                                                        </li>

                                                                        <?php
                                                                    } else {
                                                                        ?>

                                                                        <li><b>Education Required</b><span>
            <?php echo PROFILENA; ?>
                                                                            </span>
                                                                        </li>
                                                                    <?php }
                                                                    ?>                   <li><b>Employment Type</b><span>


                                                                                <?php if ($post['emp_type'] != '') { ?>
                                                                                <pre>
                                                                                <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?></pre>
                                                                                <?php
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?> 

                                                                        </span>
                                                                    </li>

                                                                    <li><b>Company Profile</b><span>


                                                                                <?php if ($post['re_comp_profile'] != '') { ?>
                                                                                <pre>
                                                                                <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                                                <?php
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?> 

                                                                        </span>
                                                                    </li>


                                                                </ul>
                                                            </div>

                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-details col-md-12">
                                                                    <ul><li class="job_all_post ">
                                                                        <li class="job_all_post last_date">
                                                                            Last Date :
                                                                            <?php
                                                                            if ($post['post_last_date'] != "0000-00-00") {
                                                                                echo date('d-M-Y', strtotime($post['post_last_date']));
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?>
                                                                        </li>                                                              </li>
                                                                        <li class=fr>


                                                                            <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  button" title="Apply"> Apply</a>
                                                                        </li> 
                                                                        <!--                                                                                <li>
                                                                                                                                                                <a  href="javascript:void(0);" onclick="login_profile();" class="savedpost> button">Save</a>
                                                                        
                                                                                                                                                    </li>                        -->
                                                                    </ul>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <div class="text-center rio">
                                                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                                <p style="margin-left:4%;text-transform:none !important;border:0px;">We couldn't find what you were looking for.</p>
                                                <ul>
                                                    <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                                                </ul>
                                            </div>

<?php }
?>
                                        <!--.........AJAX DATA END......-->           
                                   <!--<div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>-->
                                    </div>

                                </div>
                            </div>
                            
                            <!--recommen candidate start-->
<?php if (count($recommandedpost) > 0) { ?>
                                <div class="common-form">
                                    <div class="job-saved-box">
                                        <h3>
                                            Recommended job
                                        </h3>
                                        <div class="contact-frnd-post">
                                            <div class="job-contact-frnd ">
                                                <!--.........AJAX DATA START......-->  
                                                <div class="job-post-detail clearfix">
                                                    <?php
                                                    foreach ($recommandedpost as $post) {
                                                        ?>
                                                        <div class="job-contact-frnd ">
                                                            <div class="profile-job-post-detail clearfix" id="<?php echo "removepost" . $post['post_id']; ?>">
                                                                <!-- vishang 14-4 end -->
                                                                <div class="profile-job-post-title clearfix">
                                                                    <div class="profile-job-profile-button clearfix">
                                                                        <div class="profile-job-details col-md-12">
                                                                            <ul>
                                                                                <li class="fr date_re">
                                                                                    Created Date : <?php echo date('d-M-Y', strtotime($post['created_date'])); ?>
                                                                                </li>

                                                                                <li class="">

                                                                                    <a class="post_title" href="javascript:void(0)" title="Post Title">
                                                                                        <?php
                                                                                        $cache_time = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                                                                        if ($cache_time) {
                                                                                            echo $cache_time;
                                                                                        } else {
                                                                                            echo $post['post_name'];
                                                                                        }
                                                                                        ?>  </a>     
                                                                                </li>

                                                                                <li>  
                                                                                    <?php
                                                                                    $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                                                    $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                                                    ?> 

                                                                                    <?php
                                                                                    if ($cityname || $countryname) {
                                                                                        ?>

                                                                                        <div class="fr lction">
                                                                                            <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>

                                                                                                <?php
                                                                                                if ($cityname) {
                                                                                                    echo $cityname . ', ';
                                                                                                }
                                                                                                ?>
            <?php echo $countryname; ?> 
                                                                                            </p>

                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                    <a class="display_inline" title="<?php echo $post['re_comp_name'] ?>" href="javascript:void(0)">
                                                                                        <?php
                                                                                        $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                                                        echo $out;
                                                                                        ?> </a>
                                                                                </li>
                                                                                <li class="fw"><a class="display_inline" title="Recruiter Name" href="javascript:void(0)"> <?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?> </a></li>
                                                                                <!-- vishang 14-4 end -->    
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="profile-job-profile-menu">
                                                                        <ul class="clearfix">
                                                                            <li> <b> Skills</b> <span> 
                                                                                    <?php
                                                                                    $comma = ", ";
                                                                                    $k = 0;
                                                                                    $aud = $post['post_skill'];
                                                                                    $aud_res = explode(',', $aud);

                                                                                    if (!$post['post_skill']) {

                                                                                        echo $post['other_skill'];
                                                                                    } else if (!$post['other_skill']) {


                                                                                        foreach ($aud_res as $skill) {

                                                                                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                                                                                            if ($cache_time != " ") {
                                                                                                if ($k != 0) {
                                                                                                    echo $comma;
                                                                                                }echo $cache_time;
                                                                                                $k++;
                                                                                            }
                                                                                        }
                                                                                    } else if ($post['post_skill'] && $post['other_skill']) {
                                                                                        foreach ($aud_res as $skill) {
                                                                                            if ($k != 0) {
                                                                                                echo $comma;
                                                                                            }
                                                                                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                                            echo $cache_time;
                                                                                            $k++;
                                                                                        } echo "," . $post['other_skill'];
                                                                                    }
                                                                                    ?>     

                                                                                </span>
                                                                            </li>
                                                                            <!-- <li><b>Other Skill</b><span> <?php
                                                                            if ($post['other_skill'] != '') {
                                                                                echo $post['other_skill'];
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?></span>
                                                                            </li> -->
                                                                            <li><b>Job Description</b><span><pre><?php echo $this->common->make_links($post['post_description']); ?></pre></span>
                                                                            </li>
                                                                            <li><b>Interview Process</b><span>


                                                                                        <?php if ($post['interview_process'] != '') { ?>
                                                                                        <pre>
                                                                                        <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                                                        <?php
                                                                                    } else {
                                                                                        echo PROFILENA;
                                                                                    }
                                                                                    ?> 

                                                                                </span>
                                                                            </li>

                                                                            <!-- vishang 14-4 start -->
                                                                            <li>
                                                                                <b>Required Experience</b>
                                                                                <span>
                                                                                    <p title="Min - Max">
                                                                                        <?php
                                                                                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " , " . "Fresher can also apply.";
                                                                                        } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                                                                                        } else {
                                                                                            echo "Fresher";
                                                                                        }
                                                                                        ?> 

                                                                                    </p>  
                                                                                </span>
                                                                            </li>


                                                                            <li><b>Salary</b><span title="Min - Max" >
                                                                                    <?php
                                                                                    $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                                                    if ($post['min_sal'] || $post['max_sal']) {
                                                                                        echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                                                    } else {
                                                                                        echo PROFILENA;
                                                                                    }
                                                                                    ?></span>
                                                                            </li>



                                                                            <li><b>No of Position</b><span><?php echo $post['post_position'] . ' ' . 'Position'; ?></span>
                                                                            </li>

                                                                            <li><b>Industry Type</b> <span>
                                                                                    <?php
                                                                                    $cache_time = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                                                    echo $cache_time;
                                                                                    ?>
                                                                                </span> 
                                                                            </li>



        <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>

                                                                                <li> <b>Education Required</b> <span> 



                                                                                        <?php
                                                                                        $comma = ", ";
                                                                                        $k = 0;
                                                                                        $edu = $post['degree_name'];
                                                                                        $edu_nm = explode(',', $edu);

                                                                                        if (!$post['degree_name']) {

                                                                                            echo $post['other_education'];
                                                                                        } else if (!$post['other_education']) {


                                                                                            foreach ($edu_nm as $edun) {
                                                                                                if ($k != 0) {
                                                                                                    echo $comma;
                                                                                                }
                                                                                                $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                                                echo $cache_time;
                                                                                                $k++;
                                                                                            }
                                                                                        } else if ($post['degree_name'] && $post['other_education']) {
                                                                                            foreach ($edu_nm as $edun) {
                                                                                                if ($k != 0) {
                                                                                                    echo $comma;
                                                                                                }
                                                                                                $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                                                echo $cache_time;
                                                                                                $k++;
                                                                                            } echo "," . $post['other_education'];
                                                                                        }
                                                                                        ?>     

                                                                                    </span>
                                                                                </li>

                                                                                <?php
                                                                            } else {
                                                                                ?>

                                                                                <li><b>Education Required</b><span>
                                                                                <?php echo PROFILENA; ?>
                                                                                    </span>
                                                                                </li>
        <?php }
        ?>                   <li><b>Employment Type</b><span>


                                                                                        <?php if ($post['emp_type'] != '') { ?>
                                                                                        <pre>
                                                                                        <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?></pre>
                                                                                        <?php
                                                                                    } else {
                                                                                        echo PROFILENA;
                                                                                    }
                                                                                    ?> 

                                                                                </span>
                                                                            </li>

                                                                            <li><b>Company Profile</b><span>


                                                                                        <?php if ($post['re_comp_profile'] != '') { ?>
                                                                                        <pre>
                                                                                        <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                                                        <?php
                                                                                    } else {
                                                                                        echo PROFILENA;
                                                                                    }
                                                                                    ?> 

                                                                                </span>
                                                                            </li>


                                                                        </ul>
                                                                    </div>

                                                                    <div class="profile-job-profile-button clearfix">
                                                                        <div class="profile-job-details col-md-12">
                                                                            <ul><li class="job_all_post ">
                                                                                <li class="job_all_post last_date">
                                                                                    Last Date :
                                                                                    <?php
                                                                                    if ($post['post_last_date'] != "0000-00-00") {
                                                                                        echo date('d-M-Y', strtotime($post['post_last_date']));
                                                                                    } else {
                                                                                        echo PROFILENA;
                                                                                    }
                                                                                    ?>
                                                                                </li>                                                                                                           </li>
                                                                                <li class=fr>


                                                                                    <a href="javascript:void(0);" onClick="login_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  button" title="applypost"> Apply</a>
                                                                                </li> 
                                                                                <li>
                                                                                    <!--<a  href="javascript:void(0);" onclick="login_profile();" class="savedpost> button">Save</a>-->

                                                                                </li>                        
                                                                            </ul>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <!--.........AJAX DATA END......-->           
                                               <!--<div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>-->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php } ?>
                            <!--recommen candidate end-->
                        </div>  

                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                             <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="All">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>" title="job">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>" title="recruiter">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>" title="freelancer">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" title="business-profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>" title="artist">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        

                    </div>
                </div>
            </div>
        </section>
        <!-- Model Popup Open -->
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->

        <!--footer>        
<?php //echo $footer;      ?>
        </footer-->

        <!-- Login  -->
        <div class="modal fade login" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form" id="login_form" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login" id="email_login" class="form-control input-sm" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin"></div> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_login" id="password_login" class="form-control input-sm" placeholder="Password*">
                                            <div id="error1" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('errorpass')) {
                                                    echo $this->session->flashdata('errorpass');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorpass"></div> 
                                        </div>

                                        <p class="pt-20 ">
                                            <button class="btn1" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn" title="Forgot Password ?">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();" title="Create an account">Create an account</a>
                                        </p>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Login -->

        <!-- Login  For Apply Post-->
        <div class="modal fade login" id="login_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form_apply" id="login_form_apply" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login_apply" id="email_login_apply" class="form-control input-sm email_login" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin_apply"></div> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_login_apply" id="password_login_apply" class="form-control input-sm password_login" placeholder="Password*">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">

                                            <div id="error1" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('errorpass')) {
                                                    echo $this->session->flashdata('errorpass');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorpass_apply"></div> 
                                        </div>

                                        <p class="pt-20 ">
                                            <button class="btn1" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn" title="Forgot Password ?">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();" title="Create an account">Create an account</a>
                                        </p>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Login -->

        <!-- model for forgot password start -->
        <div class="modal fade login" id="forgotPassword" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div id="forgotbuton"></div> 
                                    <div class="title">
                                        <h1 class="ttc">Forgot Password</h1>
                                    </div>
                                    <?php
                                    $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                                    echo form_open('profile/forgot_password', $form_attribute);
                                    ?>
                                    <div class="form-group">
                                        <input type="email" value="" name="forgot_email" id="forgot_email" class="form-control input-sm" placeholder="Email Address*">
                                        <div id="error2" style="display:block;">
                                            <?php
                                            if ($this->session->flashdata('erroremail')) {
                                                echo $this->session->flashdata('erroremail');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorlogin"></div> 
                                    </div>

                                    <p class="pt-20 text-center">
                                        <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:105px; margin:0px auto;" /> 
                                    </p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- model for forgot password end -->

        <!-- register -->

        <div class="modal fade register-model login" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                <div class="title"><h1>Signup first and register in job profile</h1></div>
                                <div class="main-form">
                                    <form role="form" name="register_form" id="register_form" method="post">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="5" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="6" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="7" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="8" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <span> <select tabindex="9" class="day" name="selday" id="selday">
                                                    <option value="" disabled selected value>Day</option>
                                                    <?php
                                                    for ($i = 1; $i <= 31; $i++) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select></span>
                                            <span>
                                                <select tabindex="10" class="month" name="selmonth" id="selmonth">
                                                    <option value="" disabled selected value>Month</option>
                                                    //<?php
//                  for($i = 1; $i <= 12; $i++){
//                  
                                                    ?>
                                                    <option value="1">Jan</option>
                                                    <option value="2">Feb</option>
                                                    <option value="3">Mar</option>
                                                    <option value="4">Apr</option>
                                                    <option value="5">May</option>
                                                    <option value="6">Jun</option>
                                                    <option value="7">Jul</option>
                                                    <option value="8">Aug</option>
                                                    <option value="9">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                    //<?php
//                  }
//                  
                                                    ?>
                                                </select></span>
                                            <span>
                                                <select tabindex="11" class="year" name="selyear" id="selyear">
                                                    <option value="" disabled selected value>Year</option>
                                                    <?php
                                                    for ($i = date('Y'); $i >= 1900; $i--) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>

                                                </select>
                                            </span>
                                        </div>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                        <div class="form-group gender-custom">
                                            <span><select tabindex="12" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                    <option value="" disabled selected value>Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select></span>
                                        </div>

                                        <p class="form-text">
                                            By Clicking on create an account button you agree our
                                            <a href="<?php echo base_url('main/terms-and-condition'); ?>" title="Terms and Condition">Terms and Condition</a> and <a href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="13" class="btn1">Create an account</button>
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a tabindex="12" id ="postid" onClick="login_profile_apply()" href="javascript:void(0);" title="Log In"> Log In </a>
                                            </p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register -->

        <!-- register for apply start-->

        <div class="modal fade register-model login" id="register_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="col-md-12 col-sm-12">
                                <h4>Join Aileensoul - It's Free</h4>
                                <div class="main-form">
                                    <form role="form" name="register_form" id="register_form" method="post">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="5" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="6" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="7" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="8" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <select tabindex="9" class="day" name="selday" id="selday">
                                                <option value="" disabled selected value>Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <select tabindex="10" class="month" name="selmonth" id="selmonth">
                                                <option value="" disabled selected value>Month</option>
                                                //<?php
//                  for($i = 1; $i <= 12; $i++){
//                  
                                                ?>
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                                <option value="3">Mar</option>
                                                <option value="4">Apr</option>
                                                <option value="5">May</option>
                                                <option value="6">Jun</option>
                                                <option value="7">Jul</option>
                                                <option value="8">Aug</option>
                                                <option value="9">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                                //<?php
//                  }
//                  
                                                ?>
                                            </select>
                                            <select tabindex="11" class="year" name="selyear" id="selyear">
                                                <option value="" disabled selected value>Year</option>
                                                <?php
                                                for ($i = date('Y'); $i >= 1900; $i--) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>

                                        </div>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                        <div class="form-group gender-custom">
                                            <select tabindex="12" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>

                                        <p class="form-text">
                                            By Clicking on create an account button you agree our<br class="mob-none">
                                            <a href="<?php echo base_url('main/terms-and-condition'); ?>" title="Terms and Condition">Terms and Condition</a> and <a href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="13" class="btn1">Create an account</button>
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register for apply end -->

        <!-- script for skill textbox automatic start-->
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <?php
        } else {
            ?>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/bootstrap_validate.min.js?ver=' . time()); ?>"></script>
<?php } ?>



        <script>

                                                var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                                var base_url = '<?php echo base_url(); ?>';
                                                var skill = '<?php echo $this->input->get('skills'); ?>';
                                                var place = '<?php echo $this->input->get('searchplace'); ?>';
                                                var postslug = '<?php echo $this->uri->segment(3); ?>';


        </script>

        <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/all_post_login.js?ver=' . time()); ?>"></script>
        <?php }else{?>
 <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/all_post_login.js?ver=' . time()); ?>"></script>
        <?php }?>
        <script>

        </script>
    </body>
</html>