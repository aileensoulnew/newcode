        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/business/business.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/common/mobile.css'); ?>" /><!-- start head  -->
<?php echo $head; ?>
<!-- END HEAD -->
<!-- start header -->

<div style="display: block;">
    <?php echo $header; ?>
</div>
<div style="display: block;">
    <?php echo $business_header2; ?>
</div>
<script src="<?php echo base_url('js/fb_login.js'); ?>"></script>



<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css" />
     
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/timeline.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/jquery.jMosaic.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/1.10.3.jquery-ui.css'); ?>">


<!-- <script src="<?php //echo base_url('js/jquery.min.js');                                              ?>"></script> -->
        <!-- <script src="<?php //echo base_url('js/jquery-ui.min.js');     ?>"></script>
        <script src="<?php //echo base_url('js/jquery.wallform.js');     ?>"></script> -->
        <script>
            $(document).ready(function ()
            {


                /* Uploading Profile BackGround Image */
                $('body').on('change', '#bgphotoimg', function ()
                {

                    $("#bgimageform").ajaxForm({target: '#timelineBackground',
                        beforeSubmit: function () {},
                        success: function () {

                            $("#timelineShade").hide();
                            $("#bgimageform").hide();
                        },
                        error: function () {

                        }}).submit();
                });



                /* Banner position drag */
                $("body").on('mouseover', '.headerimage', function ()
                {
                    var y1 = $('#timelineBackground').height();
                    var y2 = $('.headerimage').height();
                    $(this).draggable({
                        scroll: false,
                        axis: "y",
                        drag: function (event, ui) {
                            if (ui.position.top >= 0)
                            {
                                ui.position.top = 0;
                            } else if (ui.position.top <= y1 - y2)
                            {
                                ui.position.top = y1 - y2;
                            }
                        },
                        stop: function (event, ui)
                        {
                        }
                    });
                });


                /* Bannert Position Save*/
                $("body").on('click', '.bgSave', function ()
                {
                    var id = $(this).attr("id");
                    var p = $("#timelineBGload").attr("style");
                    var Y = p.split("top:");
                    var Z = Y[1].split(";");
                    var dataString = 'position=' + Z[0];
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('business_profile/image_saveBG_ajax'); ?>",
                        data: dataString,
                        cache: false,
                        beforeSend: function () { },
                        success: function (html)
                        {
                            if (html)
                            {
                                window.location.reload();
                                $(".bgImage").fadeOut('slow');
                                $(".bgSave").fadeOut('slow');
                                $("#timelineShade").fadeIn("slow");
                                $("#timelineBGload").removeClass("headerimage");
                                $("#timelineBGload").css({'margin-top': html});
                                return false;
                            }
                        }
                    });
                    return false;
                });



            });
        </script>
    </head>
    <body class="page-container-bg-solid page-boxed">
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container">
                <div class="row">


                    <div class="col-md-4 profile-box profile-box-left animated fadeInLeftBig"><div class="">
