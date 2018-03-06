<div class="col-md-3 col-sm-3">
    <div class="job-profile-left-side-bar">
        <div class="left-side-bar">
            <ul>
                <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'freelancer-details' || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'saved-projects' || $this->uri->segment(2) == 'applied-projects') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'home')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-work/home'); ?>">Home</a>
                    </li>
                <?php } ?>
                <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'freelancer-details')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-work/freelancer-details'); ?>"><?php echo $this->lang->line("freelancer_work_profile"); ?></a>
                </li>
                <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'freelancer-details' || $this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'saved-projects' || $this->uri->segment(2) == 'applied-projects') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>
                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'saved-projects')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-work/saved-projects'); ?>"><?php echo $this->lang->line("saved_freelancer"); ?></a>
                    </li>
                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'applied-projects')) { ?> class="active" <?php } ?>><a href="<?php echo base_url('freelance-work/applied-projects'); ?>"><?php echo $this->lang->line("applied_freelancer"); ?>freelancer_work_profile</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>