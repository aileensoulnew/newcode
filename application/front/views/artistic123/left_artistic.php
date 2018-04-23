
         <div class="full-box-module">
            <div class="profile-boxProfileCard  module">
               <div class="profile-boxProfileCard-cover">
                  <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo site_url('artistic/dashboard'); ?>" tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>">
                     <?php if ($artisticdata[0]['profile_background']) { ?>
                     <div class="data_img">
                     <?php 

if (!file_exists($this->config->item('art_bg_thumb_upload_path') . $artisticdata[0]['profile_background'])) {
  ?>
             <div class="bg-images no-cover-upload"><img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>"  ></div>
                     
                     <?php }else{?>
                     <img src="<?php echo base_url($this->config->item('art_bg_thumb_upload_path') . $artisticdata[0]['profile_background']); ?>" alt ="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>" class="bgImage"  >
                     <?php }?>
                     </div>
                     <?php } else { ?>
                     <div class="data_img">
                       <div class="bg-images no-cover-upload">
                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>"  ></div>
                     </div>
                     <?php } ?>
                  </a>
               </div>
               <div class="profile-boxProfileCard-content clearfix">
                  <div class="left_side_box_img buisness-profile-txext">
                     <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo site_url('artistic/dashboard'); ?>" title="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                        <!-- box image start -->
                       
                        <div class="data_img_2"> 

                      <?php 


                      if (IMAGEPATHFROM == 'upload') { 

                                  if($artisticdata[0]['art_user_image']){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="">
                                   <?php } } else{?>
                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                <?php } } else{  

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                    if ($info) { ?>
                        <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>" class="bgImage"  alt="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>" >
                                                                <?php
                                                            } else { ?>

                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                              <?php } }?>
                        </div>
                        
                        <!-- box image end -->
                     </a>
                  </div>
                  <div class="right_left_box_design ">
                     <span class="profile-company-name ">
                     <a   href="<?php echo site_url('artistic/dashboard'); ?>"> <?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?></a>
                     </span>
                    
                     <div class="profile-boxProfile-name">
                        <a  href="<?php echo site_url('artistic/dashboard'); ?>">
                        <?php
                           if ($artisticdata[0]['designation']) {
                               echo ucfirst(strtolower($artisticdata[0]['designation']));
                           } else {
                               echo "Current Work";
                           }
                           ?>
                        </a>
                     </div>
                     <ul class=" left_box_menubar">
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'art_savepost') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Dashboard" href="<?php echo base_url('artistic/dashboard'); ?>"> Dashboard</a>
                        </li>
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a title="Followers" href="<?php echo base_url('artistic/followers'); ?>">Followers <br>(<?php echo $flucount; ?>)</a>
                        </li>
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a class="padding_less_right"  title="Following" href="<?php echo base_url('artistic/following'); ?>">Following<br><div id="countfollow">(<?php echo $countfr; ?>)</div></a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
           