<!-- 
                            <div class="full-box-module">    
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover">    
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                           href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>"
                                           tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo $businessdata[0]['company_name']; ?>">
                                          
                                            <?php if ($businessdata[0]['profile_background'] != '') { ?>
                                                <div>  <img src="<?php echo base_url($this->config->item('bus_bg_thumb_upload_path') . $businessdata[0]['profile_background']); ?>" class="bgImage" alt="<?php echo $businessdata[0]['company_name']; ?>" >
                                                </div> <?php
                                            } else {
                                                ?>
                                                <div> 
                                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $businessdata[0]['company_name']; ?>" >
                                                </div> <?php } ?>
                                        </a>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="buisness-profile-txext col-md-4">
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>" title="<?php echo $businessdata[0]['company_name']; ?>" tabindex="-1" aria-hidden="true" rel="noopener" >
                                                <?php
                                                if ($businessdata[0]['business_user_image']) {
                                                    ?>
                                                    <div> 
                                                        <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $businessdata[0]['business_user_image']); ?>"  alt="<?php echo $businessdata[0]['company_name']; ?>" style="height: 77px; width: 71px; z-index: 3; position: relative; ">
                                                    </div>
                                                <?php } else { ?> <div> 
                                                        <img src="<?php echo base_url(NOIMAGE); ?>" alt="<?php echo $businessdata[0]['company_name']; ?>">
                                                    </div>  <?php } ?>                           
                                                </a>
                                        </div>
                                        <div class="profile-box-user  profile-text-bui-user  fr col-md-9">
                                            <span class="profile-company-name ">
                                                <a class="ml-4" href="<?php echo base_url('business-profile/dashboard/'); ?> " title="<?php echo ucwords($businessdata[0]['company_name']); ?>"> 
                                                    <?php echo ucwords($businessdata[0]['company_name']); ?>
                                                </a> 
                                            </span>
                                            <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name; ?>
                                            <div class="profile-boxProfile-name">
                                                <a style="padding-left:3px;" href="<?php echo base_url('business-profile/dashboard/'); ?> " title="<?php echo ucwords($businessdata[0]['company_name']); ?>" >
                                                    <?php
                                                    if ($category) {
                                                        echo $category;
                                                    } else {
                                                        echo $businessdata[0]['other_industrial'];
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="profile-box-bui-menu  col-md-12">
                                            <ul class="">
                                                <li 
                                                    <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'business_profile_manage_post') { ?> class="active" 
                                                    <?php } ?>>
                                                    <a title="Dashboard" href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>">Dashboard
                                                    </a>
                                                </li>
                                                <li 
                                                    <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'followers') { ?> class="active" 
                                                    <?php } ?>>
                                                    <a title="Followers" href="<?php echo base_url('business_profile/followers'); ?>">Followers 
                                                        <br> (<?php echo (count($businessfollowerdata)); ?>)
                                                    </a>
                                                </li>
                                                <li 
                                                    <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'following') { ?> class="active" 
                                                    <?php } ?>>
                                                    <a title="Following" href="<?php echo base_url('business_profile/following/' . $businessdata[0]['business_slug']); ?>">Following 
                                                        <br> (<?php echo (count($businessfollowingdata)); ?>) 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

 -->
    <div class="full-box-module">   
      <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover"> 
                                             <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                           href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>"
                                           tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo $businessdata[0]['company_name']; ?>">
                                            <!-- box image start -->
                                            <?php if ($businessdata[0]['profile_background'] != '') { ?>
                                                <div>  <img src="<?php echo base_url($this->config->item('bus_bg_thumb_upload_path') . $businessdata[0]['profile_background']); ?>" class="bgImage" alt="<?php echo $businessdata[0]['company_name']; ?>" >
                                                </div> <?php
                                            } else {
                                                ?>
                                                <div> 
                                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $businessdata[0]['company_name']; ?>" >
                                                </div> <?php } ?>
                                        </a>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                    <div class="left_side_box_img buisness-profile-txext">
                                        
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>" title="<?php echo $businessdata[0]['company_name']; ?>" tabindex="-1" aria-hidden="true" rel="noopener" >
                                                <?php
                                                if ($businessdata[0]['business_user_image']) {
                                                    ?>
                                                    <div class="left_iner_img_profile"> 
                                                        <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $businessdata[0]['business_user_image']); ?>"  alt="<?php echo $businessdata[0]['company_name']; ?>" >
                                                    </div>
                                                <?php } else { ?>
                                                  <div class="left_iner_img_profile">  
                                                        <img src="<?php echo base_url(NOIMAGE); ?>" alt="<?php echo $businessdata[0]['company_name']; ?>">
                                                    </div>  <?php } ?>                           
                                                <!-- 
                        <img class="profile-boxProfileCard-avatarImage js-action-profile-avatar" src="images/imgpsh_fullsize (2).jpg" alt="" style="    height: 68px;
                        width: 68px;">
                                                -->
                                            </a>
                                    </div>
                                    <div class="right_left_box_design ">
                                      <span class="profile-company-name ">
                                                <a  href="<?php echo base_url('business-profile/dashboard/'); ?> " title="<?php echo ucwords($businessdata[0]['company_name']); ?>"> 
                                                    <?php echo ucwords($businessdata[0]['company_name']); ?>
                                                </a> 
                                            </span>

                                                 <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name; ?>
                                            <div class="profile-boxProfile-name">
                                                <a  href="<?php echo base_url('business-profile/dashboard/'); ?> " title="<?php echo ucwords($businessdata[0]['company_name']); ?>" >
                                                    <?php
                                                    if ($category) {
                                                        echo $category;
                                                    } else {
                                                        echo $businessdata[0]['other_industrial'];
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                               <ul class=" left_box_menubar">
                                                <li
                                                    <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'business_profile_manage_post') { ?> class="active" 
                                                    <?php } ?>>
                                                    <a  class="padding_less_left" title="Dashboard" href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>">Dashboard
                                                    </a>
                                                </li>
                                                <li 
                                                    <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'followers') { ?> class="active" 
                                                    <?php } ?>>
                                                    <a title="Followers" href="<?php echo base_url('business_profile/followers'); ?>">Followers 
                                                        <br> (<?php echo (count($businessfollowerdata)); ?>)
                                                    </a>
                                                </li>
                                                <li  
                                                    <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'following') { ?> class="active" 
                                                    <?php } ?>>
                                                    <a  class="padding_less_right" title="Following" href="<?php echo base_url('business_profile/following/' . $businessdata[0]['business_slug']); ?>">Following 
                                                        <br> (<?php echo (count($businessfollowingdata)); ?>) 
                                                    </a>
                                                </li>
                                            </ul>
                                    </div>
                                    </div>
       </div>                             
    </div>
                            <!--  <div  class="add-post-button">
                                    <a class="btn btn-3 btn-3b"href="<?php echo base_url('recruiter'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Recruiter</a>
                              </div>-->

                        </div>
                    </div>


                    <!-- Trigger/Open The Modal -->
                    <!-- <div id="myBtn">Open Modal</div>
                    -->
                    <!-- The Modal -->

                    <div class="col-md-7 col-sm-12 col-md-push-4 custom-right-business animated fadeInUp">

                        <!-- body content start-->

                        <div class="col-md-12 col-sm-12 post-design-box">


                            <!-- pop up box start-->
                            <div id="popup1" class="overlay">
                                <div class="popup">

                                    <div class="pop_content">
                                        Your Post is Successfully Saved.
                                        <p class="okk"><a class="okbtn" href="#">Ok</a></p>
                                    </div>

                                </div>
                            </div>
                            <!-- pop up box end-->

                            <div  class="">  
                                <div class="post-design-top col-md-12" >  
                                    <div class="post-design-pro-img " style="padding-left: 17px;"> 
                                        <?php
                                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => 1))->row()->business_user_image;

                                        $userimageposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id']))->row()->business_user_image;
                                        ?>

                                        <?php
                                        $slugname = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => 1))->row()->business_slug;
                                        $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id'], 'status' => 1))->row()->business_slug;
                                        ?>

                                        <?php if ($busienss_data[0]['posted_user_id']) {
                                            ?>

                                            <?php if ($userimageposted) { ?>
                                                <a href="<?php echo base_url('business-profile/dashboard/' . $slugnameposted); ?>">
                                                    <img src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $userimageposted); ?>" name="image_src" id="image_src" />
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url('business-profile/dashboard/' . $slugnameposted); ?>">
                                                    <img alt="" src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                                                </a>
                                            <?php } ?>

                                        <?php } else { ?>
                                            <?php if ($business_userimage) { ?>
                                                <a href="<?php echo base_url('business-profile/dashboard/' . $slugname); ?>">
                                                    <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url('business-profile/dashboard/' . $slugname); ?>">
                                                    <img src="<?php echo base_url(NOIMAGE); ?>" alt="">
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>


                                    <div class="post-design-name fl col-md-10">
                                        <ul>


                                            <?php
                                            $companyname = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => 1))->row()->company_name;

                                            $slugname = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => 1))->row()->business_slug;

                                            $categoryid = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => 1))->row()->industriyal;


                                            $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => 1))->row()->industry_name;

                                            $companynameposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id']))->row()->company_name;

                                            $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id'], 'status' => 1))->row()->business_slug;
                                            ?>

                                            <?php if ($busienss_data[0]['posted_user_id']) { ?>
                                                <li>
                                                    <div class="else_post_d">
                                                        <div class="post-design-product">
                                                            <a  class="post_dot_2" href="<?php echo base_url('business-profile/dashboard/' . $slugnameposted); ?>"><?php echo ucwords($companynameposted); ?></a>
                                                               <p class="posted_with" > Posted With </p>
                                                               <a  class="post_dot_2" href="<?php echo base_url('business-profile/dashboard/' . $slugname); ?>"><?php echo ucwords($companyname); ?></a>
                                                                <span role="presentation" aria-hidden="true"> · </span><span class="ctre_date"  >
                                               <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))); ?>                     
                                                      </span> </div></div>
                                                </li>
                                            <?php } else { ?>
                                                <li><div class="post-design-product"><a class="post_dot" href="<?php echo base_url('business-profile/details/' . $slugname); ?>"> <span class="span_main_name">  <?php echo ucwords($companyname); ?> </span> </a>
                                                     <span role="presentation" aria-hidden="true"> · </span>
                                                        <span> 
                                                            <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($busienss_data[0]['created_date']))); ?>      
                                                           </span></div></li>

                                            <?php } ?>
                                            <li><div class="post-design-product"><a>
                                                        <?php
                                                        if ($category) {
                                                            echo ucwords($category);
                                                        } else {
                                                            echo ucwords($busienss_data[0]['other_industrial']);
                                                        }
                                                        ?>

                                                    </a></div></li>
                                        </ul> 
                                    </div>  
                                    <div class="dropdown1">
                                        <a onClick="myFunction(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)" class="dropbtn1 dropbtn1 fa fa-ellipsis-v"></a>
                                        <div id="<?php echo "myDropdown" . $busienss_data[0]['business_profile_post_id']; ?>" class="dropdown-content1">

                                            <?php
                                            if ($busienss_data[0]['posted_user_id'] != 0) {

                                                if ($this->session->userdata('aileenuser') == $busienss_data[0]['posted_user_id']) {
                                                    ?>
                                                    <a onclick="user_postdelete(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)">
                                                        <i class="fa fa-trash-o" aria-hidden="true">
                                                        </i> Delete Post
                                                    </a>
                                                    <a id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="editpost(this.id)">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                        </i>Edit
                                                    </a>

                                                <?php } else {
                                                    ?>

                                                    <a onclick="user_postdelete(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)">
                                                        <i class="fa fa-trash-o" aria-hidden="true">
                                                        </i> Delete Post
                                                    </a>
                                                    <a href="<?php echo base_url('business-profile/contact-person/' . $busienss_data[0]['posted_user_id'] . ''); ?>">
                                                        <i class="fa fa-user" aria-hidden="true">
                                                        </i> Contact Person
                                                    </a>

                                                    <?php
                                                }
                                            } else {
                                                ?>

                                                <?php if ($this->session->userdata('aileenuser') == $busienss_data[0]['user_id']) { ?> 

                                                    <a onclick="user_postdelete(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>

                                                    <a id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>

                                                <?php } else { ?>
                                                    <a onclick="user_postdeleteparticular(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>



                                                    <a href="<?php echo base_url('business-profile/contact-person/' . $busienss_data[0]['user_id'] . ''); ?>"><i class="fa fa-user" aria-hidden="true"></i> Contact Person</a>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <div class="post-design-desc " style="padding: 5px 17px 5px 17px;">
                                          <div class="ft-15 t_artd">
                                            <div id="<?php echo 'editpostdata' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:block;">
                                            <a  ><?php echo $this->common->make_links($busienss_data[0]['product_name']); ?></a>
                                        </div>

                                        <div id="<?php echo 'editpostbox' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">
                                            <input type="text" id="<?php echo 'editpostname' . $busienss_data[0]['business_profile_post_id']; ?>" name="editpostname" placeholder="Product Name" value="<?php echo $busienss_data[0]['product_name']; ?>">
                                        </div>
                                        </div>

                                        <div id="<?php echo 'editpostdetails' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:block;">
<!--                                            <span class="show">  <?php print $this->common->make_links($busienss_data[0]['product_description']); ?>
                                            </span>-->
                                            <span class="show_desc">  
                                                <?php $new_product_description = $this->common->make_links($busienss_data[0]['product_description']); ?>
                                                <?php echo nl2br(htmlentities($new_product_description, ENT_QUOTES, 'UTF-8')); ?>
                                                <?php //echo  nl2br($new_product_description); ?>
                                            </span>
                                        </div>

                                        <div id="<?php echo 'editpostdetailbox' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">

              <!-- <textarea id="<?php echo 'editpostdesc' . $row['business_profile_post_id']; ?>" name="editpostdesc"><?php echo $row['product_description']; ?>
                     </textarea>  -->
                                            <div  contenteditable="true" id="<?php echo 'editpostdesc' . $busienss_data[0]['business_profile_post_id']; ?>" placeholder="Product Description" class="textbuis  editable_text" placeholder="Description of Your Product"  name="editpostdesc" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $busienss_data[0]['product_description']; ?></div>

                <!-- <div contenteditable="true"  id="<?php echo 'editpostdesc' . $row['business_profile_post_id']; ?>" placeholder="Product Description" class="textbuis  editable_text"  name="editpostdesc"><?php echo $row['product_description']; ?></div>  -->

                                        </div>
                                        <button class="fr" id="<?php echo "editpostsubmit" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;margin: 5px 0;" onClick="edit_postinsert(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)">Save</button>
                                    </div> 
                                </div>


                                <div class="post-design-mid col-md-12">

                                    <!-- multiple image code  start-->

                                    <div>
                                        <?php
                                        $contition_array = array('post_id' => $busienss_data[0]['business_profile_post_id'], 'is_deleted' => '1', 'insert_profile' => '2');
                                        $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        ?>


                                        <?php
                                        $i = 1;
                                        foreach ($businessmultiimage as $data) {

                                            //echo '<pre>'; print_r($businessmultiimage); die();

                                            $allowed = array('gif', 'png', 'jpg');
                                            $allowespdf = array('pdf');
                                            $allowesvideo = array('mp4', '3gp');
                                            $allowesaudio = array('mp3');
                                            $filename = $data['file_name'];
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                            if (in_array($ext, $allowed)) {
                                                ?>

                                                <?php if (count($businessmultiimage) == 1) { ?>

                                                    <!-- two image start -->
                                                  <div class="one-image" >
                                                        <img src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $data['file_name']) ?>" onclick="openModal();
                                                                currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                    </div>
                                                    <!-- two image end -->

                                                <?php } elseif (count($businessmultiimage) == 2) { ?>

                                                    <!-- two image start -->
                                                   <div class="two-images" >
                                                        <img src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $data['file_name']) ?>" onclick="openModal();
                                                                currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                    </div>
                                                    <!-- two image end -->
                                                <?php } elseif (count($businessmultiimage) == 3) { ?>
                                                    <?php
                                                    //   foreach ($businessmultiimage as $multiimage) {
                                                    ?>
                                                    <!-- two image start -->
                                                 <div class="three-image" >
                                                        <img src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $data['file_name']) ?>"  onclick="openModal();
                                                                currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                    </div>
                                                    <!-- two image end -->
                                                    <?php // }    ?>
                                                <?php } elseif (count($businessmultiimage) == 4) { ?>

                                                    <!-- two image start -->
                                                  <div class="four-image" >
                                                        <img src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $data['file_name']) ?>" onclick="openModal();
                                                                currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                    </div>
                                                    <!-- two image end -->
                                                <?php } else { ?>

                                                  <div class="four-image" >
                                                        <img src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $data['file_name']) ?>"  onclick="openModal();
                                                                currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                    </div>
                                                    <?php
                                                }
                                            } elseif (in_array($ext, $allowespdf)) {
                                                ?>

                                                <!-- one pdf start -->
                                                <div>
                                                    <a href="<?php echo base_url('business_profile/creat_pdf/' . $data['post_files_id']) ?>"><div class="pdf_img">
                                                            <img src="<?php echo base_url('images/PDF.jpg') ?>" style="height: 100%; width: 100%;">
                                                        </div></a>
                                                </div>
                                                <!-- one pdf end -->

                                            <?php } elseif (in_array($ext, $allowesvideo)) { ?>

                                                <!-- one video start -->
                                                <div>
                                                    <video width="320" height="240" controls>
                                                        <source src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $data['file_name']); ?>" type="video/mp4">
                                                        <source src="movie.ogg" type="video/ogg">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                                <!-- one video end -->

                                            <?php } elseif (in_array($ext, $allowesaudio)) { ?>

                                                <!-- one audio start -->
                                                <div>
                                                    <audio width="120" height="100" controls>

                                                        <source src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $data['file_name']); ?>" type="audio/mp3">
                                                        <source src="movie.ogg" type="audio/ogg">
                                                        Your browser does not support the audio tag.

                                                    </audio>

                                                </div>

                                                <!-- one audio end -->

                                            <?php } ?>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </div>


                                    <!-- silder start -->
                                    <div id="myModal1" class="modal2">
                                       
                                        <div class="modal-content2">
 <span class="close2 cursor" onclick="closeModal()">&times;</span>
                                            <!--  multiple image start -->

                                            <?php
                                            $i = 1;

                                            $allowed = array('gif', 'png', 'jpg');
                                            foreach ($businessmultiimage as $mke => $mval) {

                                                $ext = pathinfo($mval['file_name'], PATHINFO_EXTENSION);

                                                if (in_array($ext, $allowed)) {
                                                    $databus1[] = $mval;
                                                }
                                            }

                                            foreach ($databus1 as $busdata) {
                                                ?>

                                                <div class="mySlides">
                                                    <div class="numbertext"><?php echo $i ?> / <?php echo count($databus1) ?></div>
                                                    <div class="slider_img">
                                                        <img src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $busdata['file_name']) ?>" >
                                                    </div>

                                                    <!-- like comment start -->

                                                    <?php
                                                    if (count($databus1) > 1) {
                                                        ?>
                                                        <div>
                                                            <div class="post-design-like-box col-md-12">
                                                                <div class="post-design-menu">
                                                                    <ul class="col-md-6">
                                                                        <li class="<?php echo 'likepostimg' . $busdata['post_files_id']; ?>">
                                                                            <a id="<?php echo $busdata['post_files_id']; ?>" onClick="mulimg_like(this.id)">
                                                                                <?php
                                                                                $userid = $this->session->userdata('aileenuser');
                                                                                $contition_array = array('post_image_id' => $busdata['post_files_id'], 'user_id' => $userid, 'is_unlike' => 0);

                                                                                $activedata = $this->data['activedata'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                                                if ($activedata) {
                                                                                    ?>
                                                                                    <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                                                <?php } else { ?>
                                                                                    <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>
                                                                                <?php } ?>

                                                                                <span class="<?php echo 'likeimage' . $busdata['post_files_id']; ?>"> <?php
                                                                                    $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => 0);
                                                                                    $likecount = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                                    if ($likecount) {
                                                                                        echo count($likecount);
                                                                                    }
                                                                                    ?>

                                                                                </span>
                                                                            </a>
                                                                        </li>

                                                                        <li id="<?php echo 'insertcountimg' . $busdata['post_files_id']; ?>">

                                                                            <?php
                                                                            $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_delete' => '0');
                                                                            $commnetcount = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                            ?>

                                                                            <a onClick="imgcommentall(this.id)" id="<?php echo $busdata['post_files_id']; ?>">
                                                                                <i class="fa fa-comment-o" aria-hidden="true">
                                                                                    <?php
                                                                                 /*   if (count($commnetcount) > 0) {
                                                                                        echo count($commnetcount);
                                                                                    } */
                                                                                    ?>
                                                                                </i> 
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="col-md-6 like_cmnt_count">

                                                                        <li>
                                                                            <div class="like_count_ext">
                                                                                <span class="comment_count_img" > 
                                                                                    <span>5</span>
                                                        <span> Comment</span>
                                                    
                                                                                </span> 
                                                                              </div>
                                                                        </li>

                                                                        <li>
                                                                            <div class="comnt_count_ext">
                                                                                <span class="comment_like_count_img"> 
                                                                                    <span>5</span>
                                                        <span> Like</span>
                                                    
                                                                              
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                                            $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                            if (count($commneteduser) > 0) {
                                                                ?>
                                                                <div class="likeduserlist1 likeduserlistimg<?php echo $busdata['post_files_id'] ?>">
                                                                    <?php
                                                                    $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                                                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//                                                                echo '<pre>';
//                                                                print_r($commneteduser);
//                                                                
                                                                    $countlike = count($commneteduser) - 1;
                                                                    foreach ($commneteduser as $userdata) {
                                                                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => 1))->row()->company_name;
                                                                    }
                                                                    ?>
                                                                    <!-- pop up box end-->
                                                                    <a href="javascript:void(0);"  onclick="likeuserlistimg(<?php echo $busdata['post_files_id'] ?>);">
                                                                        <?php
                                                                        $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                                                        $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//                                                              
                                                                        $countlike = count($commneteduser) - 1;
                                                                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => 1))->row()->company_name;
                                                                        ?>
                                                                        <div class="like_one_other_img">
                                                                            <?php
                                                                            if ($userid == $commneteduser[0]['user_id']) {
                                                                                echo "You";
                                                                                echo "&nbsp;";
                                                                            } else {
                                                                                echo ucwords($business_fname1);
                                                                                echo "&nbsp;";
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                            if (count($commneteduser) > 1) {
                                                                                ?>
                                                                                <?php echo "and"; ?>
                                                                                <?php
                                                                                echo $countlike;
                                                                                echo "&nbsp;";
                                                                                echo "others";
                                                                                ?> 
                                                                            <?php } ?>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>

                                                            <div class="<?php echo "likeusernameimg" . $busdata['post_files_id']; ?>" id="<?php echo "likeusernameimg" . $busdata['post_files_id']; ?>" style="display:none">
                                                                <?php
                                                                $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                                                $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//                                                                echo '<pre>';
//                                                                print_r($commneteduser);
//                                                                
                                                                $countlike = count($commneteduser) - 1;
                                                                foreach ($commneteduser as $userdata) {
                                                                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => 1))->row()->company_name;
                                                                }
                                                                ?>
                                                                <!-- pop up box end-->
                                                                <a href="javascript:void(0);"  onclick="likeuserlistimg(<?php echo $busdata['post_files_id'] ?>);">
                                                                    <?php
                                                                    $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                                                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//                                                              
                                                                    $countlike = count($commneteduser) - 1;
                                                                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => 1))->row()->company_name;
                                                                    ?>
                                                                    <div class="like_one_other_img" style="">
                                                                        <?php
                                                                        echo ucwords($business_fname1);
                                                                        echo "&nbsp;";
                                                                        ?>
                                                                        <?php
                                                                        if (count($commneteduser) > 1) {
                                                                            ?>
                                                                            <?php echo "and"; ?>
                                                                            <?php
                                                                            echo $countlike;
                                                                            echo "&nbsp;";
                                                                            echo "others";
                                                                            ?> 
                                                                        <?php } ?>
                                                                    </div>
                                                                </a>
                                                            </div>

                                                            <!-- show comment div start -->
                                                            <div class="art-all-comment">

                                                                <div  id="<?php echo "threeimgcomment" . $busdata['post_files_id']; ?>" style="display:block">
                                                                    <div class="<?php echo 'insertimgcomment' . $busdata['post_files_id']; ?>">

                                                                        <?php
                                                                        $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_delete' => '0');

                                                                        $busmulimage = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                                                                        if ($busmulimage) {
                                                                            foreach ($busmulimage as $rowdata) {
                                                                                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                                                                                ?>

                                                                                <div class="all-comment-comment-box">

                                                                                    <div class="post-design-pro-comment-img"> 
                                                                                        <?php
                                                                                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;
                                                                                        if ($business_userimage != '') {
                                                                                            ?>
                                                                                            <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <img  src="<?php echo base_url(NOIMAGE) ?>" alt="No Image">
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>

                                                                                    <div class="comment-name">

                                                                                        <b>  <?php
                                                                                            echo ucwords($companyname);
                                                                                            echo '</br>';
                                                                                            ?>
                                                                                        </b>
                                                                                    </div>

                                                                                    <div class="comment-details" id= "<?php echo "imgshowcomment" . $rowdata['post_image_comment_id']; ?>">
                                                                                        <?php
//                                                                                        echo $this->common->make_links($rowdata['comment']);

                                                                                       echo $new_product_comment = $this->common->make_links($rowdata['comment']);
                                                                                        echo nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                                                                                        ?>
                                                                                        
                                                                                    </div>


                                                                                    <!-- edit box start -->

                                                                                    <!--                                                                                <div class="col-md-12">
                                                                                                                                                                        <div class="col-md-10">
                                                                                                                                                                            <div contenteditable="true" class="editable_text"  name="<?php echo $rowdata['post_image_comment_id']; ?>" id="<?php echo "imgeditcomment" . $rowdata['post_image_comment_id']; ?>" style="display: none;" onkeyup="imgcommentedit(<?php echo $rowdata['post_image_comment_id']; ?>)"><?php echo $rowdata['comment']; ?>
                                                                                                                                                                            </div>
                                                                                    
                                                                                                                                                                        </div>  <div class="col-md-2 comment-edit-button">
                                                                                                                                                                            <button id="<?php echo "imgeditsubmit" . $rowdata['post_image_comment_id']; ?>" style="display:none" onClick="imgedit_comment(<?php echo $rowdata['post_image_comment_id']; ?>)">Save</button>
                                                                                                                                                                        </div>
                                                                                    
                                                                                                                                                                    </div>-->

                                                                                    <div class="edit-comment-box">
                                                                                        <div class="inputtype-edit-comment">
                                                                                            <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="<?php echo $rowdata['post_image_comment_id']; ?>"  id="<?php echo "imgeditcomment" . $rowdata['post_image_comment_id']; ?>" placeholder="Add a Comment ... " value= ""  onkeyup="imgcommentedit(<?php echo $rowdata['post_image_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comment']; ?></div>
                                                                                            <span class="comment-edit-button"><button id="<?php echo "imgeditsubmit" . $rowdata['post_image_comment_id']; ?>" style="display:none" onClick="imgedit_comment(<?php echo $rowdata['post_image_comment_id']; ?>)">Save</button></span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- edit box end -->
                                                                                    <div class="art-comment-menu-design"> 

                                                                                        <!-- comment like start -->
                                                                                        <div class="comment-details-menu"  id="<?php echo 'imglikecomment' . $rowdata['post_image_comment_id']; ?>">

                                                                                            <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="imgcomment_like(this.id)">

                                                                                                <?php
                                                                                                $userid = $this->session->userdata('aileenuser');
                                                                                                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

                                                                                                $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                                                //echo "<pre>"; print_r($businesscommentlike); 
                                                                                                //echo count($businesscommentlike); 
                                                                                                if (count($businesscommentlike1) == 0) {
                                                                                                    ?>
                                                                                                    <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>

                                                                                                <?php } else {
                                                                                                    ?>
                                                                                                    <i class="fa main_colorfa-thumbs-up main_color" aria-hidden="true"></i>
                                                                                                <?php } ?>
                                                                                                <span>

                                                                                                    <?php
                                                                                                    $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'is_unlike' => '0');
                                                                                                    $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                                                                    if (count($mulcountlike) > 0) {
                                                                                                        echo count($mulcountlike);
                                                                                                    }
                                                                                                    ?>

                                                                                                </span>
                                                                                            </a>

                                                                                        </div>

                                                                                        <!--   comment like end -->


                                                                                        <!-- comment edit start -->

                                                                                        <?php
                                                                                        $userid = $this->session->userdata('aileenuser');
                                                                                        if ($rowdata['user_id'] == $userid) {
                                                                                            ?>
                                                                                            <div class="comment-details-menu">

                                                                                                <div id="<?php echo 'imgeditcommentbox' . $rowdata['post_image_comment_id']; ?>" style="display:block;">
                                                                                                    <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="imgcomment_editbox(this.id)" class="editbox">Edit</a></div>

                                                                                                <div id="<?php echo 'imgeditcancle' . $rowdata['post_image_comment_id']; ?>" style="display:none;">
                                                                                                    <a id="<?php echo $rowdata['post_image_comment_id']; ?>" onClick="imgcomment_editcancle(this.id)">Cancle</a></div>

                                                                                            </div>

                                                                                        <?php } ?>
                                                                                        <!-- comment edit end -->

                                                                                        <!-- comment delete start -->
                                                                                        <?php
                                                                                        $userid = $this->session->userdata('aileenuser');

                                                                                        $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['post_image_id'], 'status' => 1))->row()->user_id;


                                                                                        if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                                                                                            ?>
                                                                                            <span role="presentation" aria-hidden="true"> · </span>
                                                                                            <div class="comment-details-menu">
                                                                                                <input type="hidden" name="imgpost_delete"  id="imgpost_delete_<?php echo $rowdata['post_image_comment_id']; ?>" value= "<?php echo $rowdata['post_image_id']; ?>">
                                                                                                <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="imgcomment_delete(this.id)"> Delete<span class="<?php echo 'imginsertcomment' . $rowdata['post_image_comment_id']; ?>">
                                                                                                    </span> </a> </div>

                                                                                        <?php } ?>
                                                                                        <!-- comment delete end -->


                                                                                        <!-- created date start -->

                                                                                        <span role="presentation" aria-hidden="true"> · </span>
                                                                                        <div class="comment-details-menu">
                                                                                            <p><?php
                                                                                                echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                                                                echo '</br>';
                                                                                                ?>
                                                                                            </p></div>

                                                                                        <!-- created date end -->

                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </div>
                                                                </div>
                                                                <!-- 27-4 mulimage comment start -->
                                                                <div id="<?php echo "fourimgcomment" . $busdata['post_files_id']; ?>" style="display:none;">


                                                                </div>
                                                                <!-- 27-4 mulimage comment end -->

                                                            </div>

                                                            <!-- show comment div end -->

                                                            <!-- insert comment code start -->
                                                            <div class="post-design-commnet-box col-md-12">

                                                                <div class="post-design-proo-img"> 

                                                                    <?php
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
                                                                    if ($business_userimage != '') {
                                                                        ?>
                                                                        <img src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>" alt="">
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <img src="<?php echo base_url(NOIMAGE); ?>" alt="No Image">
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>


                                                                <div class="">
                                                                    <div class="col-md-12 inputtype-comment" style="width: 80%; padding-left: 7px;">
                                                                        <div contenteditable="true" class="editable_text" name="<?php echo $busdata['post_files_id']; ?>" id="<?php echo "post_imgcomment" . $busdata['post_files_id']; ?>" placeholder="Add a Comment ..." onkeyup="entercommentimg(<?php echo $busdata['post_files_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"></div>
                                                                    </div>

                                                                    <div class="comment-edit-butn">                                      
                                                                        <button id="<?php echo $busdata['post_files_id']; ?>" onClick="insert_commentimg(this.id)">Comment</button>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- insert comment code end -->

                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <!-- like comment end -->

                                                </div>
                                                <?php
                                                $i++;
                                            }
                                            ?>

                                            <!-- slider image rotation end  -->

                                            <a class="prev" style="left: 0px" onclick="plusSlides(-1)">&#10094;</a>
                                            <a class="next" onclick="plusSlides(1)">&#10095;</a>

                                            <div class="caption-container">
                                                <p id="caption"></p>
                                            </div>



                                        </div>
                                    </div>


                                    <!-- slider end -->

                                    <!-- multiple image code  end-->

                                </div>



                                <div class="post-design-like-box col-md-12">
                                    <div class="post-design-menu">
                                        <ul class="col-md-6">
                                            <li class="<?php echo 'likepost' . $busienss_data[0]['business_profile_post_id']; ?>">
                                                <a id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>"   onClick="post_like(this.id)">

                                                    <?php
                                                    $userid = $this->session->userdata('aileenuser');
                                                    $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1');
                                                    $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                    $likeuser = $this->data['active'][0]['business_like_user'];
                                                    $likeuserarray = explode(',', $active[0]['business_like_user']);

                                                    if (!in_array($userid, $likeuserarray)) {
                                                        ?>               
                                                      <!--<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>-->
                                                        <i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>
                                                    <?php } else { ?> 
                                                      <!--<i class="fa fa-thumbs-up" aria-hidden="true"></i>-->
                                                        <i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i>
                                                    <?php } ?>
                                                    <span class="like_As_count">
                                                        <?php
                                                        if ($busienss_data[0]['business_likes_count'] > 0) {
                                                            echo $busienss_data[0]['business_likes_count'];
                                                        }
                                                        ?>
                                                    </span>
                                                </a>
                                            </li>

                                            <li id="<?php echo 'insertcount' . $busienss_data[0]['business_profile_post_id']; ?>">
                                                <?php
                                                $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                ?>

                                                <a  onClick="commentall(this.id)" id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>"><i class="fa fa-comment-o" aria-hidden="true"> 
                                                        <?php
                                                    /*    if (count($commnetcount) > 0) {
                                                            echo count($commnetcount);
                                                        } else {
                                                            
                                                        } */
                                                        ?>
                                                    </i> 
                                                </a>

                                            </li>
                                        </ul>
                                        <ul class="col-md-6 like_cmnt_count">

                                            <li>
                                                <div class="like_count_ext">
                                                    <span class="comment_count<?php echo $busienss_data[0]['business_profile_post_id']; ?>" > 
                                                        <?php
                                                        if (count($commnetcount) > 0) {
                                                            echo count($commnetcount); ?>
                                                        <span> Comment</span>
                                                       <?php }
                                                        ?> 
                                                    </span> 
                                                    
                                                </div>
                                            </li>

                                            <li>
                                                <div class="comnt_count_ext">
                                                    <span class="comment_like_count<?php echo $busienss_data[0]['business_profile_post_id']; ?>"> 
                                                        <?php
                                                        if ($busienss_data[0]['business_likes_count'] > 0) {
                                                            echo $busienss_data[0]['business_likes_count']; ?>
                                                         <span> Like</span>
                                                     <?php   } 
                                                        ?>
                                                    </span> 
                                                   
                                                </div>
                                            </li>
                                        </ul>

                                    </div>
                                </div>





                                <!-- like user list start -->

                                <!-- pop up box start-->

                                <?php
                                if ($busienss_data[0]['business_likes_count'] > 0) {
                                    ?>
                                    <div class="likeduserlist<?php echo $busienss_data[0]['business_profile_post_id'] ?>">
                                        <?php
                                        $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        $likeuser = $commnetcount[0]['business_like_user'];
                                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                        $likelistarray = explode(',', $likeuser);
                                        foreach ($likelistarray as $key => $value) {
                                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                        }
                                        ?>
                                        <!-- pop up box end-->
                                        <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $busienss_data[0]['business_profile_post_id']; ?>);">
                                            <?php
                                            $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                            $likeuser = $commnetcount[0]['business_like_user'];
                                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);

                                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                            ?>
                                            <div class="like_one_other">
                                                <?php
                                                if ($userid == $value) {
                                                    echo "You";
                                                    echo "&nbsp;";
                                                } else {
                                                    echo ucwords($business_fname1);
                                                    echo "&nbsp;";
                                                }
                                                ?>
                                                <?php
                                                if (count($likelistarray) > 1) {
                                                    ?>
                                                    <?php echo "and"; ?>
                                                    <?php
                                                    echo $countlike;
                                                    echo "&nbsp;";
                                                    echo "others";
                                                    ?> 
                                                <?php } ?>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="<?php echo "likeusername" . $busienss_data[0]['business_profile_post_id']; ?>" id="<?php echo "likeusername" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none">
                                    <?php
                                    $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                    $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                    $likeuser = $commnetcount[0]['business_like_user'];
                                    $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                    $likelistarray = explode(',', $likeuser);
                                    foreach ($likelistarray as $key => $value) {
                                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                    }
                                    ?>
                                    <!-- pop up box end-->
                                    <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $busienss_data[0]['business_profile_post_id']; ?>);">
                                        <?php
                                        $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                        $likeuser = $commnetcount[0]['business_like_user'];
                                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                        $likelistarray = explode(',', $likeuser);

                                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                        ?>
                                        <div class="like_one_other">
                                            <?php
                                            echo ucwords($business_fname1);
                                            echo "&nbsp;";
                                            ?>
                                            <?php
                                            if (count($likelistarray) > 1) {
                                                ?>
                                                <?php echo "and"; ?>
                                                <?php
                                                echo $countlike;
                                                echo "&nbsp;";
                                                echo "others";
                                                ?> 
                                            <?php } ?>
                                        </div>
                                    </a>
                                </div>

