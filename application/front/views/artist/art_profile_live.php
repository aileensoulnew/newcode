<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 

        <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />    

            <?php }else{?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />    


            <?php }?>  
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
        </style>

    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push no-login">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_data();" class="btn2" title="Login">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3" title="Create an account">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <?php echo $artistic_common_profile; ?>
            <div class="text-center tab-block">
                <div class="container mob-inner-page">
                    <a href="javascript:void(0);" onclick="login_profile();" title="Photo">
                        Photo
                    </a>
                    <a href="javascript:void(0);" onclick="login_profile();" title="Video">
                        Video
                    </a>
                    <a href="javascript:void(0);" onclick="login_profile();" title="Audio">
                        Audio
                    </a>
                    <a href="javascript:void(0);" onclick="login_profile();" title="Pdf">
                        PDf
                    </a>
                </div>
            </div>
        <div class="user-midd-section art-inner">
            <div class="container">
    <div class="col-md-3"></div>
    <div class="col-md-7 col-sm-12 col-xs-12 mob-plr0">
        <div class="common-form">
            <div class="job-saved-box">
                <h3>Details</h3>
                <div class=" fr rec-edit-pro">
<?php
$userid = $this->session->userdata('aileenuser');

if ($artisticdata[0]['user_id'] === $userid) {
    ?>
    <ul>
    </ul>
<?php } ?>
                </div> 
                <div class="contact-frnd-post">
                    <div class="job-contact-frnd ">
                        <div class="profile-job-post-detail clearfix">
                            <div class="profile-job-post-title clearfix">
                                <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-details">
                                        <ul>
                                            <li>
            <p class="details_all_tital "> Basic Information</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="profile-job-profile-menu">
                                    <ul class="clearfix">
                                        <li> <b>First Name</b> <span> <?php echo $artisticdata[0]['art_name']; ?> </span>
                                        </li>
                                        <li> <b>Last Name</b> <span> <?php echo $artisticdata[0]['art_lastname']; ?> </span>
                                        </li>
                                        <li> <b>Email </b><span> <?php echo $artisticdata[0]['art_email']; ?> </span>
                                        </li>
                                         <?php if($artisticdata[0]['art_phnno']){ ?>
                                            <li><b> Phone Number</b> <span><?php echo $artisticdata[0]['art_phnno']; ?></span> </li>
                                            <?php } else {
           if($artisticdata[0]['user_id'] == $userid){ 
                  ?>  
      <li><b>Phone Number</b> <span>
             <?php echo PROFILENA;?></span></li><?php  }else{}?>               
          <?php }?>
                                    </ul>
                                </div>
                                <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                        <div class="profile-job-details">
                                            <ul>
                                                <li>
                    <p class="details_all_tital ">Contact Address</p>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="profile-job-profile-menu">
                                        <ul class="clearfix">
                                            <li> <b> Country</b> <span> <?php echo $this->db->select('country_name')->get_where('countries', array('country_id' => $artisticdata[0]['art_country']))->row()->country_name; ?> </span>
                                            </li>
                                            <li> <b>State </b><span> <?php echo
$this->db->select('state_name')->get_where('states', array('state_id' => $artisticdata[0]['art_state']))->row()->state_name;
?> </span>
<?php if($artisticdata[0]['art_city']){?>
                                        </li>
                                            <li><b> City</b> <span><?php echo
$this->db->select('city_name')->get_where('cities', array('city_id' => $artisticdata[0]['art_city']))->row()->city_name;
?></span> </li>
<?php }  else {
           if($artisticdata[0]['user_id'] == $userid){ 
                  ?>  
      <li><b> City</b> <span>
             <?php echo PROFILENA;?></span></li><?php  }else{}?>               
          <?php }?>
    <?php if($artisticdata[0]['art_pincode']){ ?>
                                            <li> <b>Pincode </b><span> <?php echo $artisticdata[0]['art_pincode']; ?></span>
                                            </li>
                                            <?php } else {
           if($artisticdata[0]['user_id'] == $userid){ 
                  ?>  
      <li><b>Pincode</b> <span>
             <?php echo PROFILENA;?></span></li><?php  }else{}?>               
          <?php }?>
        </ul>
    </div>
                                </div>
                                <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                        <div class="profile-job-details">
                                            <ul>
                                                <li>
             <p class="details_all_tital "> Art Information</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="profile-job-profile-menu">
                                        <ul class="clearfix">
                                            <li> <b>Art category </b> <span>
