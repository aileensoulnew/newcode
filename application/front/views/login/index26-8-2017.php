<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Find the Best Jobs, Hiring, Freelance for Free | Grow Business Network - Aileensoul.com</title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>">
        <meta charset="utf-8">
        <meta name="description" content="Aileensoul provides best opportunity where you can Hire, Recruit, Freelance, Business and find or search jobs of your preference in your required field." />
        <meta name="keywords" content="Hire Freelancers, Freelance Jobs Online, Find Freelance Work, Freelance Jobs, Get Online Work, online freelance jobs, freelance websites, freelance portal, online freelance work, freelance job sites, freelance consulting jobs, hire freelancers online, best freelancing sites, online writing jobs for beginners, top freelance websites, freelance marketplace, jobs, Job search, job vacancies, Job Opportunities in India, jobs in India, job openings, Jobs Recruitment, Apply For Jobs, Find the right Job, online job applications, apply for jobs online, online job search, online jobs india, job posting sites, job seeking sites, job search websites, job websites in india, job listing websites, jobs hiring, how to find a job, employment agency, employment websites, employment vacancies, application for employment, employment in india, searching for a job, job search companies, job search in india, best jobs in india, job agency, job placement agencies, how to apply for a job, jobs for freshers, job vacancies for freshers, recruitment agencies, employment agencies, job recruitment, hiring agencies, hiring websites, recruitment sites, corporate recruiter, career recruitment, online recruitment, executive recruiters, job recruiting companies, online job recruitment, job recruitment agencies, it, recruitment agencies, recruitment websites, executive search firms, sales recruitment agencies, top executive search firms, recruitment services, technical recruiter, recruitment services, job recruitment agency, recruitment career" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <link rel="stylesheet" href="css/common-style.css">
        <link rel="stylesheet" href="css/style-main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
    </head>
    <body>
        <div class="main-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                        </div>
                        <div class="col-md-8 col-sm-9">
                            <div class="btn-right pull-right">
                                <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="middle-main">
                <div class="container">
                    <div class="form-pd row">
                        <div class="inner-form login-frm">
                            <div class="login">
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
                                        <a href="javascript:void(0)" id="myBtn">Forgot Password ?</a>
                                    </p>
                                    <p class="pt15 text-center">
                                        Don't have an account? <a href="<?php echo base_url('registration'); ?>">Create an account</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- model for forgot password start -->
            <div id="myModal" class="modal">
                <div class="modal-content md-2">
                    <?php
                    $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                    echo form_open('profile/forgot_password', $form_attribute);
                    ?>
                    <div class="modal-header" style="width: 100%; text-align: center;">
                        <span class="close">&times;</span>
                        <label style="color: #1b8ab9;">Forgot Password</label>
                    </div>
                    <div class="modal-body" style="    width: 100%;
                         text-align: center;">
                        <label  style="margin-bottom: 15px; color: #5b5b5b;"> Enter your e-mail address below to get your password.</label>
                        <input style="" type="text" name="forgot_email" id="forgot_email" placeholder="Email Address*" autocomplete="off" class="form-control placeholder-no-fix">
                    </div>
                    <div class="modal-footer ">
                        <div class="submit_btn text-center">              
                            <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" /> 
                        </div>
                    </div>
                    <?php echo $form_close; ?>

                </div>
            </div>
            <!-- model for forgot password end -->
            <?php echo $login_footer; ?>
        </div>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.min.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/login/index.js'); ?>"></script>
    </body>
</html>