<!--                                <div id="<?php echo "popuplike" . $busienss_data[0]['business_profile_post_id']; ?>" class="overlay">
                                    <div class="popup">

                                        <div class="pop_content">

                                <?php /*
                                  $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                  $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                  $likeuser = $commnetcount[0]['business_like_user'];
                                  $countlike = $commnetcount[0]['business_likes_count'] - 1;

                                  $likelistarray = explode(',', $likeuser);


                                  foreach ($likelistarray as $key => $value) {

                                  $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                  ?>

                                  <a href="<?php echo base_url('business-profile/details/' . $value); ?>">
                                  <?php echo ucwords($business_fname1); ?>

                                  </a>

                                  <?php } */ ?>

                                            <p class="okk"><a class="cnclbtn" href="#">Cancle</a></p>

                                        </div>

                                    </div>
                                </div>-->
                                <!-- pop up box end-->
                                <!--                                <div class="like_other">
                                                                    <a  href="<?php echo "#popuplike" . $busienss_data[0]['business_profile_post_id']; ?>">
                                <?php /*
                                  $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                  $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                  $likeuser = $commnetcount[0]['business_like_user'];
                                  $countlike = $commnetcount[0]['business_likes_count'] - 1;

                                  $likelistarray = explode(',', $likeuser);

                                  $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                  ?>



                                  <div class="like_one_other">

                                  <?php
                                  echo ucwords($business_fname1);
                                  echo "&nbsp;";
                                  ?>

                                  </div>

                                  <?php
                                  if (count($likelistarray) > 1) {
                                  ?>
                                  <div>
                                  <?php echo "and"; ?>

                                  <?php
                                  echo $countlike;
                                  echo "&nbsp;";
                                  echo "others";
                                  ?>


                                  <?php } */ ?>
                                                                        </div>
                                                                    </a>
                                                                </div>-->
                                <!-- like user list end -->


                                <!-- all comment start-->

                                <div class="art-all-comment col-md-12">
                                    <!-- all fourcomment comment start-->
                                    <div id="<?php echo "fourcomment" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">

                                    </div>

                                    <!-- all fourcomment comment end-->


                                    <!-- khyati changes start -->
                                    <div  id="<?php echo "threecomment" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:block">
                                        <div class="<?php echo 'insertcomment' . $busienss_data[0]['business_profile_post_id']; ?>">

                                            <?php
                                            $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1');

                                            $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                                            if ($businessprofiledata) {
                                                foreach ($businessprofiledata as $rowdata) {
                                                    $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                                                    ?>
                                                    <div class="all-comment-comment-box">
                                                        <div class="post-design-pro-comment-img"> 
                                                            <?php
                                                            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;
                                                            if ($business_userimage != '') {
                                                                ?>
                                                                <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <img src="<?php echo base_url(NOIMAGE); ?>"  alt="No Image">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="comment-name">

                                                            <b>  <?php
                                                                echo $companyname;
                                                                echo '</br>';
                                                                ?>
                                                            </b>
                                                        </div>
                                                        <div class="comment-details" id= "<?php echo "showcomment" . $rowdata['business_profile_post_comment_id']; ?>">
                                                            <?php
                                                            echo $this->common->make_links($rowdata['comments']);
//                                                            echo '</br>';
                                                            ?>
                                                        </div>
                                                        <!--                                                        <div class="col-md-12">
                                                                                                                    <div class="col-md-10">
                                                                                                                        <div contenteditable="true" class="editable_text" name="<?php echo $rowdata['business_profile_post_comment_id']; ?>" id="<?php echo "editcomment" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none"  onkeyup="commentedit(<?php echo $rowdata['business_profile_post_comment_id']; ?>)"><?php echo $rowdata['comments']; ?></div>
                                                                                                                    </div> 
                                                        
                                                                                                                    <div class="col-md-2 comment-edit-button">
                                                                                                                        <button id="<?php echo "editsubmit" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['business_profile_post_comment_id']; ?>)">Save</button>
                                                                                                                    </div>
                                                                                                                </div>-->
                                                        <div class="edit-comment-box">
                                                            <div class="inputtype-edit-comment">
                                                                <!--<textarea type="text" class="textarea" name="<?php echo $rowdata['business_profile_post_comment_id']; ?>" id="<?php echo "editcomment" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none;resize: none;" onClick="commentedit(this.name)"><?php echo $rowdata['comments']; ?></textarea>-->
                                                                <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="<?php echo $rowdata['business_profile_post_comment_id']; ?>"  id="<?php echo "editcomment" . $rowdata['business_profile_post_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(<?php echo $rowdata['business_profile_post_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comments']; ?></div>
                                                                <span class="comment-edit-button"><button id="<?php echo "editsubmit" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['business_profile_post_comment_id']; ?>)">Save</button></span>
                                                            </div>
                                                        </div>
                                                        <div class="art-comment-menu-design"> 


                                                            <div class="comment-details-menu" id="<?php echo 'likecomment1' . $rowdata['business_profile_post_comment_id']; ?>">

                                                                <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick="comment_like1(this.id)">

                                                                    <?php
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                                                                    $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                    $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

                                                                    if (!in_array($userid, $likeuserarray)) {
                                                                        ?>
                                                                        <i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i> 
                                                                    <?php } else { ?>

                                                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>

                                                                    <?php } ?>
                                                                    <span>
                                                                        <?php
                                                                        if ($rowdata['business_comment_likes_count']) {
                                                                            echo $rowdata['business_comment_likes_count'];
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </a>
                                                            </div>

                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');
                                                            if ($rowdata['user_id'] == $userid) {
                                                                ?>                                     
                                                                <span role="presentation" aria-hidden="true"> · </span>
                                                                <div class="comment-details-menu">

                                                                    <div id="<?php echo 'editcommentbox' . $rowdata['business_profile_post_comment_id']; ?>" style="display:block;">
                                                                        <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                                                        </a>
                                                                    </div>

                                                                    <div id="<?php echo 'editcancle' . $rowdata['business_profile_post_comment_id']; ?>" style="display:none;">
                                                                        <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick="comment_editcancle(this.id)">Cancle
                                                                        </a>
                                                                    </div>

                                                                </div>


                                                            <?php } ?>



                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');

                                                            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;


                                                            if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                                                                ?>      
                                                                <span role="presentation" aria-hidden="true"> · </span>
                                                                <div class="comment-details-menu">



                                                                    <input type="hidden" name="post_delete"  id="post_delete<?php echo $rowdata['business_profile_post_comment_id']; ?>" value= "<?php echo $rowdata['business_profile_post_id']; ?>">
                                                                    <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>"   onClick="comment_delete(this.id)"> Delete<span class="<?php echo 'insertcomment' . $rowdata['business_profile_post_comment_id']; ?>">
                                                                        </span>
                                                                    </a>
                                                                </div>


                                                            <?php } ?>                                       
                                                            <span role="presentation" aria-hidden="true"> · </span>
                                                            <div class="comment-details-menu">
                                                                <p><?php
                                                                    echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                                    echo '</br>';
                                                                    ?></p></div>
                                                        </div></div>


                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <!-- khyati changes end -->

                                    <!-- all comment end -->



                                </div>

                                <div class="post-design-commnet-box col-md-12">

                                    <div class="post-design-proo-img"> 


                                        <?php
                                        $userid = $this->session->userdata('aileenuser');
                                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
                                        if ($business_userimage) {
                                            ?>
                                            <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                            <?php
                                        } else {
                                            ?>
                                            <img  src="<?php echo base_url(NOIMAGE); ?>"  alt="No Image">
                                            <?php
                                        }
                                        ?>
                                    </div>



                                    <div class="">
                                        <div class="col-md-12 inputtype-comment" style="  width: 80%;  padding-left: 7px;">
                                            <div contenteditable="true" class="editable_text" name="<?php echo $busienss_data[0]['business_profile_post_id']; ?>"  id="<?php echo "post_comment" . $busienss_data[0]['business_profile_post_id']; ?>" placeholder="Add a Comment ..." value= "" onClick="entercomment(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"></div></div>
                                        <div class="comment-edit-butn">        
                                            <button id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="insert_comment(this.id)">Comment</button></div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- body content end-->
                    </div>
                </div>
            </div></div></div>

</section>

<footer>
    <?php // echo $footer;          ?> 
    <!-- Bid-modal  -->
    <div class="modal fade message-box biderror" id="bidmodal" role="dialog" style="z-index: 999999 !important;">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;
                </button>       
                <div class="modal-body">
                  <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
                    <span class="mes">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Popup Close -->
</footer>
<!-- Bid-modal-2  -->
<div class="modal fade message-box" id="likeusermodal" role="dialog" style="z-index: 999999 !important;">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes">
                </span>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script src="<?php echo base_url('js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.wallform.js'); ?>"></script> 

<script src="<?php echo base_url('js/demo/jquery-1.9.1.js'); ?>"></script>
<script src="<?php echo base_url('js/demo/jquery-ui-1.9.1.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>



<script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>


<!-- script for business autofill -->
<script>

                                                var data = <?php echo json_encode($demo); ?>;


                                                $(function () {
                                                    // alert('hi');
                                                    $("#tags").autocomplete({
                                                        source: function (request, response) {
                                                            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                                            response($.grep(data, function (item) {
                                                                return matcher.test(item.label);
                                                            }));
                                                        },
                                                        minLength: 1,
                                                        select: function (event, ui) {
                                                            event.preventDefault();
                                                            $("#tags").val(ui.item.label);
                                                            $("#selected-tag").val(ui.item.label);
                                                            // window.location.href = ui.item.value;
                                                        }
                                                        ,
                                                        focus: function (event, ui) {
                                                            event.preventDefault();
                                                            $("#tags").val(ui.item.label);
                                                        }
                                                    });
                                                });

</script>
<script>

                                                var data1 = <?php echo json_encode($city_data); ?>;


                                                $(function () {
                                                    // alert('hi');
                                                    $("#searchplace").autocomplete({
                                                        source: function (request, response) {
                                                            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                                            response($.grep(data1, function (item) {
                                                                return matcher.test(item.label);
                                                            }));
                                                        },
                                                        minLength: 1,
                                                        select: function (event, ui) {
                                                            event.preventDefault();
                                                            $("#searchplace").val(ui.item.label);
                                                            $("#selected-tag").val(ui.item.label);
                                                            // window.location.href = ui.item.value;
                                                        }
                                                        ,
                                                        focus: function (event, ui) {
                                                            event.preventDefault();
                                                            $("#searchplace").val(ui.item.label);
                                                        }
                                                    });
                                                });

</script>


<script src="<?php echo base_url('js/jquery.jMosaic.js'); ?>"></script>
<!-- <script src="<?php //echo base_url('js/bootstrap.min.js');     ?>"></script> -->


<script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('.blocks').jMosaic({items_type: "li", margin: 0});
                                                    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
                                                });

                                                $(window).load(function () {
                                                });

                                                $(window).resize(function () {
                                                });
</script>

<script>
    
   //khyati changes 12-5 start      
   document.getElementById('myModal1').style.display = "block";
   var count = '<?php echo $count; ?>';
   //alert(count);      
   showSlides(slideIndex = count);
   // khyati changes 12-5 end      
   
    function openModal() {
        document.getElementById('myModal1').style.display = "block";
    }

    function closeModal() {
        document.getElementById('myModal1').style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
    }
</script>


<!-- <script>

    $('#searchplace').select2({

        placeholder: 'Find Your Location',
        maximumSelectionLength: 1,
        ajax: {

            url: "<?php echo base_url(); ?>business_profile/location",
            dataType: 'json',
            delay: 250,

            processResults: function (data) {

                return {
                    results: data

                };

            },
            cache: true
        }
    });

</script>
 -->
<script type="text/javascript">
//    function post_like(clicked_id)
//    {
//        $.ajax({
//            type: 'POST',
//            url: '<?php echo base_url() . "business_profile/like_post" ?>',
//            data: 'post_id=' + clicked_id,
//            success: function (data) {
//                $('.' + 'likepost' + clicked_id).html(data);
//            }
//        });
//    }

    function post_like(clicked_id)
    {
        //alert(clicked_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/like_post" ?>',
            data: 'post_id=' + clicked_id,
            dataType: 'json',
            success: function (data) { //alert('.' + 'likepost' + clicked_id);
        
                $('.' + 'likepost' + clicked_id).html(data.like);
                $('.likeusername' + clicked_id).html(data.likeuser);
                $('.comment_like_count' + clicked_id).html(data.like_user_count);
                $('.likeduserlist' + clicked_id).hide();
                if (data.like_user_count == '0') {
                    document.getElementById('likeusername' + clicked_id).style.display = "none";
                } else {
                    document.getElementById('likeusername' + clicked_id).style.display = "block";
                }
                $('#likeusername' + clicked_id).addClass('likeduserlist1');

            }
        });
    }