<?php
            $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $artisticdata[0]['other_skill']))->row()->other_category;

                                    $category = $artisticdata[0]['art_skill'];
                                    $category = explode(',' , $category);

                                    foreach ($category as $catkey => $catval) {
                                       $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                       $categorylist[] = ucwords($art_category);
                                     } 

                                    $listfinal1 = array_diff($categorylist, array('Other'));
                                    $listFinal = implode(',', $listfinal1);
                                       
                                    if(!in_array(26, $category)){
                                     echo $listFinal;
                                   }else if($artisticdata[0]['art_skill'] && $artisticdata[0]['other_skill']){

                                    $trimdata = $listFinal .','.ucwords($art_othercategory);
                                    echo trim($trimdata, ',');
                                   }
                                   else{
                                     echo ucwords($art_othercategory);  
                                  }
 
?>     
</span>
 </li>
                                            <?php if($artisticdata[0]['art_yourart']){ ?>

                                            <li> <b> Speciality in Art </b> <span> <?php echo $artisticdata[0]['art_yourart']; ?> </span>
                                            </li>
                                    <?php }else{
                                      if($artisticdata[0]['user_id'] == $userid){ 
                                      ?>
                                      <li> <b> Speciality in Art </b> <span> <?php echo PROFILENA; ?> </span>
                                            </li>

                                    <?php } else{ ?>

                                    <?php } }?>
                                    
                                <li><b>Attachment</b> 
                                        <span>
                                         <?php
if ($artisticdata[0]['art_bestofmine']) {
    ?>
 <div class="buisness-profile-pic pdf">
    <?php
    $allowespdf = array('pdf'); 
    $filename = $artisticdata[0]['art_bestofmine'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
   ?>

        <a href = "javascript:void(0)" target="_blank" onclick="login_profile();"><i style="color: red; font-size:22px;" class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

          
         </div>
<?php } else {
    echo PROFILENA;
    } ?>
    </span>
    </li>
                                
</ul>
                                    </div>
                                </div> 
                            </div> 
</div> 
</div></div></div>
</div></div></div>
</div>
</section>
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
<!-- Bid-modal-2  -->
 <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                             <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                               <div class="col-md-5">

                               <div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>

                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display: none"></div>
                                    </div>
                                <input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                </form>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>


                <!-- Login  -->
        <div class="modal login fade" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form" id="login_form" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login" id="email_login" autofocus="" class="form-control input-sm" placeholder="Email Address*">
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
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn" title="Forgot Password">Forgot Password ?</a>
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


          <!-- register -->

        <div class="modal fade login register-model" id="register" role="dialog" data-backdrop="static" data-keyboard="false"> 
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                              <div class="title"><h1 class="tlh1">Sign up First and Register in Artistic Profile</h1></div>
                                <form role="form" name="register_form" id="register_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="101" autofocus="" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="102" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input tabindex="103" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                    </div>
                                    <div class="form-group">
                                        <input tabindex="104" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                    </div>
                                    <div class="form-group dob">
                                        <label class="d_o_b"> Date Of Birth :</label>
                                       <span> <select tabindex="105" class="day" name="selday" id="selday">
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
                                        <select tabindex="106" class="month" name="selmonth" id="selmonth">
                                            <option value="" disabled selected value>Month</option>
                                          
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
                                          
?>
                                        </select></span>
                                        <span>
                                        <select tabindex="107" class="year" name="selyear" id="selyear">
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
                                        <span>
                                        <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                            <option value="" disabled selected value>Gender</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select></span>
                                    </div>

                                    <p class="form-text" style="margin-bottom: 10px;">
                                        By Clicking on create an account button you agree our
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>
                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" onclick="login_data();" href="javascript:void(0);" title="Log In"> Log In </a>
                                        </p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Model Popup Close -->
<!-- model for forgot password start -->
    <div class="modal fade login" id="forgotPassword" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body cus-forgot">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div id="forgotbuton"></div> 
                                    <div class="title">
                                       <p class="ttc tlh2">Forgot Password</p>
                                    </div>
                                   <!--  <?php
                                    $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                                    echo form_open('profile/forgot_password', $form_attribute);
                                    ?> -->
                                    <form name="forgot" method="post" class="forgot_password" id="forgot_password">
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

<?php echo $footer; ?>

<!-- script for skill textbox automatic start (option 2)-->

<script>
      var base_url = '<?php echo base_url(); ?>';
      var slug = '<?php echo $artid; ?>';
      var site_url = '<?php echo $get_url; ?>';
</script>


<script>
            function login_profile() {
                $('#register').modal('show');
                 $('body').addClass('modal-open-other'); 
            }
             function login_data() { 
                $('#login').modal('show');
                $('#register').modal('hide');
                 $('body').addClass('modal-open-other'); 

            }
            function register_profile() {
                $('#login').modal('hide');
                $('#register').modal('show');

            }
            function forgot_profile() {
                $('#forgotPassword').modal('show');
                $('#register').modal('hide');
                $('#login').modal('hide');
                $('body').addClass('modal-open-other');   

            }


            $('.modal-close').click(function(e){ 
    $('body').removeClass('modal-open-other'); 
    //$('#login').modal('show');
});
</script>

<script type="text/javascript">
    
    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $('#register').modal('hide');
         $('#login').modal('hide');
        $('#forgotPassword').modal('hide');
         
    }
});

