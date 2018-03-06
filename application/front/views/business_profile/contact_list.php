<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
             <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <?php echo $dash_header; ?>
        <?php echo $dash_header_menu; ?>
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-12  hidden-md hidden-sm hidden-lg pb20 ">
                        <div class="common-form ">
                            <div class="main_cqlist-1"> 
                                <div class="contact-list ">
                                    <h3 class="list-title">Contact Request Notifications</h3>
                                    <div class="noti_cq">
                                        <div class="cq_post content mCustomScrollbar">
                                            <ul>
                                                <?php
                                                if ($friendlist_con) {
                                                    foreach ($friendlist_con as $friend) {
                                                        ?>
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        if ($friend['contact_from_id'] == $userid) {
                                                            ?>
                                                            <li> 
                                                                <div class="cq_main_lp">
                                                                    <div class="cq_latest_left">
                                                                        <div class="cq_post_img">
                                                                            <?php if ($friend['business_user_image'] != '') { ?>
                                                                                <a  href="<?php echo base_url('business-profile/dashboard/' . $friend['business_slug']); ?>">
                                                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $friend['business_user_image']; ?>">
                                                                                </a>
                                                                            <?php } else { ?>
                                                                                <a  href="<?php echo base_url('business-profile/dashboard/' . $friend['business_slug']); ?>">
                                                                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>" />
                                                                                </a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>  
                                                                    <div class="cq_latest_right">
                                                                        <div class="cq_desc_post">
                                                                            <sapn class="rifght_fname">  
                                                                                <a  href="<?php echo base_url('business-profile/dashboard/' . $friend['business_slug']); ?>">
                                                                                    <span class="main_name">
                                                                                        <?php echo ucfirst(strtolower($friend['company_name'])); ?> 
                                                                                    </span>
                                                                                </a>
                                                                                <span style="color: #8c8c8c;">confirmed your contact request .</span>
                                                                            </sapn>
                                                                        </div>
                                                                        <div class="cq_desc_post">
                                                                            <sapn class="cq_rifght_desc">  <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($friend['modify_date']))); ?> </sapn>
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <li><div class="art-img-nn" id= "art-blank">
                                                            <div class="art_no_post_img">
                                                                <img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>" width="100">
                                                            </div>
                                                            <div class="art_no_post_text" style="font-size: 20px;">
                                                                No Notifiaction Available.
                                                            </div>
                                                        </div></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-7 pt_mn2">
                        <div class="common-form main_cqlist">
                            <div class="contact-list">
                                <h3 class="list-title list-title2"> Contact Request</h3>
                            </div>  
                            <div class="all-list">
                                <ul  id="contactlist">
                                    <!-- AJAX DATA ... -->
                                </ul>
                                <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" /></div>
                            </div>        
                        </div>
                        <!-- END PAGE TITLE -->
                    </div>
                    <div class="col-md-4 col-sm-5 hidden-xs ">
                        <div class="common-form ">
                            <div class="main_cqlist-1"> 
                                <div class="contact-list ">
                                    <h3 class="list-title">Contact Request Notifications</h3>
                                    <div class="noti_cq">
                                        <div class="cq_post content mCustomScrollbar">
                                            <ul>
                                                <?php
                                                if ($friendlist_con) {
                                                    foreach ($friendlist_con as $friend) {
                                                        ?>
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        if ($friend['contact_from_id'] == $userid) {
                                                            ?>
                                                            <li> 
                                                                <div class="cq_main_lp">
                                                                    <div class="cq_latest_left">
                                                                        <div class="cq_post_img">

                                                                            <?php if ($friend['business_user_image'] != '') { ?>
                                                                                <a  href="<?php echo base_url('business-profile/dashboard/' . $friend['business_slug']); ?>">
                                                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $friend['business_user_image']; ?>">
                                                                                </a>
                                                                            <?php } else { ?>
                                                                                <a  href="<?php echo base_url('business-profile/dashboard/' . $friend['business_slug']); ?>">
                                                                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>" />
                                                                                </a>
                                                                            <?php } ?>


                                                                        </div>
                                                                    </div>  
                                                                    <div class="cq_latest_right">
                                                                        <div class="cq_desc_post">
                                                                            <span class="rifght_fname">  
                                                                                <a  href="<?php echo base_url('business-profile/dashboard/' . $friend['business_slug']); ?>">
                                                                                    <span class="main_name">
                                                                                        <?php echo ucfirst(strtolower($friend['company_name'])); ?> 
                                                                                    </span>
                                                                                </a>
                                                                                <span style="color: #8c8c8c;">confirmed your contact request .</span>
                                                                            </span>
                                                                        </div>

                                                                        <div class="cq_desc_post">
                                                                            <span class="cq_rifght_desc">  <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($friend['created_date']))); ?> </span>
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <li><div class="art-img-nn" id= "art-blank">
                                                            <div class="art_no_post_img">

                                                                <img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>" width="100">

                                                            </div>
                                                            <div class="art_no_post_text" style="font-size: 20px;">
                                                                No Contact Request Notifiaction Available
                                                            </div>
                                                        </div></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="container">
                        <div class="page-content">
                            <div class="container">
                                <div class="page-content-inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php echo $footer; ?>
        <?php echo $login_footer ?>
        <script type="text/javascript">
            function contactapprove1(toid, status) {
                $.ajax({
                    url: "<?php echo base_url(); ?>business_profile/contact_list_approve",
                    type: "POST",
                    data: 'toid=' + toid + '&status=' + status,
                    success: function (data) {
                        $('#contactlist').html(data);
                    }
                });
            }

            $(document).ready(function () {
                business_contact_list();

                $(window).scroll(function () {
                    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {

                        var page = $(".page_number:last").val();
                        var total_record = $(".total_record").val();
                        var perpage_record = $(".perpage_record").val();
                        if (parseInt(perpage_record) <= parseInt(total_record)) {
                            var available_page = total_record / perpage_record;
                            available_page = parseInt(available_page, 10);
                            var mod_page = total_record % perpage_record;
                            if (mod_page > 0) {
                                available_page = available_page + 1;
                            }
                            if (parseInt(page) <= parseInt(available_page)) {
                                var pagenum = parseInt($(".page_number:last").val()) + 1;
                                business_contact_list(pagenum);
                            }
                        }
                    }
                });
            });
            var isProcessing = false;
            function business_contact_list(pagenum) {
                if (isProcessing) {
                    return;
                }
                isProcessing = true;
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>business_profile/ajax_contact_list?page=" + pagenum,
                    data: {total_record: $("#total_record").val()},
                    dataType: "html",
                    beforeSend: function () {
                        if (pagenum == 'undefined') {
                        } else {
                            $('#loader').show();
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                    },
                    success: function (data) {
                        $('.loader').remove();
                        $('#contactlist').append(data);

                        isProcessing = false;
                    }
                });
            }

        </script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
              <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>