</script>

<script type="text/javascript">
    function insert_comment(clicked_id)
    {
        /*$("#post_comment" + clicked_id).click(function () {
         $(this).prop("contentEditable", true);
         $(this).html("");
         });
         
         var sel = $("#post_comment" + clicked_id);
         var txt = sel.html();
         if (txt == '') {
         return false;
         }
         
         $('#post_comment' + clicked_id).html("");
         $.ajax({
         type: 'POST',
         url: '<?php echo base_url() . "business_profile/pninsert_comment" ?>',
         data: 'post_id=' + clicked_id + '&comment=' + txt,
         success: function (data) {
         $('textarea').each(function () {
         $(this).val('');
         });
         $('.' + 'insertcomment' + clicked_id).html(data);
         
         }
         }); */

        $("#post_comment" + clicked_id).click(function () {
            $(this).prop("contentEditable", true);
            $(this).html("");
        });

        var sel = $("#post_comment" + clicked_id);
        var txt = sel.html();
        txt = txt.replace(/&nbsp;/gi, " ");
        txt = txt.replace(/<br>$/, '');
        if (txt == '' || txt == '<br>') {
            return false;
        }
        if (/^\s+$/gi.test(txt))
        {
            return false;
        }
        txt = txt.replace(/&/g, "%26");
        $('#post_comment' + clicked_id).html("");

        var x = document.getElementById('threecomment' + clicked_id);
        var y = document.getElementById('fourcomment' + clicked_id);

        if (x.style.display === 'block' && y.style.display === 'none') {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/pninsert_commentthree" ?>',
                data: 'post_id=' + clicked_id + '&comment=' + txt,
                dataType: "json",
                success: function (data) {
                    $('textarea').each(function () {
                        $(this).val('');
                    });
//                    $('#' + 'insertcount' + clicked_id).html(data.count);
                    $('.insertcomment' + clicked_id).html(data.comment);
                    $('.comment_count' + clicked_id).html(data.comment_count);

                }
            });

        } else {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/pninsert_comment" ?>',
                data: 'post_id=' + clicked_id + '&comment=' + txt,
                dataType: "json",
                success: function (data) {
                    $('textarea').each(function () {
                        $(this).val('');
                    });
//                    $('#' + 'insertcount' + clicked_id).html(data.count);
                    $('#' + 'fourcomment' + clicked_id).html(data.comment);
                    $('.comment_count' + clicked_id).html(data.comment_count);
                }
            });
        }
    }
