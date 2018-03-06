<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<?php echo $head; ?>

 <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>
<link href="<?php echo base_url('assets/css/fileinput.css?ver='.time());?>" media="all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/js/themes/explorer/theme.css?ver='.time()); ?>" media="all" rel="stylesheet" type="text/css"/>

<?php }else{?>

<link href="<?php echo base_url('assets/css_min/fileinput.css?ver='.time());?>" media="all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/js/themes/explorer/theme.css?ver='.time()); ?>" media="all" rel="stylesheet" type="text/css"/>

<?php }?>


<?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">  
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
<?php }else{?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">  
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />

<?php }?>
 <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
</style>
</head>
<body class="cus-art">
<?php echo $header; ?>
 <?php echo $art_header2_border; ?>
<div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
   <div class="container art_container padding-360">
      <div class="">
      <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
			<div class="left_fixed"> 

                     <?php echo $left_artistic; ?> 
                       <?php echo $left_footer; ?>
            </div>
			
         </div>
       <div class=" custom-right-art mian_middle_post_box animated fadeInUp">
         
    <div class="common-form"> 
               <div class="job-saved-box">
                  <h3 style="color: #5c5c5c !important;font-weight: 500;">
                     Search result of 
                    <?php  if($keyword != "" && $keyword1 == ""){echo '"' .  $keyword . '"';}
                                  elseif ($keyword == "" && $keyword1 != "") {
                                    echo '"' .  $keyword1 . '"';
                                  }
                                  else
                                  {
                                     echo '"' .  $keyword . '"'; echo  " in "; echo '"' .  $keyword1 . '"';
                                  }
              ?>                               
                  </h3>
                <div class="contact-frnd-post">
                  <div class="job-contact-frnd">
				  	

                 <!-- AJAX DATA... -->
                 <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif";?>"/></div>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      
		<div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
					
						<div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="All">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>" title="Job Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo "i1.jpg"; ?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>" title="Recruiter Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="<?php echo "i2.jpg"; ?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>" title="Freelance Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo "i3.jpg"; ?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" title="Business Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo "i4.jpg"; ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>" title="Artistic Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="<?php echo "i5.jpg"; ?>">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>	
							
						</div>
						
						
	  </div>
   </div>
</div>

      <!-- bid model start -->

      <div class="modal fade message-box" id="postedit" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="modal-close" id="postedit" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
      <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
                        <div class="modal-dialog modal-lm">
                            <div class="modal-content">
                                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                                <div class="modal-body">
                                   
                                    <span class="mes"></span>
                                </div>
                            </div>
                        </div>
      </div>

<div class="modal fade message-box" id="likeusermodal" role="dialog">
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

          <div class="modal fade message-box biderror" id="bidmodaleditpost" role="dialog"  >
         <div class="modal-dialog modal-lm" >
            <div class="modal-content">
               <button type="button" class="modal-close editpost" data-dismiss="modal">&times;</button>       
               <div class="modal-body">
                  <span class="mes"></span>
               </div>
            </div>
         </div>
      </div>



<?php echo $footer; ?>



<?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script src="<?php echo base_url('assets/js/plugins/sortable.js?ver='.time()); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/themes/explorer/theme.js?ver='.time()); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>

<?php }else{?>

<script src="<?php echo base_url('assets/js_min/plugins/sortable.js?ver='.time()); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js_min/themes/explorer/theme.js?ver='.time()); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>


<?php }?>
 <script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';      
var data = <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
var keyword = '<?php echo $keyword; ?>';
var keyword1 = '<?php echo $keyword1; ?>';
</script>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>

<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/recommen_candidate.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>

<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/recommen_candidate.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<?php }?>
</body>
</html>