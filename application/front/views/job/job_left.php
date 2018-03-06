<div class="col-lg-3 col-md-4 col-sm-4">
   <div class="left-side-bar">
      <ul class="left-form-each">
         <?php if($this->uri->segment(2) == 'basic-information')
            {
            ?>
         <li class="active init"><a href="javascript:void(0)">Basic Information</a></li>
         <?php
            }
            else
            {
            ?>
         <li class="custom-none "><a href="<?php echo base_url('job/basic-information'); ?>">Basic Information</a></li>
         <?php
            }
            ?>
         <?php if($this->uri->segment(2) == 'qualification')
            {
            ?>
         <li class="active init"><a href="javascript:void(0)">Educational Qualification</a></li>
         <?php
            }
            else
            {
            ?>
         <li class="custom-none "><a href="<?php echo base_url('job/qualification'); ?>">Educational Qualification</a></li>
         <?php
            }
            ?>
         <?php if($this->uri->segment(2) == 'project')
            {
            ?>
         <li class="active init"><a href="javascript:void(0)">Project And Training / Internship</a></li>
         <?php
            }
            else
            {
            ?>
         <li class="custom-none "><a href="<?php echo base_url('job/project'); ?>">Project And Training / Internship</a></li>
         <?php
            }
            ?>
         <?php if($this->uri->segment(2) == 'work-area')
            {
            ?>
         <li class="active init"><a href="javascript:void(0)">Work Area</a></li>
         <?php
            }
            else
            {
            ?>
         <li class="custom-none "><a href="<?php echo base_url('job/work-area'); ?>">Work Area</a></li>
         <?php
            }
            ?>
         <?php if($this->uri->segment(2) == 'work-experience')
            {
            ?>
         <li class="active init"><a href="javascript:void(0)">Work Experience</a></li>
         <?php
            }
            else
            {
            ?>
         <li class="custom-none "><a href="<?php echo base_url('job/work-experience'); ?>">Work Experience</a></li>
         <?php
            }
            ?>
      </ul>
   </div>
</div>