</script>
<script type="text/javascript">

    function entercomment(clicked_id)
    {
        $("#post_comment" + clicked_id).click(function () {
            $(this).prop("contentEditable", true);
        });
        $('#post_comment' + clicked_id).keypress(function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                e.preventDefault();
                var sel = $("#post_comment" + clicked_id);
                var txt = sel.html();
                //txt = txt.replace(/^(&nbsp;|<br>)+/, '');
                txt = txt.replace(/&nbsp;/gi, " ");
                txt = txt.replace(/<br>$/, '');
                if (txt == '' || txt == '<br>') {
                    return false;
                }
                if (/^\s+$/gi.test(txt))
                {
                    return false;
                }
                txt = txt.replace(/&/g, "%26");
                $('#post_comment' + clicked_id).html("");
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);

                /*
                 $.ajax({
                 type: 'POST',
                 url: '<?php echo base_url() . "business_profile/pninsert_comment" ?>',
                 data: 'post_id=' + clicked_id + '&comment=' + txt,
                 success: function (data) {
                 $('textarea').each(function () {
                 $(this).val('');
                 });
                 $('.' + 'insertcomment' + clicked_id).html(data);
                 
                 }
                 });  */

                var x = document.getElementById('threecomment' + clicked_id);
                var y = document.getElementById('fourcomment' + clicked_id);

                if (x.style.display === 'block' && y.style.display === 'none') {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/pninsert_commentthree" ?>',
                        data: 'post_id=' + clicked_id + '&comment=' + txt,
                        dataType: "json",
                        success: function (data) {
                            $('textarea').each(function () {
                                $(this).val('');
                            });
                            //  $('.insertcomment' + clicked_id).html(data);
                            //alert('.insertcount' + clicked_id);
                           // $('#' + 'insertcount' + clicked_id).html(data.count);
                            $('.insertcomment' + clicked_id).html(data.comment);
                            $('.comment_count' + clicked_id).html(data.comment_count);
                        }
                    });

                } else {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/pninsert_comment" ?>',
                        data: 'post_id=' + clicked_id + '&comment=' + txt,
                        dataType: "json",
                        success: function (data) {
                            $('textarea').each(function () {
                                $(this).val('');
                            });
                            //$('#' + 'fourcomment' + clicked_id).html(data);
                            //$('#' + 'insertcount' + clicked_id).html(data.count);
                            $('#' + 'fourcomment' + clicked_id).html(data.comment);
                            $('.comment_count' + clicked_id).html(data.comment_count);
                        }
                    });
                }


            }
        });


    }
</script>

<script type="text/javascript">
//    function commentall(clicked_id) {
//
//
//        var x = document.getElementById('threecomment' + clicked_id);
//        var y = document.getElementById('fourcomment' + clicked_id);
//        var z = document.getElementById('commnetpost' + clicked_id);
//
//
//
//
//        if (x.style.display === 'block' && y.style.display === 'none') {
//            x.style.display = 'none';
//            y.style.display = 'block';
//            z.style.display = 'none';
//            $.ajax({
//                type: 'POST',
//                url: '<?php echo base_url() . "business_profile/pnfourcomment" ?>',
//                data: 'bus_post_id=' + clicked_id,
//                //alert(data);
//                success: function (data) {
//                    $('#' + 'fourcomment' + clicked_id).html(data);
//
//                }
//            });
//
//        }
//
//    }


    function commentall(clicked_id) {

        var x = document.getElementById('threecomment' + clicked_id);
        var y = document.getElementById('fourcomment' + clicked_id);
        var z = document.getElementById('insertcount' + clicked_id);
        $('.post-design-commnet-box').show();
        if (x.style.display === 'block' && y.style.display === 'none') {

            x.style.display = 'none';
            y.style.display = 'block';
            z.style.visibility = 'show';

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/pnfourcomment" ?>',
                data: 'bus_post_id=' + clicked_id,
                //alert(data);
                success: function (data) {
                    $('#' + 'fourcomment' + clicked_id).html(data);

                }
            });
        }
    }

</script>
<script type="text/javascript">
    function comment_like(clicked_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/like_comment" ?>',
            data: 'post_id=' + clicked_id,
            success: function (data) {
                $('#' + 'likecomment' + clicked_id).html(data);

            }
        });
    }
</script>


<script type="text/javascript">
    function comment_like1(clicked_id)
    {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/like_comment1" ?>',
            data: 'post_id=' + clicked_id,
            success: function (data) {
                $('#' + 'likecomment1' + clicked_id).html(data);

            }
        });
    }
</script>


<script type="text/javascript">


    function comment_delete(clicked_id) {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }


    function comment_deleted(clicked_id)
    {
        var post_delete = document.getElementById("post_delete" + clicked_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/pndelete_comment" ?>',
            data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
            dataType: "json",
            success: function (data) {
//                alert(data.comment_count);
                $('.' + 'insertcomment' + post_delete.value).html(data.comment);
                //$('#' + 'insertcount' + post_delete.value).html(data.count);
                $('.comment_count' + post_delete.value).html(data.comment_count);
                $('.post-design-commnet-box').show();
            }
        });
    }


    /*  function comment_deletetwo(clicked_id)
     {
     
     $('.biderror .mes').html("<div class='pop_content'>Are you sure want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
     $('#bidmodal').modal('show');
     }
     
     function comment_deletedtwo(clicked_id)
     {
     
     var post_delete = document.getElementById("post_delete");
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url() . "business_profile/pndelete_commenttwo" ?>',
     dataType: 'json',
     data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
     success: function (data) { //alert('.' + 'insertcomment' + clicked_id);
     
     $('#' + 'fourcomment' + post_delete.value).html(data.comment);
     $('#' + 'commnetpost' + post_delete.value).html(data.count);
     
     }
     });
     } */

    function comment_deletetwo(clicked_id)
    {

        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }

    function comment_deletedtwo(clicked_id)
    {

        var post_delete1 = document.getElementById("post_deletetwo");

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/pndelete_commenttwo" ?>',
            data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
            dataType: "json",
            success: function (data) { //alert('.' + 'insertcomment' + clicked_id);
                $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
//                $('#' + 'insertcount' + post_delete1.value).html(data.count);
                $('.comment_count' + post_delete1.value).html(data.comment_count);
                $('.post-design-commnet-box').show();
            }
        });
    }
</script>

