<!DOCTYPE html>
<html lang="en" ng-app="artistApp" ng-controller="artistController">
    <head>
        <title>Aileensoul</title>
        <meta charset="utf-8">
           <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">

    </head>
    <body class="profile-main-page recruiter-main">
       <?php echo $header_profile; ?>
        
        <div class="middle-section middle-section-banner">
            <div class="search-banner">
                <div class="container">
                    <div class="row banner-main-div">
                        <div class="col-md-6 col-sm-6 banner-left">
                            <h1 class="pb15">Startup India is a revolutionary initiative started</h1><p>Startup India is a revolutionary initiative started</p>
                        </div>
                        <div class="col-md-6 col-sm-6 banner-right">
                            <div class="reg-form-box">
                                <div class="reg-form">
                                    <h3>Welcome in Freelance hire Profile</h3>
                                    <?php echo form_open(base_url('freelancer_hire/hire_registation_insert'), array('id' => 'freelancerhire_regform', 'name' => 'freelancerhire_regform', 'class' => 'clearfix')); ?>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    
                                                     <input type="text" name="firstname" id="firstname" tabindex="1" placeholder="First Name" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" value="<?php echo $userdata['first_name']; ?>" maxlength="35">
                                                    <?php echo form_error('firstname'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="lastname" id="lastname" tabindex="2" placeholder="Last name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name']; ?>" maxlength="35">
                                                        <?php echo form_error('lastname'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="email" name="email_reg1" id="email_reg1" tabindex="3" placeholder="Enter email address" value="<?php echo $userdata['email']; ?>" maxlength="255">
                                                    <?php echo form_error('email_reg1'); ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Company Number">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="country" id="country" tabindex="5">
                                                        <option value="">Select country</option>
                                                        <?php
                                                        if (count($countries) > 0) {
                                                            foreach ($countries as $cnt) {
                                                                ?>
                                                                <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select><span id="country-error"></span>
                                                    <?php echo form_error('country'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="state" id="state" tabindex="6">
                                                        <?php
                                                        if ($state1) {
                                                            foreach ($states as $cnt) {
                                                                ?>
                                                                <option value="<?php echo $cnt['state_id']; ?>" <?php if ($cnt['state_id'] == $state1) echo 'selected'; ?>><?php echo $cnt['state_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        else {
                                                            ?>
                                                            <option value="">Select country first</option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select><span id="state-error"></span>
                                                    <?php echo form_error('state'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select name="city" id="city" tabindex="7">
                                                        <?php
                                                        if ($city1) {
                                                            foreach ($cities as $cnt) {
                                                                ?>
                                                                <option value="<?php echo $cnt['city_id']; ?>" <?php if ($cnt['city_id'] == $city1) echo 'selected'; ?>><?php echo $cnt['city_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        else if ($state1) {
                                                            ?>
                                                            <option value="">Select city</option>
                                                            <?php
                                                            foreach ($cities as $cnt) {
                                                                ?>
                                                                <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value="">Select state first</option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select><span id="city-error"></span>
                                                    <?php echo form_error('city'); ?>
                                                </div>
                                        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea placeholder="Professional Information"></textarea>
                                                </div>
                                        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button class="btn1" id="submit" name="submit" tabindex="9" onclick="return validate();" class="cus_btn_sub">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                                </div>
                                        
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="sub-fix-head">
                <div class="container">
                    <p><span>Lorem ipzum is a dummy text.</span><a class="pull-right btn-1" href="#">Post a Project</a></p>
                </div>
            </div>
            <div class="container pt20">
                <div class="pt20 pb20">
                    <div class="center-title">
                        <h3>What is freelance hire </h3>
                        <p>Lorem ipsum is dummy text</p>
                    </div>
                </div>
                <div class="row pt20 pb20">
                    <div class="col-md-6 col-sm-6 pull-right">
                        <div class="content-img text-center">
                            <img src="n-images/img1.jpg">
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        <p>
                        <br>
                            Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                    </div>
                </div>
                <div class="row pt20 pb20">
                    <div class="col-md-6 col-sm-6">
                        <div class="content-img text-center">
                            <img src="n-images/img1.jpg">
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        <p>
                        <br>
                            Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                    </div>
                </div>
                <div class="row pt20 pb20">
                    <div class="col-md-6 col-sm-6 pull-right">
                        <div class="content-img text-center">
                            <img src="n-images/img1.jpg">
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        <p>
                        <br>
                            Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                    </div>
                </div>
            </div>
            <div class="content-bnr">
                <div class="bnr-box">
                    <img src="n-images/img2.jpg">
                    <div class="content-bnt-text">
                        <h1>Lorem Ipsum is a dummy text</h1>
                        <p><a href="#" class="btn5">Create Recruiter Profile</a></p>
                    </div>
                </div>
            </div>
            <div class="container pt20">
                <div class="pt20 pb20">
                    <div class="center-title">
                        <h3>How it works </h3>
                        <p>Lorem ipsum is dummy text</p>
                    </div>
                </div>
                <div class="it-works-img pt20 pb20">
                    <img src="n-images/img3.jpg">
                </div>
                
                <div class="related-article pt20">
                        <div class="center-title">
                            <h3>Related Article</h3>
                            
                        </div>
                        <div class="row pt10">
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <!--  poup modal  -->
        <div style="display:none;" class="modal fade" id="post-popup1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                    <form>
                        <div class="post-box">
                            <div class="post-img">
                                <img src="img/user-pic.jpg">
                            </div>
                            <div class="post-text">
                                <textarea class="title-text-area" placeholder="Post Opportunity"></textarea>
                            </div>
                            <div class="all-upload">
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </div>
                            <div class="post-box-bottom">
                                <ul>
                                    <li>
                                        <a href="" data-target="#post-popup" data-toggle="modal">
                                            <img src="img/post-op.png"><span>Post Opportunity</span>
                                        </a>
                                    </li>
                                    <li class="pl15">
                                        <a href="article.html">
                                            <img src="img/article.png"><span>Post Article</span>
                                        </a>
                                    </li>
                                    <li class="pl15">
                                        <a href="" data-target="#ask-question" data-toggle="modal">
                                            <img src="img/ask-qustion.png"><span>Ask Quastion</span>
                                        </a>
                                    </li>
                                </ul>
                                <p class="pull-right">
                                    <button type="submit" class="btn1" value="Submit">Post</button>
                                </p>
                            </div>

                        </div>
                        
                        
                        </form>
                    </div>



                </div>
            </div>

        </div>
        <div style="display:none;" class="modal fade" id="post-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                    <form>
                        <div class="post-box">
                            <div class="post-img">
                                <img src="img/user-pic.jpg">
                            </div>
                            <div class="post-text">
                                <textarea class="title-text-area" placeholder="Post Opportunity"></textarea>
                            </div>
                            <div class="all-upload">
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </div>

                        </div>
                        <div class="post-field">
                            
                                <div id="content" class="form-group">
                                    <label>FOR WHOM THIS OPPORTUNITY ?<span class="pull-right"><img src="img/tooltip.png"></span></label>
                                    <textarea rows="1" max-rows="5" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, PHP Developer, HR, BDE, CA, Doctor, Freelancer.." cols="10" style="resize:none"></textarea>

                                </div>
                                <div class="form-group">
                                    <label>WHICH LOCATION?<span class="pull-right"><img src="img/tooltip.png"></span></label>
                                    <textarea type="text" class="" placeholder="Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai, Moscow, Paris, Tokyo.. "></textarea>

                                </div>
                                <div class="form-group">
                                    <label>What is your field?<span class="pull-right"><img src="img/tooltip.png"></span></label>
                                    <select>
                                        <option>What is your field</option>
                                        <option>IT</option>
                                        <option>Teacher</option>
                                        <option>Sports</option>
                                    </select>
                                </div>


                            


                        </div>
                        <div class="text-right fw pt10 pb20 pr15">
                            <button type="submit" class="btn1"  value="Submit">Post</button> 
                        </div>
                        </form>
                    </div>



                </div>
            </div>

        </div>
        <div style="display:none;" class="modal fade" id="ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                    <form>
                        <div class="post-box">
                            <div class="post-img">
                                <img src="img/user-pic.jpg">
                            </div>
                            <div class="post-text">
                                <textarea class="title-text-area" placeholder="Ask Quastion"></textarea>
                            </div>
                            <div class="all-upload">
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Add Screenshot </span></i>
                                    <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 
                                    
                                </label>
                            </div>

                        </div>
                        <div class="post-field">
                            
                                <div class="form-group">
                                    <label>Add Description<span class="pull-right"><img src="img/tooltip.png"></span></label>
                                    <textarea rows="1" max-rows="5" placeholder="Add Description" cols="10" style="resize:none"></textarea>

                                </div>
                                <div class="form-group">
                                    <label>Related Categories<span class="pull-right"><img src="img/tooltip.png"></span></label>
                                    <input type="text" class="" placeholder="Related Categories">

                                </div>
                                <div class="form-group">
                                    <label>From which field the Question asked?<span class="pull-right"><img src="img/tooltip.png"></span></label>
                                    <select>
                                        <option>What is your field</option>
                                        <option>IT</option>
                                        <option>Teacher</option>
                                        <option>Sports</option>
                                    </select>
                                </div>


                            


                        </div>
                        <div class="text-right fw pt10 pb20 pr15">
                            <button type="submit" class="btn1"  value="Submit">Post</button> 
                        </div>
                        </form>
                    </div>



                </div>
            </div>

        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
 <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
         <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/hire_registration.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var app = angular.module('artistApp', ['ui.bootstrap']); 
            var site = '<?php echo base_url(); ?>';
             var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        
        <script src="<?php echo base_url('assets/js/webpage/artist-live/index.js?ver=' . time()) ?>"></script>


    </body>
</html>