</script>
 <script type="text/javascript">
            function login()
            {
                document.getElementById('error1').style.display = 'none';
            }
            //validation for edit email formate form
            $(document).ready(function () {
                /* validation */
                $("#login_form").validate({
                    rules: {
                        email_login: {
                            required: true,
                        },
                        password_login: {
                            required: true,
                        }
                    },
                    messages:
                            {
                                email_login: {
                                    required: "Please enter email address",
                                },
                                password_login: {
                                    required: "Please enter password",
                                }
                            },
                    submitHandler: submitForm
                });
                /* validation */
                /* login submit */
                function submitForm()
                {

                    var email_login = $("#email_login").val();
                    var password_login = $("#password_login").val();
                    var post_data = {
                        'email_login': email_login,
                        'password_login': password_login,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>login/artistic_check_login',
                        data: post_data,
                        dataType: "json",
                        beforeSend: function ()
                        {
                            $("#error").fadeOut();
                            $("#btn1").html('Login');
                        },
                        success: function (response)
                        {
                            if (response.data == "ok") { 
                                $("#btn1").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" /> &nbsp; Login');
                                if (response.is_artistic == '1') {
                                    window.location = "<?php echo base_url() ?>artist/details/" + site_url;
                                } else {
                                    window.location = "<?php echo base_url() ?>artist";
                                }
                            } else if (response.data == "password") {
                                $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                                document.getElementById("password_login").classList.add('error');
                                document.getElementById("password_login").classList.add('error');
                                $("#btn1").html('Login');
                            } else {
                                $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                                document.getElementById("email_login").classList.add('error');
                                document.getElementById("email_login").classList.add('error');
                                $("#btn1").html('Login');
                            }
                        }
                    });
                    return false;
                }
                /* login submit */
            });



        </script>
        <script>

            $(document).ready(function () {

                $.validator.addMethod("lowercase", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Email Should be in Small Character");

                $("#register_form").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        email_reg: {
                            required: true,
                            email: true,
                            //lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                            remote: {
                                url: "<?php echo site_url() . 'registration/check_email' ?>",
                                type: "post",
                                data: {
                                    email_reg: function () {
                                     
                                        return $("#email_reg").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },
                        },
                        password_reg: {
                            required: true,
                        },
                        selday: {
                            required: true,
                        },
                        selmonth: {
                            required: true,
                        },
                        selyear: {
                            required: true,
                        },
                        selgen: {
                            required: true,
                        }
                    },

                    groups: {
                        selyear: "selyear selmonth selday"
                    },
                    messages:
                            {
                                first_name: {
                                    required: "Please enter first name",
                                },
                                last_name: {
                                    required: "Please enter last name",
                                },
                                email_reg: {
                                    required: "Please enter email address",
                                    remote: "Email address already exists",
                                },
                                password_reg: {
                                    required: "Please enter password",
                                },

                                selday: {
                                    required: "Please enter your birthdate",
                                },
                                selmonth: {
                                    required: "Please enter your birthdate",
                                },
                                selyear: {
                                    required: "Please enter your birthdate",
                                },
                                selgen: {
                                    required: "Please enter your gender",
                                }

                            },
                    submitHandler: submitRegisterForm
                });
                /* register submit */
                function submitRegisterForm()
                {
                    var first_name = $("#first_name").val();
                    var last_name = $("#last_name").val();
                    var email_reg = $("#email_reg").val();
                    var password_reg = $("#password_reg").val();
                    var selday = $("#selday").val();
                    var selmonth = $("#selmonth").val();
                    var selyear = $("#selyear").val();
                    var selgen = $("#selgen").val();

                    var post_data = {
                        'first_name': first_name,
                        'last_name': last_name,
                        'email_reg': email_reg,
                        'password_reg': password_reg,
                        'selday': selday,
                        'selmonth': selmonth,
                        'selyear': selyear,
                        'selgen': selgen,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }


                    var todaydate = new Date();
                    var dd = todaydate.getDate();
                    var mm = todaydate.getMonth() + 1; //January is 0!
                    var yyyy = todaydate.getFullYear();

                    if (dd < 10) {
                        dd = '0' + dd
                    }

                    if (mm < 10) {
                        mm = '0' + mm
                    }

                    var todaydate = yyyy + '/' + mm + '/' + dd;
                    var value = selyear + '/' + selmonth + '/' + selday;


                    var d1 = Date.parse(todaydate);
                    var d2 = Date.parse(value);
                    if (d1 < d2) {
                        $(".dateerror").html("Date of birth always less than to today's date.");
                        return false;
                    } else {
                        if ((0 == selyear % 4) && (0 != selyear % 100) || (0 == selyear % 400))
                        {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) { 
                                if (selday == 31 || selday == 30) {
                                    $(".dateerror").html("This month has only 29 days.");
                                    return false;
                                }
                            }
                        } else {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) {
                                if (selday == 31 || selday == 30 || selday == 29) {
                                    $(".dateerror").html("This month has only 28 days.");
                                    return false;
                                }
                            }
                        }
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>registration/reg_insert',
                        data: post_data,
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            $("#register_error").fadeOut();
                            $("#btn1").html('Create an account');
                        },
                        success: function (response)
                        {
                            if (response.okmsg == "ok") {
                                $("#btn-register").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" /> &nbsp; Sign Up ...');
                                window.location = "<?php echo base_url() ?>artist";
                            } else {
                                $("#register_error").fadeIn(1000, function () {
                                    $("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                                    $("#btn1").html('Create an account');
                                });
                            }
                        }
                    });
                    return false;
                }
            });

        </script>
        <!-- forgot password script end -->
        <script type="text/javascript">
            $(document).ready(function () { 
                /* validation */
                $("#forgot_password").validate({
                    rules: {
                        forgot_email: {
                            required: true,
                            email: true,
                        }

                    },
                    messages: {
                        forgot_email: {
                            required: "Email Address Is Required.",
                        }
                    },

                     submitHandler: submitforgotForm
                });
                /* validation */
                
            });