<script type="text/javascript">

    function comment_editbox(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
        document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
        document.getElementById('showcomment' + clicked_id).style.display = 'none';
        document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';

        document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
        document.getElementById('editcancle' + clicked_id).style.display = 'block';

        $('.post-design-commnet-box').hide();

    }

    function comment_editcancle(clicked_id) {

        document.getElementById('editcommentbox' + clicked_id).style.display = 'block';
        document.getElementById('editcancle' + clicked_id).style.display = 'none';

        document.getElementById('editcomment' + clicked_id).style.display = 'none';
        document.getElementById('showcomment' + clicked_id).style.display = 'block';
        document.getElementById('editsubmit' + clicked_id).style.display = 'none';

        $('.post-design-commnet-box').show();
    }

    function comment_editboxtwo(clicked_id) {
//                    alert(clicked_id);
//                    return false;

        $('div[id^=editcommenttwo]').css('display', 'none');
        $('div[id^=showcommenttwo]').css('display', 'block');
        $('button[id^=editsubmittwo]').css('display', 'none');
        $('div[id^=editcommentboxtwo]').css('display', 'block');
        $('div[id^=editcancletwo]').css('display', 'none');

        document.getElementById('editcommenttwo' + clicked_id).style.display = 'inline-block';
        document.getElementById('showcommenttwo' + clicked_id).style.display = 'none';
        document.getElementById('editsubmittwo' + clicked_id).style.display = 'inline-block';
        document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'none';
        document.getElementById('editcancletwo' + clicked_id).style.display = 'block';
        $('.post-design-commnet-box').hide();
//                    document.getElementById('editcomment' + clicked_id).style.display = 'block';
//                    document.getElementById('showcomment' + clicked_id).style.display = 'none';
//                    document.getElementById('editsubmit' + clicked_id).style.display = 'block';
//                    document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
//                    document.getElementById('editcancle' + clicked_id).style.display = 'block';

    }

    function comment_editcancletwo(clicked_id) {
        document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
        document.getElementById('editcancletwo' + clicked_id).style.display = 'none';
        document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
        document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
        document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
        $('.post-design-commnet-box').show();
    }

    function comment_editbox3(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
        document.getElementById('editcomment3' + clicked_id).style.display = 'block';
        document.getElementById('showcomment3' + clicked_id).style.display = 'none';
        document.getElementById('editsubmit3' + clicked_id).style.display = 'block';

        document.getElementById('editcommentbox3' + clicked_id).style.display = 'none';
        document.getElementById('editcancle3' + clicked_id).style.display = 'block';
        $('.post-design-commnet-box').hide();

    }

    function comment_editcancle3(clicked_id) {

        document.getElementById('editcommentbox3' + clicked_id).style.display = 'block';
        document.getElementById('editcancle3' + clicked_id).style.display = 'none';

        document.getElementById('editcomment3' + clicked_id).style.display = 'none';
        document.getElementById('showcomment3' + clicked_id).style.display = 'block';
        document.getElementById('editsubmit3' + clicked_id).style.display = 'none';

        $('.post-design-commnet-box').show();

    }

    function comment_editbox4(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
        document.getElementById('editcomment4' + clicked_id).style.display = 'block';
        document.getElementById('showcomment4' + clicked_id).style.display = 'none';
        document.getElementById('editsubmit4' + clicked_id).style.display = 'block';

        document.getElementById('editcommentbox4' + clicked_id).style.display = 'none';
        document.getElementById('editcancle4' + clicked_id).style.display = 'block';

        $('.post-design-commnet-box').hide();

    }

    function comment_editcancle4(clicked_id) {

        document.getElementById('editcommentbox4' + clicked_id).style.display = 'block';
        document.getElementById('editcancle4' + clicked_id).style.display = 'none';

        document.getElementById('editcomment4' + clicked_id).style.display = 'none';
        document.getElementById('showcomment4' + clicked_id).style.display = 'block';
        document.getElementById('editsubmit4' + clicked_id).style.display = 'none';

        $('.post-design-commnet-box').show();

    }

</script>
<script type="text/javascript">
    /*  function edit_comment(abc)
     {
     
     $("#editcomment" + abc).click(function () {
     $(this).prop("contentEditable", true);
     });
     
     
     var sel = $("#editcomment" + abc);
     var txt = sel.html();
     if (txt == '' || txt == '<br>') {
     $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
     $('#bidmodal').modal('show');
     return false;
     }
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
     data: 'post_id=' + abc + '&comment=' + txt,
     success: function (data) {
     
     document.getElementById('editcomment' + abc).style.display = 'none';
     document.getElementById('showcomment' + abc).style.display = 'block';
     document.getElementById('editsubmit' + abc).style.display = 'none';
     
     
     document.getElementById('editcommentbox' + abc).style.display = 'block';
     document.getElementById('editcancle' + abc).style.display = 'none';
     $('#' + 'showcomment' + abc).html(data);
     
     
     
     }
     });
     
     } */

    function edit_comment(abc)
    {

        $("#editcomment" + abc).click(function () {
            $(this).prop("contentEditable", true);
        });

        var sel = $("#editcomment" + abc);
        var txt = sel.html();
        txt = txt.replace(/&nbsp;/gi, " ");
        txt = txt.replace(/<br>$/, '');
        if (txt == '' || txt == '<br>') {
            return false;
        }
        if (/^\s+$/gi.test(txt))
        {
            return false;
        }
        txt = txt.replace(/&/g, "%26");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
            data: 'post_id=' + abc + '&comment=' + txt,
            success: function (data) {

                document.getElementById('editcomment' + abc).style.display = 'none';
                document.getElementById('showcomment' + abc).style.display = 'block';
                document.getElementById('editsubmit' + abc).style.display = 'none';

                document.getElementById('editcommentbox' + abc).style.display = 'block';
                document.getElementById('editcancle' + abc).style.display = 'none';
                $('#' + 'showcomment' + abc).html(data);
                $('.post-design-commnet-box').show();


            }
        });
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
        });

    }
</script>


<script type="text/javascript">

    /* function commentedit(abc)
     {
     $("#editcomment" + abc).click(function () {
     $(this).prop("contentEditable", true);
     });
     
     $('#editcomment' + abc).keypress(function (event) {
     if (event.which == 13 && event.shiftKey != 1) {
     event.preventDefault();
     var sel = $("#editcomment" + abc);
     var txt = sel.html();
     if (txt == '' || txt == '<br>') {
     $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
     $('#bidmodal').modal('show');
     return false;
     }
     if (window.preventDuplicateKeyPresses)
     return;
     window.preventDuplicateKeyPresses = true;
     window.setTimeout(function () {
     window.preventDuplicateKeyPresses = false;
     }, 500);
     
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
     data: 'post_id=' + abc + '&comment=' + txt,
     success: function (data) {
     
     
     document.getElementById('editcomment' + abc).style.display = 'none';
     document.getElementById('showcomment' + abc).style.display = 'block';
     document.getElementById('editsubmit' + abc).style.display = 'none';
     
     document.getElementById('editcommentbox' + abc).style.display = 'block';
     document.getElementById('editcancle' + abc).style.display = 'none';
     
     $('#' + 'showcomment' + abc).html(data);
     
     }
     });
     
     }
     });
     
     
     } */

    function commentedit(abc)
    {

        $("#editcomment" + abc).click(function () {
            $(this).prop("contentEditable", true);
        });
        $('#editcomment' + abc).keypress(function (event) {
            if (event.which == 13 && event.shiftKey != 1) {
                event.preventDefault();
                var sel = $("#editcomment" + abc);
                var txt = sel.html();
                txt = txt.replace(/&nbsp;/gi, " ");
                txt = txt.replace(/<br>$/, '');
                if (txt == '' || txt == '<br>') {
                    return false;
                }
                if (/^\s+$/gi.test(txt))
                {
                    return false;
                }
                txt = txt.replace(/&/g, "%26");
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                    data: 'post_id=' + abc + '&comment=' + txt,
                    success: function (data) { //alert('falguni');
                        document.getElementById('editcomment' + abc).style.display = 'none';
                        document.getElementById('showcomment' + abc).style.display = 'block';
                        document.getElementById('editsubmit' + abc).style.display = 'none';
                        document.getElementById('editcommentbox' + abc).style.display = 'block';
                        document.getElementById('editcancle' + abc).style.display = 'none';
                        $('#' + 'showcomment' + abc).html(data);
                        $('.post-design-commnet-box').show();
                    }
                });
            }
        });
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
        });
    }
</script>


<script type="text/javascript">
    /*function edit_commenttwo(abc)
     {
     $("#editcommenttwo" + abc).click(function () {
     $(this).prop("contentEditable", true);
     });
     var sel = $("#editcommenttwo" + abc);
     var txt = sel.html();
     if (txt == '' || txt == '<br>') {
     $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
     $('#bidmodal').modal('show');
     return false;
     } else {
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
     data: 'post_id=' + abc + '&comment=' + txt,
     success: function (data) {
     document.getElementById('editcommenttwo' + abc).style.display = 'none';
     document.getElementById('showcommenttwo' + abc).style.display = 'block';
     document.getElementById('editsubmittwo' + abc).style.display = 'none';
     
     document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
     document.getElementById('editcancletwo' + abc).style.display = 'none';
     //alert('.' + 'showcomment' + abc);
     $('#' + 'showcommenttwo' + abc).html(data);
     
     }
     });
     }
     
     }*/

    function edit_commenttwo(abc)
    {
        //var post_comment_edit = document.getElementById("editcommenttwo" + abc);

        $("#editcommenttwo" + abc).click(function () {
            $(this).prop("contentEditable", true);
            //$(this).html("");
        });

        var sel = $("#editcommenttwo" + abc);
        var txt = sel.html();
        txt = txt.replace(/&nbsp;/gi, " ");
        txt = txt.replace(/<br>$/, '');
        if (txt == '' || txt == '<br>') {
            return false;
        }
        if (/^\s+$/gi.test(txt))
        {
            return false;
        }
        txt = txt.replace(/&/g, "%26");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
            data: 'post_id=' + abc + '&comment=' + txt,
            success: function (data) { //alert('falguni');

                document.getElementById('editcommenttwo' + abc).style.display = 'none';
                document.getElementById('showcommenttwo' + abc).style.display = 'block';
                document.getElementById('editsubmittwo' + abc).style.display = 'none';

                document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                document.getElementById('editcancletwo' + abc).style.display = 'none';
                $('#' + 'showcommenttwo' + abc).html(data);
                $('.post-design-commnet-box').show();
            }
        });
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
        });

    }
</script>


<script type="text/javascript">
    /*
     function commentedittwo(abc)
     {
     $("#editcommenttwo" + abc).click(function () {
     $(this).prop("contentEditable", true);
     });
     
     
     $('#editcommenttwo' + abc).keypress(function (event) {
     if (event.which == 13 && event.shiftKey != 1) {
     var sel = $("#editcommenttwo" + abc);
     var txt = sel.html();
     if (txt == '' || txt == '<br>') {
     $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
     $('#bidmodal').modal('show');
     return false;
     }
     
     if (window.preventDuplicateKeyPresses)
     return;
     
     window.preventDuplicateKeyPresses = true;
     window.setTimeout(function () {
     window.preventDuplicateKeyPresses = false;
     }, 500);
     
     
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
     data: 'post_id=' + abc + '&comment=' + txt,
     success: function (data) { //alert('falguni');
     
     document.getElementById('editcommenttwo' + abc).style.display = 'none';
     document.getElementById('showcommenttwo' + abc).style.display = 'block';
     document.getElementById('editsubmittwo' + abc).style.display = 'none';
     
     document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
     document.getElementById('editcancletwo' + abc).style.display = 'none';
     $('#' + 'showcommenttwo' + abc).html(data);
     
     }
     });
     
     }
     });
     
     } */

    function commentedittwo(abc)
    {
        //$(document).ready(function () {
        $("#editcommenttwo" + abc).click(function () {
            $(this).prop("contentEditable", true);
            //$(this).html("");
        });

        $('#editcommenttwo' + abc).keypress(function (event) {
            if (event.which == 13 && event.shiftKey != 1) {
                event.preventDefault();

                var sel = $("#editcommenttwo" + abc);
                var txt = sel.html();

                txt = txt.replace(/&nbsp;/gi, " ");
                txt = txt.replace(/<br>$/, '');
                if (txt == '' || txt == '<br>') {
                    return false;
                }
                if (/^\s+$/gi.test(txt))
                {
                    return false;
                }
                txt = txt.replace(/&/g, "%26");
                //$('#editcommenttwo' + abc).html("");

                if (window.preventDuplicateKeyPresses)
                    return;

                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                    data: 'post_id=' + abc + '&comment=' + txt,
                    success: function (data) { //alert('falguni');


                        document.getElementById('editcommenttwo' + abc).style.display = 'none';
                        document.getElementById('showcommenttwo' + abc).style.display = 'block';
                        document.getElementById('editsubmittwo' + abc).style.display = 'none';

                        document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                        document.getElementById('editcancletwo' + abc).style.display = 'none';
                        //alert('.' + 'showcomment' + abc);

                        $('#' + 'showcommenttwo' + abc).html(data);
                        $('.post-design-commnet-box').show();


                    }
                });
            }
        });
        //});
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
        });

    }

</script>

