
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>About Aileensoul.com and its vision and mission....</title>
        <meta name="description" content="Aileensoul.com have something to give this world, Know about us." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php

        if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
            ?>

            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-91486853-1', 'auto');
                ga('send', 'pageview');

            </script>
            <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
            <?php
        }

          if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {

        ?>
        
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-91486853-1', 'auto');
            ga('send', 'pageview');

        </script>
        <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
        <?php
        }
        ?>
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
       

         <?php if (IS_OUTSIDE_CSS_MINIFY == '0'){?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver='.time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver='.time()) ?>">
        <?php }else{?>
         <link rel="stylesheet" href="<?php echo base_url('assets/css_min/common-style.css?ver='.time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()) ?>">
        <?php }?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>

    <body class="about-us" >
        <div class="main-inner">
           <div class="terms-con-cus">
            <header class="terms-con bg-none">
                <div class="overlaay">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-3">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                            </div>
                            <div class="col-md-8 col-sm-9">
                                <div class="btn-right pull-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
                                    <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                    <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="container">
                <div class="cus-about" >
            <section class="">
                <div class="main-comtai">
                    <!-- <h1>Terms and Conditions</h1> -->
                    <h2 class="about-h2">About Us</h2>
                    <p class="about-para" >We provide platform & opportunities to every person in the world to make their career.</p>
                </div>
            </section>
            </div>
            </div>
        </div>
            <section class="middle-main">
                <div class="container">
                    <div class="pt10">
                        <div class="titlea">
                            <h1 class="pb20">About Aileensoul</h1>
                        </div>
                        <div class="about-content">
                          <p>
							<img class="pull-right" src="<?php echo base_url('assets/img/about-1.jpg') ?>">
                            Founded in 2017, Aileensoul is a new age portal that amalgamates a variety of career-oriented services into a single unified platform with an aim to address the needs of  jobseekers, recruiters, business professionals, freelancers and artists - all under one roof! Introduced to fulfil one of the most fundamental and important aspects of an individual’s life - one’s desire to land a rewarding and successful career for himself or herself - Aileensoul’s futuristic platform serves to launch and advance the careers of first-time jobseekers, experienced business professionals/consultants and upcoming/veteran artists. 
                         </p>    
                        
                            <p>
                            Whether you are looking to grow your business network or searching for a reliable job portal to explore vacancies in leading companies and reputed firms, Aileensoul caters to all your needs. We celebrate talent in every form and continue to innovate features and offerings that help individuals like you showcase their unique capabilities, talent and art to the global community that exists on our platform.  
                            </p>
                            <p>
                            All our niche profiles have been thoughtfully designed to touch upon every possible aspect that can influence your career progression - be it full-time/freelance job search, networking, real-time collaboration with recruiters or a platform to showcase your skills and arouse the interest of potential clients or companies.
                            </p>
                        </div>
                       <!--  <p class="text-center"><img src="<?php //echo base_url('assets/img/message.png'); ?>"></p> -->
                        <!-- <div class="text-center">
                            <ul class="mail-sent">
                                <li><a title="Email us" href="mailto:hr@aileensoul.com">hr@aileensoul.com</a></li>
                                <li><a title="Email us" href="mailto:info@aileensoul.com">info@aileensoul.com</a></li>
                                <li><a title="Email us" href="mailto:inquiry@aileensoul.com">inquiry@aileensoul.com</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                    <div class="container">
                    <div class="pt10">
                        <div class="titlea">
                            <h1 class="pb20">Our Mission</h1>
                        </div>
                        <div class="about-content">
						<img style="width:100%;" src="<?php echo base_url('assets/img/about-2.jpg') ?>">
                            <p>
                            Social and economic upliftment of people is a key contributor to the all-round progress of a nation. Aileensoul endeavours to impact this very aspect of socio-economic development through creation of employment opportunities for the country’s youth and helping eradicate unemployment and poverty, not just from India but also from the world. 
                        </p>
                        <p>
                         We believe that every individual has the right to a better tomorrow and a prospering career is one its founding stones. At Aileensoul, we strive to remove the man-made barriers of bureaucracy by enabling individuals and professionals to connect and collaborate in a transparent and independent manner.
                        </p>   
                        </div>
                       
                    </div>
                </div>

                 <div class="container">
                    <div class="pt10">
                        <div class="titlea">
                            <h1 class="pb20">Our Vision</h1>
                        </div>
                        <div class="about-content text-center">
							<img style="width:100%;" src="<?php echo base_url('assets/img/about-3.jpg') ?>">
                                We aspire to become a one-stop destination for career enthusiasts from various walks of life and with diverse experience and educational backgrounds.                              

                        </div>
                       
                    </div>
                </div>
       <div class="container" >
                    <div class="pt10">
                        <div class="titlea">
                            <h1 class="pb20">Our Team</h1>
                        </div>
                       <div class="about-content text-center">
					   <img style="width:100%;" src="<?php echo base_url('assets/img/about-4.jpg') ?>" alt="aboutus-image">
                           Coming together is a beginning, staying together is progress, and working together is success.<br>
                    -Henry Ford 
                        </div>
                        <div class="all-tem">
                           <ul class="new-abput-page">
							<li class="img-custom">
                           
                                 <div class="text-custom">
                                    <h4>Dhaval Shah</h4>
                                    <p>CEO</p>
                                </div>
                             </li>
                            <li class="img-custom">
                           
                                 <div class="text-custom">
                                    <h4>Nisha Raj</h4>
                                    <p>Content Head</p>
                                </div>
                             </li>

                             <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Yatin Belani</h4>
                                    <p>Project Manager</p>
                                </div>
                             </li>

                             <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Shashwat Barbhaya</h4>
                                    <p>Business Manager</p>
                                </div>
                             </li>

                             <li class="img-custom">
                                
                                 <div class="text-custom">
                                    <h4>Himanshu Sadadiya</h4>
                                    <p>AWS Architect/Devops Expert</p>
                                </div>
                             </li>

                             <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Ankit Makadiya</h4>
                                    <p>Technical Head</p>
                                </div>
                             </li>

                             <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Khyati Raval </h4>
                                    <p>Sr. Web Developer</p>
                                </div>
                             </li>

                             <li class="img-custom">
                              
                                 <div class="text-custom">
                                    <h4>Nikunj Bhalodiya </h4>
                                    <p>Software Tester</p>
                                </div>
                             </li>

                                <li class="img-custom">
                              
                                 <div class="text-custom">
                                    <h4>Harshad Patoliya</h4>
                                    <p>Sr. Web Designer</p>
                                </div>
                             </li>

                             <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Prashant Dadhaniya</h4>
                                    <p>Sr. SEO Executive</p>
                                </div>
                             </li>

                                <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Jay Patel</h4>
                                    <p>Jr. SEO Executive</p>
                                </div>
                             </li>

                             <li class="img-custom">
                               
                                 <div class="text-custom">
                                    <h4>Pallavi Panaliya</h4>
                                    <p>Jr. Web Developer</p>
                                </div>
                             </li> 
								<li class="img-custom">
                               
									 <div class="text-custom">
										<h4>Dhaval Shah</h4>
										<p>Jr. Web Designer</p>
									</div>
								</li> 	
								<li class="img-custom">
                               
									 <div class="text-custom">
										<h4>Falguni Tank</h4>
										<p>Jr. Web Developer</p>
									</div>
								</li> 								
                             </ul>


                        </div>
                    </div>
                </div>
            </section>
            <?php echo $login_footer ?>
        </div>
       <?php if (IS_OUTSIDE_JS_MINIFY == '0'){?>
        <script src="<?php echo base_url('assets/js/webpage/aboutus.js'); ?>"></script>
        <?php }else{?>
        <script src="<?php echo base_url('assets/js_min/webpage/aboutus.js'); ?>"></script>
        <?php }?>
    </body>
</html>