<!--post save success pop up style end -->
<header>
   <div class="bg-search">
   <?php if(($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'home')){?>
   <div class="header2 headerborder animated fadeInDownBig">
   <?php  } else {?>
   <div class="header2 headerborder">
      <?php }?>
      <div class="container">
         <div class="row">
            <div class="col-sm-7 col-md-7 col-xs-7 hidden-mob ">
               <div class="job-search-box1 clearfix">
                  <?php echo $job_search; ?>
               </div>
            </div>
            <div class="col-sm-5 col-md-5 col-xs-12 h2-smladd mob-width second_right_header">
               <div class="search-mob-block">
                  <div class="">
                     <a href="#search">
                     <label><i class="fa fa-search" aria-hidden="true"></i></label>
                     </a>
                  </div>
                  <div id="search">
                     <button type="button" class="close">×</button>
                     <form action=<?php echo base_url('job/search')?> method="get">
                        <div class="new-search-input">
                           <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                           <input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="Find Location" />
                           <button type="submit"  id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="">
                  <ul class="" id="dropdownclass">
                     <li id="art_profile" <?php if($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'home'){?> class="active" <?php } ?>><a href="<?php echo base_url('job/home'); ?>" title="Home"><span class="home-22x22-h"></span></a>
                     </li>
                     <!-- Friend Request Start-->
                     <li id="Inbox_link " class="job_con">
                        <?php if ($message_count) { ?>
                        <?php } ?>
                        <a class="action-button shadow animate dropbtn_common" href="javascript:void(0);" id="InboxLink" onclick = "return getmsgNotification()"><em class="hidden-xs"> </em> <span class="message3-24x24-h"></span>
                        <span id="message_count"></span>
                        </a>
                        <div id="InboxContainer" class="dropdown2_content">
                           <div id="InboxBody" class="Inbox">
                              <div id="notificationTitle">Messages<span class="see_link" id="seemsg"></span></div>
                              <div class="content mCustomScrollbar light notifications" id="notification_main_in" data-mcs-theme="minimal-dark">
                                 <div>
                                    <ul class="notification_data_in_h2">
                                        <div class="fw" id="msg_not_loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="loderimage"/></div>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                     </li>
                     <li>

                        <?php 
                        $userid = $this->session->userdata('aileenuser');
                         $contition_array = array('status' => '1', 'user_id' => $userid);
                         $slugdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = ''); 
                       

                           ?>

                     <!-- Friend Request End-->
                     <div class="dropdown_hover">
                     <span id="art_profile" class="profiletitle dropbtn_common" >Job Profile <i class="fa fa-caret-down" aria-hidden="true"></i></span>
                     <div class="dropdown-content_hover dropdown2_content" id="dropdown-content_hover">
                     <span class="my_account">
                     <div class="my_S">Account</div>
                     </span>
                     <a href="<?php echo base_url('job/resume/'.$slugdata[0]['slug']); ?>" title="View Profile"><span class="icon-view-profile edit_data"></span>
                     <span> View Profile </span></a>
                     <a href="<?php echo base_url('job/basic-information'); ?>" title="Edit Profile"><span class="icon-edit-profile edit_data"></span>  
                     <span>Edit Profile </span></a>
                     <?php
                        $userid = $this->session->userdata('aileenuser');
                        ?>
                     <a onClick="deactivate(<?php echo $userid; ?>)" title="Deactive Profile"><span class="icon-delete edit_data"></span>  <span>Deactive Profile</span></a>
                     </div>
                     </div>
                     </li>
                     <!-- Friend Request End-->
                     <!-- END USER LOGIN DROPDOWN -->
                  </ul>
                  </div> 
               </div>
            </div>
         </div>
      </div>
   </div>
</header>
<!-- Bid-modal  -->
<!-- <div class="modal fade message-box biderror custom-message cust-err" id="bidmodal" role="dialog">
   <div class="modal-dialog modal-lm deactive">
      <div class="modal-content message">
         <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
         <div class="modal-body">
            <span class="mes"></span>
         </div>
      </div>
   </div>
</div> -->
<!-- Model Popup Close -->

<script>
    var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
    var base_url = '<?php echo base_url(); ?>';
    var segment = '<?php echo "" . $this->uri->segment(1) . "" ?>';
    var seg='<?php $this->uri->segment(3) ?>';
</script>
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_header2_border.js?ver='.time()); ?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_header2_border.js?ver='.time()); ?>"></script>

<?php }?>