<script>
    var modal = document.getElementById('myModal');

    var btn = document.getElementById("myBtn");

    var span = document.getElementsByClassName("close1")[0];

    btn.onclick = function () {
        modal.style.display = "block";
    }

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script src="jquery-1.8.2.js"></script>
<script>
    $(function () {
//        var showTotalChar = 150, showChar = "More", hideChar = "less";
        var showTotalChar = 180, showChar = "ReadMore", hideChar = "";
        $('.show_desc').each(function () {
            //var content = $(this).text();
            var content = $(this).html();
            content = content.replace(/ /g, '');
            if (content.length > showTotalChar) {
                var con = content.substr(0, showTotalChar);
                var hcon = content.substr(showTotalChar, content.length - showTotalChar);
                var txt = con + '<span class="dots">...</span><span class="morectnt"><span>' + hcon + '</span>&nbsp;&nbsp;<a href="" class="showmoretxt">' + showChar + '</a></span>';
                $(this).html(txt);
            }
        });
        $(".showmoretxt").click(function () {
            if ($(this).hasClass("sample")) {
                $(this).removeClass("sample");
                $(this).text(showChar);
            } else {
                $(this).addClass("sample");
                $(this).text(hideChar);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>

<script>
    function myFunction(clicked_id) {
        document.getElementById('myDropdown' + clicked_id).classList.toggle("show");


        $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) { 

                    document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
                    $(".dropdown-content1").removeClass('show');

                            }
                           
                        }); 
    }
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn1')) {

            var dropdowns = document.getElementsByClassName("dropdown-content1");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
<script type="text/javascript">
    var $fileUpload = $("#files"),
            $list = $('#list'),
            thumbsArray = [],
            maxUpload = 5;

    function read(f) {
        return function (e) {
            var base64 = e.target.result;
            var $img = $('<img/>', {
                src: base64,
                title: encodeURIComponent(f.name),
                "class": "thumb"
            });
            var $thumbParent = $("<span/>", {html: $img, "class": "thumbParent"}).append('<span class="remove_thumb"/>');
            thumbsArray.push(base64);
            $list.append($thumbParent);
        };
    }


    function handleFileSelect(e) {
        e.preventDefault();
        var files = e.target.files;
        var len = files.length;
        if (len > maxUpload || thumbsArray.length >= maxUpload) {
            return alert("Sorry you can upload only 5 images");
        }
        for (var i = 0; i < len; i++) {
            var f = files[i];
            if (!f.type.match('image.*'))
                continue;
            var reader = new FileReader();
            reader.onload = read(f);
            reader.readAsDataURL(f);
        }
    }

    $fileUpload.change(function (e) {
        handleFileSelect(e);
    });

    $list.on('click', '.remove_thumb', function () {
        var $removeBtns = $('.remove_thumb');
        var idx = $removeBtns.index(this);
        $(this).closest('span.thumbParent').remove();
        thumbsArray.splice(idx, 1);
    });



</script>
<script type="text/javascript">
    function save_post(abc)
    {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/business_profile_save" ?>',
            data: 'business_profile_post_id=' + abc,
            success: function (data) {

                $('.' + 'savedpost' + abc).html(data);


            }
        });

    }
</script>

<script type="text/javascript">
    function remove_post(abc)
    {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/business_profile_deletepost" ?>',
            data: 'business_profile_post_id=' + abc,
            success: function (data) {

                $('#' + 'removepost' + abc).html(data);
                window.location = "<?php echo base_url() ?>business_profile/business_profile_post";


            }
        });

    }
</script>

<script type="text/javascript">
    function del_particular_userpost(abc)
    {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/del_particular_userpost" ?>',
            data: 'business_profile_post_id=' + abc,
            success: function (data) {

                $('#' + 'removepost' + abc).html(data);


            }
        });

    }
</script>

<script type="text/javascript">
    function mulimg_like(clicked_id)
    {
        /*$.ajax({
         type: 'POST',
         url: '<?php echo base_url() . "business_profile/mulimg_like" ?>',
         data: 'post_image_id=' + clicked_id,
         success: function (data) {
         //alert(data);
         $('.' + 'likeimgpost' + clicked_id).html(data);
         
         }
         }); */

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/mulimg_like" ?>',
            data: 'post_image_id=' + clicked_id,
            dataType: 'json',
            success: function (data) {
                // $('.' + 'likepost' + clicked_id).html(data);
                //alert(data.like_user_count);

                $('.' + 'likepostimg' + clicked_id).html(data.like);
                $('.likeusernameimg' + clicked_id).html(data.likeuser);
                $('.comment_like_count_img' + clicked_id).html(data.like_user_count);
                $('.likeduserlistimg' + clicked_id).hide();
                if (data.like_user_count == '0') {
                    document.getElementById('likeusernameimg' + clicked_id).style.display = "none";
                } else {
                    document.getElementById('likeusernameimg' + clicked_id).style.display = "block";
                }
                $('#likeusernameimg' + clicked_id).addClass('likeduserlist1');
            }
        });
    }
</script>

<script type="text/javascript">

    function insert_commentimg(clicked_id)
    {

        $("#post_imgcomment" + clicked_id).click(function () {
            $(this).prop("contentEditable", true);
            $(this).html("");
        });

        var sel = $("#post_imgcomment" + clicked_id);
        var txt = sel.html();
        txt = txt.replace(/&nbsp;/gi, " ");
        txt = txt.replace(/<br>$/, '');
        if (txt == '' || txt == '<br>') {
            return false;
        }
        if (/^\s+$/gi.test(txt))
        {
            return false;
        }
        txt = txt.replace(/&/g, "%26");
        $('#post_imgcomment' + clicked_id).html("");

        var x = document.getElementById('threeimgcomment' + clicked_id);
        var y = document.getElementById('fourimgcomment' + clicked_id);

        if (x.style.display === 'block' && y.style.display === 'none') {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/pnmulimgcommentthree" ?>',
                data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                dataType: "json",
                success: function (data) {
                    $('textarea').each(function () {
                        $(this).val('');
                    });
                    $('.' + 'insertimgcomment' + clicked_id).html(data.comment);
                    $('#' + 'insertcountimg' + clicked_id).html(data.count);

                }
            });

        } else {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/pnmulimg_comment" ?>',
                data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                dataType: "json",
                success: function (data) {
                    $('textarea').each(function () {
                        $(this).val('');
                    });
//                    alert('#' + 'insertimgcount' + clicked_id);
//                    alert(data.count);
//                    
//                    alert('#' + 'fourimgcomment' + clicked_id);
//                    alert(data.comment);

                    $('#' + 'insertcountimg' + clicked_id).html(data.count);
                    $('#' + 'fourimgcomment' + clicked_id).html(data.comment);

                    //$('#' + 'insertcommenttwo' + clicked_id).html(data);

                }
            });
        }
    }

</script>

<script type="text/javascript">

    function entercommentimg(clicked_id)
    {


        $("#post_imgcomment" + clicked_id).click(function () {
            $(this).prop("contentEditable", true);
        });

        $('#post_imgcomment' + clicked_id).keypress(function (e) {

            if (e.keyCode == 13 && !e.shiftKey) {
                e.preventDefault();
                var sel = $("#post_imgcomment" + clicked_id);
                var txt = sel.html();
                //txt = txt.replace(/^(&nbsp;|<br>)+/, '');
                txt = txt.replace(/&nbsp;/gi, " ");
                txt = txt.replace(/<br>$/, '');
                if (txt == '' || txt == '<br>') {
                    return false;
                }
                if (/^\s+$/gi.test(txt))
                {
                    return false;
                }
                txt = txt.replace(/&/g, "%26");
                $('#post_imgcomment' + clicked_id).html("");

                if (window.preventDuplicateKeyPresses)
                    return;

                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);



                var x = document.getElementById('threeimgcomment' + clicked_id);
                var y = document.getElementById('fourimgcomment' + clicked_id);

                if (x.style.display === 'block' && y.style.display === 'none') {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/pnmulimgcommentthree" ?>',
                        data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                        dataType: "json",
                        success: function (data) {

                            $('.' + 'insertimgcomment' + clicked_id).html(data.comment);
//                            $('#' + 'insertcountimg' + clicked_id).html(data.count);
                            $('.comment_count_img' + clicked_id).html(data.comment_count);
                        }
                    });

                } else {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/pnmulimg_comment" ?>',
                        data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                        success: function (data) {
//                            $('#' + 'insertcommenttwo' + clicked_id).html(data);
//alert('#' + 'insertimgcount' + clicked_id);

//                            $('#' + 'insertcountimg' + clicked_id).html(data.count);
                            $('#' + 'fourimgcomment' + clicked_id).html(data.comment);
                            $('.comment_count_img' + clicked_id).html(data.comment_count);
                        }
                    });
                }
            }
        });


    }
</script>

<script type="text/javascript">
    function imgcommentall(clicked_id) {


        var x = document.getElementById('threeimgcomment' + clicked_id);
        var y = document.getElementById('fourimgcomment' + clicked_id);
        var z = document.getElementById('insertcountimg' + clicked_id);
        $('.post-design-commnet-box').show();
        if (x.style.display === 'block' && y.style.display === 'none') {
            x.style.display = 'none';
            y.style.display = 'block';
            z.style.visibility = 'show';
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/pnmulimagefourcomment" ?>',
                data: 'bus_img_id=' + clicked_id,
                success: function (data) {
                    $('#' + 'fourimgcomment' + clicked_id).html(data);

                }
            });
        }
    }
</script>


<script type="text/javascript">
    function commentall1(clicked_id) { //alert("xyz");

        //alert(clicked_id);
        var x = document.getElementById('threecomment1' + clicked_id);
        var y = document.getElementById('fourcomment1' + clicked_id);
        if (x.style.display === 'block' && y.style.display === 'none') {
            x.style.display = 'none';
            y.style.display = 'block';

        } else {
            x.style.display = 'block';
            y.style.display = 'none';
        }

    }
</script>

<script type="text/javascript">
    function imgcommentall1(clicked_id) { //alert("xyz");

        //alert(clicked_id);
        var x = document.getElementById('threeimgcomment1' + clicked_id);
        var y = document.getElementById('fourimgcomment1' + clicked_id);
        if (x.style.display === 'block' && y.style.display === 'none') {
            x.style.display = 'none';
            y.style.display = 'block';

        } else {
            x.style.display = 'block';
            y.style.display = 'none';
        }

    }
</script>
<script type="text/javascript">
    function imgcomment_like(clicked_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/mulimg_comment_like" ?>',
            data: 'post_image_comment_id=' + clicked_id,
            success: function (data) {
                $('#' + 'imglikecomment' + clicked_id).html(data);
            }
        });
    }
    function imgcomment_liketwo(clicked_id)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/mulimg_comment_liketwo" ?>',
            data: 'post_image_comment_id=' + clicked_id,
            success: function (data) {
                $('#' + 'imglikecomment1' + clicked_id).html(data);

            }
        });
    }
</script>
<script type="text/javascript">

    function imgcomment_editbox(clicked_id) {
        document.getElementById('imgeditcomment' + clicked_id).style.display = 'inline-block';
        document.getElementById('imgshowcomment' + clicked_id).style.display = 'none';
        document.getElementById('imgeditsubmit' + clicked_id).style.display = 'inline-block';
        document.getElementById('imgeditcommentbox' + clicked_id).style.display = 'none';
        document.getElementById('imgeditcancle' + clicked_id).style.display = 'block';

        $('.post-design-commnet-box').hide();
    }

    function imgcomment_editcancle(clicked_id) {

        document.getElementById('imgeditcommentbox' + clicked_id).style.display = 'block';
        document.getElementById('imgeditcancle' + clicked_id).style.display = 'none';

        document.getElementById('imgeditcomment' + clicked_id).style.display = 'none';
        document.getElementById('imgshowcomment' + clicked_id).style.display = 'block';
        document.getElementById('imgeditsubmit' + clicked_id).style.display = 'none';
        $('.post-design-commnet-box').show();
    }

    function imgcomment_editboxtwo(clicked_id) {

        $('div[id^=imgeditcommenttwo]').css('display', 'none');
        $('div[id^=imgshowcommenttwo]').css('display', 'block');
        $('button[id^=imgeditsubmittwo]').css('display', 'none');
        $('div[id^=imgeditcommentboxtwo]').css('display', 'block');
        $('div[id^=imgeditcancletwo]').css('display', 'none');

        document.getElementById('imgeditcommenttwo' + clicked_id).style.display = 'inline-block';
        document.getElementById('imgshowcommenttwo' + clicked_id).style.display = 'none';
        document.getElementById('imgeditsubmittwo' + clicked_id).style.display = 'inline-block';
        document.getElementById('imgeditcommentboxtwo' + clicked_id).style.display = 'none';
        document.getElementById('imgeditcancletwo' + clicked_id).style.display = 'block';
        $('.post-design-commnet-box').hide();
    }

    function imgcomment_editcancletwo(clicked_id) {
        document.getElementById('imgeditcommentboxtwo' + clicked_id).style.display = 'block';
        document.getElementById('imgeditcancletwo' + clicked_id).style.display = 'none';
        document.getElementById('imgeditcommenttwo' + clicked_id).style.display = 'none';
        document.getElementById('imgshowcommenttwo' + clicked_id).style.display = 'block';
        document.getElementById('imgeditsubmittwo' + clicked_id).style.display = 'none';
        $('.post-design-commnet-box').show();
    }

</script>
<script type="text/javascript">
    function imgedit_comment(abc)
    {
        $("#imgeditcomment" + abc).click(function () {
            $(this).prop("contentEditable", true);
        });

        var sel = $("#imgeditcomment" + abc);
        var txt = sel.html();
        txt = txt.replace(/&nbsp;/gi, " ");
        txt = txt.replace(/<br>$/, '');
        if (txt == '' || txt == '<br>') {
            $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deleted(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
            return false;
        } else if (/^\s+$/gi.test(txt))
        {
            return false;
        } else {
            txt = txt.replace(/&/g, "%26");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/mul_edit_com_insert" ?>',
                data: 'post_image_comment_id=' + abc + '&comment=' + txt,
                success: function (data) {


                    document.getElementById('imgeditcomment' + abc).style.display = 'none';
                    document.getElementById('imgshowcomment' + abc).style.display = 'block';
                    document.getElementById('imgeditsubmit' + abc).style.display = 'none';

                    document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
                    document.getElementById('imgeditcancle' + abc).style.display = 'none';
                    $('#' + 'imgshowcomment' + abc).html(data);

                    $('.post-design-commnet-box').show();

                }
            });
        }

    }
