<div class="sm-header">
    <header class="terms-con bg-none">
        <div class="overlaay">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                    </div>
                    <div class="col-md-8 col-sm-9">
                        <div class="btn-right pull-right">
                            <?php if (!$this->session->userdata('aileenuser')) { ?>
                                <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="site-map-all-profile cust-site">
        <div class="container">
            <h1 class="text-center"><a href="<?php echo base_url('sitemap') ?>"> Sitemap </a></h1>
            <div class="fw text-center">
                <ul>
                    <li><a href="<?php echo base_url('sitemap/job-profile') ?>" class="<?php if($this->uri->segment(2) == 'job-profile'){ echo 'sitemap_active'; } ?>">Job Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/recruiter-profile') ?>" class="<?php if($this->uri->segment(2) == 'recruiter-profile'){ echo 'sitemap_active'; } ?>">Recruiter Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/freelance-profile') ?>" class="<?php if($this->uri->segment(2) == 'freelance-profile'){ echo 'sitemap_active'; } ?>">Freelance Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/business-profile') ?>" class="<?php if($this->uri->segment(2) == 'business-profile'){ echo 'sitemap_active'; } ?>">Business Profile</a></li>
                    <li><a href="<?php echo base_url('sitemap/artistic-profile') ?>" class="<?php if($this->uri->segment(2) == 'artistic-profile'){ echo 'sitemap_active'; } ?>">Artistic Profile</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>