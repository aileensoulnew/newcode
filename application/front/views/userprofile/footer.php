<?php
if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'main' || $this->uri->segment(1) == 'profiles' ) {
    ?>
    <footer class="footer">
        <?php
    } else {
        ?>
        <footer>    
            <?php
        }
        ?>
        <div class="container pt20">
            <div class="row">

                <div class="fw text-center">
                    <ul class="footer-ul">
                        <?php
                        if (!$this->session->userdata('aileenuser')) {
                            ?>
                            <li><a title="Login" href="<?php echo base_url('login'); ?>" target="_blank">Login</a></li>
                            <li><a title="Create an Account" href="<?php echo base_url('registration'); ?>" target="_blank">Create an Account</a></li>
                            <?php
                        }
                        ?>

                        <li><a title="Job Profile" href="<?php echo base_url('how-to-use-job-profile-in-aileensoul'); ?>" target="_blank">Job Profiless</a></li>
                        <li><a title="Recruiter Profile" href="<?php echo base_url('how-to-use-recruiter-profile-in-aileensoul'); ?>" target="_blank">Recruiter Profile</a></li>
                        <li><a title="Freelance Profile" href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>" target="_blank">Freelance Profile</a></li>
                        <li><a title="Business Profile" href="<?php echo base_url('how-to-use-business-profile-in-aileensoul'); ?>" target="_blank">Business Profile</a></li>
                        <li><a title="Artistic Profile" href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>" target="_blank">Artistic Profile</a></li>
                        <li><a title="About Us" href="<?php echo base_url('about-us'); ?>"  target="_blank">About Us</a></li>
                        <li><a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" target="_blank">Terms and Condition</a></li>
                        <li><a href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy" target="_blank">Privacy Policy</a></li>
                        <li><a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>"  target="_blank">Disclaimer Policy</a></li>
                        <li><a title="Contact Us" href="<?php echo base_url('contact-us'); ?>"  target="_blank">Contact Us</a></li>
                        <li><a title="Blog" href="<?php echo base_url('blog'); ?>" target="_blank">Blog</a></li>
                        <li><a title="Send Us Feedback" href="<?php echo base_url('feedback'); ?>" target="_blank">Send Us Feedback</a></li>
                        <?php
                        if (!$this->session->userdata('aileenuser')) {
                            ?>
                            <li><a title="Sitemap" tabindex="0" href="<?php echo base_url('sitemap'); ?>" target="_blank">Sitemap</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="ftr-copuright text-center pt10 pb20 fw">
                    <span>    &#9400; 2018 | by Aileensoul </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- IMAGE PRELOADER SCRIPT -->
    <script type="text/javascript">
        /*$.fn.preload = function (fn) {
            var len = this.length, i = 0;
            return this.each(function () {
                var tmp = new Image, self = this;
                if (fn)
                    tmp.onload = function () {
                        fn.call(self, 100 * ++i / len, i === len);
                    };
                tmp.src = this.src;
            });
        };

        $('img').preload(function (perc, done) {
            console.log(this, perc, done);
        }); */
    </script>
    <!-- IMAGE PRELOADER SCRIPT -->