</script>


<script type="text/javascript">

    /*
     function imgcommentedit(abc)
     {
     
     $("#imgeditcomment" + abc).click(function () {
     $(this).prop("contentEditable", true);
     
     });
     
     $('#imgeditcomment' + abc).keypress(function (event) {
     
     if (event.which == 13 && event.shiftKey != 1) {
     vent.preventDefault();
     var sel = $("#imgeditcomment" + abc);
     var txt = sel.html();
     if (txt == '' || txt == '<br>') {
     $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deleted(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
     $('#bidmodal').modal('show');
     return false;
     } else {
     
     if (window.preventDuplicateKeyPresses)
     return;
     window.preventDuplicateKeyPresses = true;
     window.setTimeout(function () {
     window.preventDuplicateKeyPresses = false;
     }, 500);
     
     
     $.ajax({
     type: 'POST',
     url: '<?php echo base_url() . "business_profile/mul_edit_com_insert" ?>',
     data: 'post_image_comment_id=' + abc + '&comment=' + txt,
     success: function (data) {
     
     
     document.getElementById('imgeditcomment' + abc).style.display = 'none';
     document.getElementById('imgshowcomment' + abc).style.display = 'block';
     document.getElementById('imgeditsubmit' + abc).style.display = 'none';
     
     document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
     document.getElementById('imgeditcancle' + abc).style.display = 'none';
     
     $('#' + 'imgshowcomment' + abc).html(data);
     
     
     
     }
     });
     }
     
     }
     });
     
     
     } */

    function imgcommentedit(abc)
    {
        $("#imgeditcomment" + abc).click(function () {
            $(this).prop("contentEditable", true);
        });

        $('#imgeditcomment' + abc).keypress(function (event) {

            if (event.which == 13 && event.shiftKey != 1) {
                event.preventDefault();
                var sel = $("#imgeditcomment" + abc);
                var txt = sel.html();
                txt = txt.replace(/&nbsp;/gi, " ");
                txt = txt.replace(/<br>$/, '');
                if (txt == '' || txt == '<br>') {
                    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deleted(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                    return false;
                } else if (/^\s+$/gi.test(txt))
                {
                    return false;
                } else {
                    txt = txt.replace(/&/g, "%26");
                    if (window.preventDuplicateKeyPresses)
                        return;
                    window.preventDuplicateKeyPresses = true;
                    window.setTimeout(function () {
                        window.preventDuplicateKeyPresses = false;
                    }, 500);


                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/mul_edit_com_insert" ?>',
                        data: 'post_image_comment_id=' + abc + '&comment=' + txt,
                        success: function (data) {


                            document.getElementById('imgeditcomment' + abc).style.display = 'none';
                            document.getElementById('imgshowcomment' + abc).style.display = 'block';
                            document.getElementById('imgeditsubmit' + abc).style.display = 'none';

                            document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
                            document.getElementById('imgeditcancle' + abc).style.display = 'none';

                            $('#' + 'imgshowcomment' + abc).html(data);
                            $('.post-design-commnet-box').show();


                        }
                    });
                }

            }
        });


    }
</script>



<script type="text/javascript">
    function imgedit_commenttwo(abc)
    {

        $("#imgeditcommenttwo" + abc).click(function () {
            $(this).prop("contentEditable", true);

        });

        var sel = $("#imgeditcommenttwo" + abc);
        var txt = sel.html();
        txt = txt.replace(/&nbsp;/gi, " ");
        txt = txt.replace(/<br>$/, '');
        if (txt == '' || txt == '<br>') {
            $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deletedtwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
            return false;
        }
        if (/^\s+$/gi.test(txt))
        {
            return false;
        }
        txt = txt.replace(/&/g, "%26");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/mul_edit_com_insert" ?>',
            data: 'post_image_comment_id=' + abc + '&comment=' + txt,
            success: function (data) {
                //alert(data);
                document.getElementById('imgeditcommenttwo' + abc).style.display = 'none';
                document.getElementById('imgshowcommenttwo' + abc).style.display = 'block';
                document.getElementById('imgeditsubmittwo' + abc).style.display = 'none';

                document.getElementById('imgeditcommentboxtwo' + abc).style.display = 'block';
                document.getElementById('imgeditcancletwo' + abc).style.display = 'none';
                $('#' + 'imgshowcommenttwo' + abc).html(data);
                $('.post-design-commnet-box').show();
            }
        });
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
        });
    }
</script>

<script type="text/javascript">

    function imgcommentedittwo(abc)
    {

        $("#imgeditcommenttwo" + abc).click(function () {
            $(this).prop("contentEditable", true);
        });

        $('#imgeditcommenttwo' + abc).keypress(function (event) {
            if (event.which == 13 && event.shiftKey != 1) {
                event.preventDefault();
                var sel = $("#imgeditcommenttwo" + abc);
                var txt = sel.html();

                txt = txt.replace(/&nbsp;/gi, " ");
                txt = txt.replace(/<br>$/, '');
                if (txt == '' || txt == '<br>') {
                    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deletedtwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                    return false;
                }
                if (/^\s+$/gi.test(txt))
                {
                    return false;
                }
                txt = txt.replace(/&/g, "%26");
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "business_profile/mul_edit_com_insert" ?>',
                    data: 'post_image_comment_id=' + abc + '&comment=' + txt,
                    success: function (data) {


                        document.getElementById('imgeditcommenttwo' + abc).style.display = 'none';
                        document.getElementById('imgshowcommenttwo' + abc).style.display = 'block';
                        document.getElementById('imgeditsubmittwo' + abc).style.display = 'none';

                        document.getElementById('imgeditcommentboxtwo' + abc).style.display = 'block';
                        document.getElementById('imgeditcancletwo' + abc).style.display = 'none';
                        $('#' + 'imgshowcommenttwo' + abc).html(data);
                        $('.post-design-commnet-box').show();
                    }
                });


            }
        });


    }
</script>


<script type="text/javascript">


    function imgcomment_delete(clicked_id) {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='imgcomment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }

    function imgcomment_deleted(clicked_id)
    {
        var post_delete = document.getElementById("imgpost_delete_" + clicked_id);
        //alert(post_delete.value);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/mul_delete_comment" ?>',
            dataType: 'json',
            data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete.value,
            success: function (data) {
                //$('#' + 'insertimgcount' + post_delete.value).html(data.count);
//                $('#' + 'insertcountimg' + post_delete.value).html(data.count);
                $('.' + 'insertimgcomment' + post_delete.value).html(data.comment);
                $('.comment_count_img' + post_delete.value).html(data.comment_count);
                $('.post-design-commnet-box').show();
            }
        });
    }


    function imgcomment_deletetwo(clicked_id)
    {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='imgcomment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }


    function imgcomment_deletedtwo(clicked_id)
    {
        var post_delete1 = document.getElementById("imgpost_deletetwo_" + clicked_id);
//        alert(post_delete1.value);
//        return false;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/mul_delete_commenttwo" ?>',
            data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete1.value,
            dataType: "json",
            success: function (data) {
                //$('.' + 'insertcommenttwo' + post_delete1.value).html(data);
                $('.' + 'insertimgcommenttwo' + post_delete1.value).html(data.comment);
                $('#' + 'insertimgcount' + post_delete1.value).html(data.count);
                $('.post-design-commnet-box').show();
            }
        });
    }
</script>

<script type="text/javascript">
    function h(e) {
        $(e).css({'height': '29px', 'overflow-y': 'hidden'}).height(e.scrollHeight);
    }
    $('.textarea').each(function ()
    {
        h(this);
    }).on('input', function () {
        h(this);
    });
</script>
<script type="text/javascript">
    function editpost(abc)
    {
        document.getElementById('editpostdata' + abc).style.display = 'none';
        document.getElementById('editpostbox' + abc).style.display = 'block';
        document.getElementById('editpostdetails' + abc).style.display = 'none';
        document.getElementById('editpostdetailbox' + abc).style.display = 'block';
        document.getElementById('editpostsubmit' + abc).style.display = 'block';
    }
</script>


<script type="text/javascript">
    function edit_postinsert(abc)
    {

        var editpostname = document.getElementById("editpostname" + abc);
        var $field = $('#editpostname' + abc);
        var editpostdetails = $('#editpostdesc' + abc).html();
        if (editpostname.value == '' && editpostdetails == '') {
            $('.biderror .mes').html("<div class='pop_content'>You must either fill title or description.");
            $('#bidmodal').modal('show');

            document.getElementById('editpostdata' + abc).style.display = 'block';
            document.getElementById('editpostbox' + abc).style.display = 'none';
            document.getElementById('editpostdetails' + abc).style.display = 'block';
            document.getElementById('editpostdetailbox' + abc).style.display = 'none';

            document.getElementById('editpostsubmit' + abc).style.display = 'none';

        } else {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "business_profile/edit_post_insert" ?>',
                data: 'business_profile_post_id=' + abc + '&product_name=' + editpostname.value + '&product_description=' + editpostdetails,
                dataType: "json",
                success: function (data) {

                    document.getElementById('editpostdata' + abc).style.display = 'block';
                    document.getElementById('editpostbox' + abc).style.display = 'none';
                    document.getElementById('editpostdetails' + abc).style.display = 'block';
                    document.getElementById('editpostdetailbox' + abc).style.display = 'none';

                    document.getElementById('editpostsubmit' + abc).style.display = 'none';

                    $('#' + 'editpostdata' + abc).html(data.title);
                    $('#' + 'editpostdetails' + abc).html(data.description);
                }
            });
        }
    }
</script>

<!-- cover image end -->
<script type="text/javascript">
    function likeuserlist(post_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/imglikeuserlist" ?>',
            data: 'post_id=' + post_id,
            dataType: "html",
            success: function (data) {
                var html_data = data;
                $('#likeusermodal .mes').html(html_data);
                $('#likeusermodal').modal('show');
            }
        });


    }
    function likeuserlistimg(post_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "business_profile/imglikeuserlist" ?>',
            data: 'post_id=' + post_id,
            dataType: "html",
            success: function (data) {
                var html_data = data;
                $('#likeusermodal .mes').html(html_data);
                $('#likeusermodal').modal('show');
            }
        });


    }
</script>


<!-- post delete login user script start -->
<script type="text/javascript">
    function user_postdelete(clicked_id)
    {

        $('.biderror .mes').html("<div class='pop_content'> Do you want to delete this post?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='remove_post(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
</script>
<!-- post delete login user end -->

<!-- post delete particular login user script start -->
<script type="text/javascript">
    function user_postdeleteparticular(clicked_id)
    {

        $('.biderror .mes').html("<div class='pop_content'> Do You want to delete this post from your profile?.<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='del_particular_userpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
</script>
<!-- post delete particular login user end -->


<!-- This  script use for close dropdown in every post -->
<script type="text/javascript">
    $('body').on("click", "*", function (e) {
        var classNames = $(e.target).attr("class").toString().split(' ').pop();
        if (classNames != 'fa-ellipsis-v') {
            $('div[id^=myDropdown]').hide().removeClass('show');
        }
    });
</script>
<script type="text/javascript">
    $(document).keydown(function (e) {
        if (!e)
            e = window.event;
        if (e.keyCode == 27 || e.charCode == 27) {
            closeModal();
        }
    });


</script>
<!-- This  script use for close dropdown in every post -->



<script type="text/javascript">

    var _onPaste_StripFormatting_IEPaste = false;

    function OnPaste_StripFormatting(elem, e) {

        if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
            e.preventDefault();
            var text = e.originalEvent.clipboardData.getData('text/plain');
            window.document.execCommand('insertText', false, text);
        } else if (e.clipboardData && e.clipboardData.getData) {
            e.preventDefault();
            var text = e.clipboardData.getData('text/plain');
            window.document.execCommand('insertText', false, text);
        } else if (window.clipboardData && window.clipboardData.getData) {
            // Stop stack overflow
            if (!_onPaste_StripFormatting_IEPaste) {
                _onPaste_StripFormatting_IEPaste = true;
                e.preventDefault();
                window.document.execCommand('ms-pasteTextOnly', false);
            }
            _onPaste_StripFormatting_IEPaste = false;
        }

    }

</script>


<!-- all popup close close using esc start -->
 <script type="text/javascript">

    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});  


$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#likeusermodal').modal('hide');
    }
});  
 </script>
 <!-- all popup close close using esc end

