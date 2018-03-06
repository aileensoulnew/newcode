<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
   <head>
      <title><?php echo $blog_detail[0]['title'];?> - Aileensoul.com</title>
      <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
      <?php
        if($_SERVER['HTTP_HOST'] != "localhost"){
        ?>
        
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-91486853-1', 'auto');
            ga('send', 'pageview');

        </script>
        <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
        <?php
        }
        ?>
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
      <!-- Open Graph data -->
      <meta property="og:title" content="<?php echo $blog_detail[0]['title']; ?>" />
      <meta  property="og:type" content="Blog" />
      <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path')  . $blog_detail[0]['image'])?>" />
      <meta  property="og:description" content="<?php echo $blog_detail[0]['meta_description']; ?>" />
      <meta  property="og:url" content="<?php echo base_url('blog/'.$blog_detail[0]['blog_slug']) ?>" />
      <meta property="fb:app_id" content="825714887566997" />
     
      <!-- for twitter -->
      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:site" content="<?php base_url('blog/'.$blog_detail[0]['blog_slug']) ?>">
      <meta name="twitter:title" content="<?php $blog_detail[0]['title']; ?>">
      <meta name="twitter:description" content="<?php $blog_detail[0]['meta_description']; ?>">
      <meta name="twitter:creator" content="By Aileensoul">
      <meta name="twitter:image" content="http://placekitten.com/250/250">
      <meta name="twitter:domain" content="<?php base_url('blog/'.$blog_detail[0]['blog_slug']) ?>">
      
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css'); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css'); ?>">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
      <!-- This Css is used for call popup -->
      <link rel="stylesheet" href="<?php echo base_url() ?>css/jquery.fancybox.css" />
   </head>
   <body class="blog-detail blog">
      <div class="main-inner">
         <header>
            <div class="container">
               <div class="row">
                  <div class="col-md-4 col-sm-3 ">
                  <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                  </div>
                  <div class="col-md-8 col-sm-9  pt-10">
                     <div class="btn-right pull-right pt10">
                         <?php if(!$this->session->userdata('aileenuser')) {?>
                        <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                        <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                        <?php }?>
                     </div>
                  </div>
               </div>
            </div>
         </header>
      </div>
      <div class="blog_header">
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-sm-5 col-xs-3 mob-zindex">
                 
                  <div class="logo pl20">
                     <a href="<?php echo base_url('blog/'); ?>">
                        <h3  style="color: #1b8ab9;">Blog</h3>
                     </a>
                  </div>
               </div>
               <div class="col-md-8 col-sm-7 col-xs-9 header-left-menu">
                  <div class="main-menu-right">
                     <ul class="">
                        <li><a href="<?php echo base_url('blog/');?>">Recent Post </a></li>
                        <li> <a href="<?php echo base_url('blog/popular');?>">Most Popular</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <section>
         <section>
            <div class="blog-mid-section user-midd-section">
               <div class="container">
                  <div class="row">
                      <?php
                      if(count($blog_detail) > 0){
                      ?>
                     <div class="blog_post_outer col-md-9 col-sm-8 pr0">
                        <div class="date_blog_right2">
                           <div class="blog_post_main">
                              <div class="blog_inside_post_main">
                                 <div class="blog_main_post_first_part">
                                    <div class="blog_main_post_img">
                                       <img src="<?php echo base_url($this->config->item('blog_main_upload_path')  . $blog_detail[0]['image']) ?>" >
                                    </div>
                                 </div>
                                 <div class="blog_main_post_second_part">
                                    <div class="blog_class_main_name">
                                       <span>
                                          <h1><?php echo $blog_detail[0]['title'];?></h1>
                                       </span>
                                    </div>
                                    <div class="blog_class_main_by">
                                    </div>
                                    <div class="blog_class_main_desc">
                                       <span>
                                       <?php echo $blog_detail[0]['description'];?>
                                       </span>
                                    </div>
                                    <div class="blog_class_main_social">
                                       <div class="left_blog_icon fl">
                                          <ul class="social_icon_bloag fl">
                                             <li>
                                                <?php
                                                   $title=urlencode('"'.$blog_detail[0]['title'].'"');
                                                   $url=urlencode(base_url('blog/'.$blog_detail[0]['blog_slug']));
                                                   $summary=urlencode('"'.$blog_detail[0]['description'].'"');
                                                   $image=urlencode(base_url($this->config->item('blog_main_upload_path')  . $blog_detail[0]['image']));
                                                   ?>
                                              
                                                <a onclick="window.open('http://www.facebook.com/sharer.php?p[url]=<?php echo $url; ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)"> 
                                                <span  class="social_fb"></span>
                                                </a>
                                             </li>
                                             <li>
                                              
                                                <a href="https://plus.google.com/share?url=<?php echo $url; ?>" onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo $url; ?>','','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                                                <span  class="social_gp"></span>
                                                </a>
                                             </li>
                                             <li>
                                               
                                                <a href="https://www.linkedin.com/cws/share?url=<?php echo $url; ?>"  onclick="javascript:window.open('https://www.linkedin.com/cws/share?url=<?php echo $url; ?>','','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span  class="social_lk"></span></a>
                                             </li>
                                             <li>
                                               
                                                <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>"  onclick="javascript:window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>','','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span  class="social_tw"></span></a>
                                             </li>
                                          </ul>
                                       </div>
                                       <div class="fr blog_view_link2">
                                          <?php 
                                             if(count($blog_all) != 0)
                                             {                
                                                 
                                                 foreach ($blog_all as $key => $blog) 
                                                 {
                                                   
                                                   if($blog['id'] == $blog_detail[0]['id'] && ($key+1) != 1)
                                                   {
                                                      
                                                  
                                               ?>
                                          <a href="<?php echo base_url('blog/'.$blog_all[$key-1]['blog_slug']);?>"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                          <?php
                                             }
                                             }
                                             
                                             }
                                             
                                             ?>
                                          <span>
                                          <?php 
                                             if(count($blog_all) != 0)
                                             {                
                                                 
                                                 foreach ($blog_all as $key => $blog) 
                                                 {
                                             
                                                   if($blog['id'] == $blog_detail[0]['id'])
                                                   {
                                                      echo $key+1; echo '/'; echo count($blog_all);
                                                   }
                                             }
                                                 
                                             }
                                             ?>
                                          </span>
                                          <?php 
                                             if(count($blog_all) != 0)
                                             {                
                                                 
                                                 foreach ($blog_all as $key => $blog) 
                                                 {
                                             
                                                   if($blog['id'] == $blog_detail[0]['id'] && ($key+1) != count($blog_all))
                                                   {
                                                      
                                                  
                                               ?>
                                          <a href="<?php echo base_url('blog/'.$blog_all[$key+1]['blog_slug']);?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                          <?php
                                             }
                                             }
                                             
                                             }
                                             
                                             ?>
                                       </div>
                                    </div>
                                    <?php
                                       //FOR GETTING USER COMMENT
                                        $condition_array = array('status' => 'approve','blog_id' => $blog_detail[0]['id']);
                                        $blog_comment  = $this->common->select_data_by_condition('blog_comment', $condition_array, $data='*', $short_by='id', $order_by='desc', $limit, $offset, $join_str = array());
                                       
                                        
                                          foreach ($blog_comment as $comment) 
                                          {
                                        ?>  
                                    <div class="all-comments">
                                       <ul>
                                          <li class="comment-list">
                                             <div class="c-user-img">
                                                <img src="<?php echo base_url(NOIMAGE); ?>" alt="">
                                             </div>
                                             <div class="c-user-comments">
                                                <h5><?php echo $comment['name']; ?></h5>
                                                <p><?php echo $comment['message']; ?></p>
                                                <p class="pt5"><span class="comment-time">
                                                   <?php 
                                                      $date = new DateTime($comment['comment_date']);
                                                       echo $date->format('d').PHP_EOL;
                                                       echo "-";
                                                      
                                                       $date = new DateTime($comment['comment_date']);
                                                       echo $date->format('M').PHP_EOL;
                                                       echo "-";
                                                      
                                                       $date = new DateTime($comment['comment_date']);
                                                       echo $date->format('Y').PHP_EOL;
                                                      ?>
                                                   </span>
                                                </p>
                                             </div>
                                          </li>
                                       </ul>
                                    </div>
                                    <?php
                                       }//for loop end
                                       ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="comment_box">
                           <h3>Give Comment</h3>
                           <form role="form" name="comment" id="comment" method="post" action="" autocomplete="off">
                              <fieldset class="full-width comment_foem">
                                 <label>Name </label>
                                 <input type="text" name="name" id="name" placeholder="Enter your name">
                              </fieldset>
                              <fieldset class="full-width comment_foem">
                                 <label>Email Address </label>
                                 <input type="text" name="email" id="email" placeholder="Enter your email address">
                              </fieldset>
                              <fieldset class="full-width comment_foem">
                                 <label>Message </label>
                                 <textarea name="message" id="message" placeholder="Enter Your message"></textarea>
                              </fieldset>
                              <input type="hidden" value="<?php echo $blog_detail[0]['id']; ?>" name="blog_id" id="blog_id">
                              <fieldset class="comment_foem">
                                 <button>Send a Comment</button>
                              </fieldset>
                           </form>
                        </div>
                     </div>
                      <?php
                      }else{ ?>
                      <div class="blog_post_outer col-md-9 col-sm-8 pr0">
                          <div class="art_no_post_avl">
                                    <div class="art-img-nn">
                                        <div class="art_no_post_img">
                                            <img src="<?php echo base_url('assets/img/bui-no.png') ?>">
                                        </div>
                                        <div class="art_no_post_text">
                                            Sorry, this content isn't available at the moment
                                        </div>
                                    </div>
                                </div>
                      </div>
                      <?php }
                      ?>
                     <div class="col-md-3 col-sm-4 hidden-xs">
                        <div class="blog_latest_post" >
                           <h3>Latest Post</h3>
                           <?php
                              foreach($blog_last as $blog)
                              {
                              ?>
                           <div class="latest_post_posts">
                              <ul>
                                 <li>
                                    <div class="post_inside_data">
                                       <div class="post_latest_left">
                                          <div class="lateaqt_post_img">
                                             <a href="<?php echo base_url('blog/'.$blog['blog_slug'])?>"> <img src="<?php echo base_url($this->config->item('blog_main_upload_path')  . $blog['image']) ?>" ></a>
                                          </div>
                                       </div>
                                       <div class="post_latest_right">
                                          <div class="desc_post">
                                             <a href="<?php echo base_url('blog/'.$blog['blog_slug'])?>"><span class="rifght_fname"> <?php echo $blog['title'];?> </span></a>
                                          </div>
                                       </div>
                                    </div>
                                 </li>
                                 <li></li>
                              </ul>
                           </div>
                           <!--latest_post_posts end -->
                           <?php
                              }//for loop end
                              ?>
                        </div>
                        <!--blog_latest_post end -->
						<div class="pt15 fw">
							<script type="text/javascript">
							  ( function() {
								if (window.CHITIKA === undefined) { window.CHITIKA = { 'units' : [] }; };
								var unit = {"calltype":"async[2]","publisher":"Aileensoul","width":300,"height":250,"sid":"Chitika Default"};
								var placement_id = window.CHITIKA.units.length;
								window.CHITIKA.units.push(unit);
								document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
							}());
							</script>
							<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
							
							<div class="fw pt10">
									<a href="https://www.chitika.com/publishers/apply?refid=aileensoul"><img src="https://images.chitika.net/ref_banners/300x250_hidden_ad.png" /></a>
								</div>
						</div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </section>
       <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
      <?php
            echo $login_footer
            ?>
   </body>
</html>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.11.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.js'); ?>"></script>
<!-- This Js is used for call popup -->
<script src="<?php echo base_url('assets/js/jquery.fancybox.js'); ?>"></script>

<script>
var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/blog/blog_detail.js'); ?>"></script>