function submitforgotForm()
{

    var email_login = $("#forgot_email").val();

    var post_data = {
        'forgot_email': email_login,
//            csrf_token_name: csrf_hash
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'profile/forgot_live',
        data: post_data,
        dataType: "json",
        beforeSend: function ()
        {
            $("#error").fadeOut();
//            $("#forgotbuton").html('Your credential has been send in your register email id');
        },
        success: function (response)
        {
            if (response.data == "success") {
                //  alert("login");
                $("#forgotbuton").html(response.message);
                setTimeout(function () {
                    $('#forgotPassword').modal('hide');
                    $('#login').modal('show');
                    $("#forgotbuton").html('');
                    document.getElementById("forgot_email").value = "";
                }, 5000); // milliseconds
                //window.location = base_url + "job/home/live-post";
            } else {
                $("#forgotbuton").html(response.message);

            }
        }
    });
    return false;
}            /* validation */

        </script>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>

<script  src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
<script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>

<?php }else{?>

<script  src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
<script  src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>
<?php }?>
<script>
var base_url = '<?php echo base_url(); ?>';   
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($city_data); ?>;
var slug = '<?php echo $artid; ?>';
</script>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>

<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script  type="text/javascript" src="<?php //echo base_url('assets/js/webpage/artist/details.js?ver='.time()); ?>"></script>

<?php }else{?>

<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script  type="text/javascript" src="<?php // echo base_url('assets/js_min/webpage/artist/details.js?ver='.time()); ?>"></script>
<?php }?>
 <script>
            $(document).on('click', '[data-toggle*=modal]', function () {
                $('[role*=dialog]').each(function () {
                    switch ($(this).css('display')) {
                        case('block'):
                        {
                            $('#' + $(this).attr('id')).modal('hide');
                            break;
                        }
                    }
                });
            });
            $(document).ready(function () {
               // setTimeout(function () {
                    $('#register').modal('show');
                //}, 2000);
            });
        </script>
        
 </body>
</html>
