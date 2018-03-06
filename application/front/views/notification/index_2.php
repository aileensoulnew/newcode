<!-- start head -->
<?php echo $head; ?>
    <!-- END HEAD -->
    <!-- start header -->
<?php echo $header; ?>
    <!-- END HEADER -->

    <body class="page-container-bg-solid page-boxed">

        <?php echo $dash_header; ?>
        <!-- BEGIN HEADER MENU -->
       <?php echo $dash_header_menu; ?>

        <!-- END HEADER MENU -->
    </div>
    <!-- END HEADER -->


       <div class="user-midd-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                        </div>
                    <div class="col-md-10 col-sm-10">
                        <div class="common-form">

                            <div class="job-saved-box">
                         <h3>Notification</h3>
                             
    <!-- BEGIN CONTAINER -->
   <!--  <div class="page-container">
    -->     <!-- BEGIN CONTENT -->
   <!--      <div class="page-content-wrapper">
    -->         <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE HEAD-->
   <!--          <div class="page-head">
    --><!--              <div class="container">
        -->             <!-- BEGIN PAGE TITLE -->
       <!--              <div class="page-title">
                        <h1>Notification List</h1>
 -->
<!--                         <div id="notificationsBody" class="notifications">
<div class="notification-data">
 --> 

    <div class="follow-box">
                                           <ul>
                          
  <?php foreach($job_not as $job){
  if($job['not_from'] == 1){?> 
 <li class="fl">
                      <div class="Frnd_req-pic" >  
                       <img src="<?php echo base_url(USERIMAGE . $job['user_image']);?>" >
  
                                </div>
                        </li>

    <li>
                         <div class="fl  notification-li-text">
                     <h6><?php echo "HI.. !  <font color='blue'><b><i> Rectuiter</i></font></b><b>" . "  " .  $job['first_name'] . ' ' . $job['last_name'] . "</b> invited you for an interview"; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
    </li>


</ul>
    </div>
<?php }} ?>



<div class="follow-box">
                                           <ul>
     
 <?php foreach($artfollow as $art){ 
    if($art['not_from'] == 3){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $art['user_image']);?>" >
  </div>

</li>
  <li>
                         <div class="fl  notification-li-text">
      <h6><?php echo "HI.. !  <font color='orange'><b><i> Artistic</i></font></b><b>" . "  " .  $art['first_name'] . ' ' . $art['last_name'] . "</b> started to following you"; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
    
   
</li>

</ul>

</div>

<?php } }?>

<div class="follow-box">

<ul>

<?php foreach($artcommnet as $art){ 
    if($art['not_from'] == 3){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $art['user_image']);?>" >
  </div>
  </li>
   <li>
                         <div class="fl  notification-li-text">
 
    <h6><?php echo "HI.. !  <font color='orange'><b><i> Artistic</i></font></b><b>" . "  " .  $art['first_name'] . ' ' . $art['last_name'] . "</b> commneted on your post"; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
  

</li>

</ul>
</div>
<?php } }?>

<div class="follow-box">

<ul>

<?php foreach($artcontact as $art){ 
    if($art['not_from'] == 3){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $art['user_image']);?>" >
  </div>
  </li>

     <li>
                         <div class="fl  notification-li-text">
   <h6><?php echo "HI.. !  <font color='orange'><b><i> Artistic</i></font></b><b>" . "  " .  $art['first_name'] . ' ' . $art['last_name'] . "</b> want to conatct you.."; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
    
</li>
</ul>
</div>

<?php } }?>
<div class="follow-box">

<ul>


<?php foreach($buscommnet as $art){ 
    if($art['not_from'] == 6){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $art['user_image']);?>" >
  </div>
 </li>    <li>
                         <div class="fl  notification-li-text">
  <h6><?php echo "HI.. !  <font color='orange'><b><i> Business</i></font></b><b>" . "  " .  $art['first_name'] . ' ' . $art['last_name'] . "</b> commneted on your post"; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
    
   
</li>
</ul>
</div>
<?php } }?>
<div class="follow-box">

<ul>

<?php foreach($busifollow as $bus){ 
    if($bus['not_from'] == 6){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $bus['user_image']);?>" >
  </div>
 </li> 
    <li>
                         <div class="fl  notification-li-text">
    <h6><?php echo "HI.. !  <font color='yellow'><b><i> Businessman</i></font></b><b>" . "  " .  $bus['first_name'] . ' ' . $bus['last_name'] . "</b> started to following you"; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
    
    </li>
</ul>
</div>
<?php } }?>


<div class="follow-box">

<ul>

<?php foreach($buscontact as $bus){ 
    if($bus['not_from'] == 6){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $bus['user_image']);?>" >
  </div>
 </li>
     <li>
                         <div class="fl  notification-li-text">
   <h6><?php echo "HI.. !  <font color='yellow'><b><i> Businessman</i></font></b><b>" . "  " .  $bus['first_name'] . ' ' . $bus['last_name'] . "</b>  want to conatct you.."; ?></h6>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
   
</li>
</ul>
</div>
<?php } }?>
<div class="follow-box">

<ul>

<?php foreach($rec_not as $art){ 
    if($art['not_from'] == 2){

     $id =   $this->db->get_where('job_reg',array('user_id' => $art['user_id']))->row()->job_id; if($id){?>
 <li class="fl">
                      <div class="Frnd_req-pic" >  
   <img src="<?php echo base_url(USERIMAGE . $art['user_image']);?>" >
  </div>
 </li>
     <li>
                         <div class="fl  notification-li-text">
   <a href="<?php echo base_url('job/job_printpreview/' . $id); ?>"><h6><?php echo "HI.. !  <font color='pink'><b><i> Job seeker</i></font></b><b>" . "  " .  $art['first_name'] . ' ' . $art['last_name'] . "</b> Aplied on your post"; ?></h6></a>
    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i><?php echo date('d M ',strtotime($job['message_create_date'])); ?></div>
    </div>
    
 
</li>
</ul>
</div>
<?php }} }?>

</div>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE CONTENT BODY -->
            <!-- <div class="page-content">
                <div class="container">
             -->        <!-- BEGIN PAGE BREADCRUMBS -->
                    <!-- <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>Layouts</span>
                        </li>
                    </ul> -->
                    <!-- END PAGE BREADCRUMBS -->
                    <!-- BEGIN PAGE CONTENT INNER -->
            <!--         <div class="page-content">
                        <div class="container">
             -->                <!-- BEGIN PAGE CONTENT INNER -->
            <!--                 <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                       
                                    </div>
                                </div>
                            </div>
             -->                <!-- END PAGE CONTENT INNER -->
                        </div>
            <!--         </div>
                </div>
            </div>
             --><!-- END PAGE CONTENT BODY -->
            <!-- END CONTENT BODY -->
        <!-- </div>
         --><!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <!-- BEGIN INNER FOOTER -->
    <?php echo $footer; ?>
    