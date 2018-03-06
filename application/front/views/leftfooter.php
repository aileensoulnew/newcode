<div class="custom_footer_left fullwidth">
    <div class="fl">
        <ul class="cus-full1">
            <li><a href="<?php echo base_url('about-us'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> About Us </a></li>

            <li><a href="<?php echo base_url('contact-us'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Contact Us</a></li>
            <?php
            if (!$this->session->userdata('aileenuser')) {
                ?>
                <li><a title="Sitemap" href="<?php echo base_url('sitemap'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Sitemap</a></li>
                <?php
            }
            ?>
            <li><a href="<?php echo base_url('privacy-policy'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Privacy Policy</a></li>
        </ul>
        <ul class="cus-full2">
            <li><a href="<?php echo base_url('terms-and-condition'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Terms &amp; Condition </a></li>
            <li><a title="Disclaimer Policy" href="<?php echo base_url('disclaimer-policy'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Disclaimer Policy</a></li>
            <li><a href="<?php echo base_url('blog'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Blog</a></li>
        </ul>
        <ul class="cus-full2">


            <li><a href="<?php echo base_url('feedback'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Send Us Feedback</a></li>
            <li><a href="<?php echo base_url('advertise-with-us'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Advertise With Us</a></li>

            <li><a id="trigger" class="click-profiles" style="" href="javascript:void(0)"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Profiles <i class="fa fa-sort-asc" aria-hidden="true"></i></a>
                <div class="click-nav"><ul id="drop" class="left-ftr-profiles">
                        <li><a href="<?php echo base_url('how-to-use-job-profile-in-aileensoul'); ?>" target="_blank">        Job Profiles</a></li>
                        <li><a href="<?php echo base_url('how-to-use-recruiter-profile-in-aileensoul'); ?>" target="_blank">Recruiter Profile</a></li>
                        <li><a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>" target="_blank">Freelance Profile</a></li>
                        <li><a href="<?php echo base_url('how-to-use-business-profile-in-aileensoul'); ?>" target="_blank">Business Profile</a></li>
                        <li><a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>" target="_blank">Artistic Profile</a></li>
                    </ul></div>
            </li>
        </ul>
    </div>
</div>


<script>
    $('#trigger').click(function (event) {
        event.stopPropagation();
        $('#drop').toggle();
    });

    $(document).click(function () {
        $('#drop').hide();
    });
</script>