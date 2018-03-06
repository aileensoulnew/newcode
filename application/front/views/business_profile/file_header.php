<div class="top-tab">
    <ul class="nav nav-tabs tabs-left remove_tab">
        <li <?php if($this->uri->segment(2) == 'photos'){ echo 'class="active"'; } ?>> <a href="<?php echo base_url('business-profile/photos/' . $business_common_data[0]['business_slug']) ?>"><i class="fa fa-camera" aria-hidden="true"></i>   Photos</a></li>
        <li <?php if($this->uri->segment(2) == 'videos'){ echo 'class="active"'; } ?>><a href="<?php echo base_url('business-profile/videos/' . $business_common_data[0]['business_slug']) ?>"><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</a></li>
        <li <?php if($this->uri->segment(2) == 'audios'){ echo 'class="active"'; } ?>><a href="<?php echo base_url('business-profile/audios/' . $business_common_data[0]['business_slug']) ?>"><i class="fa fa-music" aria-hidden="true"></i>  Audio</a></li>
        <li <?php if($this->uri->segment(2) == 'pdf'){ echo 'class="active"'; } ?>><a href="<?php echo base_url('business-profile/pdf/' . $business_common_data[0]['business_slug']) ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  Pdf</a></li>
    </ul>
</div>