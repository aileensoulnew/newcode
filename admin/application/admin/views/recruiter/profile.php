<?php
  echo $header;
  echo $leftmenu;
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>
            <img src="<?php echo SITEURL .'/img/i2.jpg' ?>" alt=""  style="height: 50px; width: 50px;">
            <?php echo $module_name; ?>
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li class="active">Recruiter profile</li>
        </ol>
    </section>

 

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image --> 
          <div class="box box-primary mt0">
            <div class="box-body box-profile">

             <?php  if($user[0]['recruiter_user_image']) 
                                {
                        ?>
                                <img class="profile-user-img img-responsive img-circle" src="<?php echo SITEURL . $this->config->item('rec_profile_thumb_upload_path') . $user[0]['recruiter_user_image']; ?>" alt=""  style="height: 100px; width: 100px;">
                        <?php }else{
                        ?>
                                <img class="profile-user-img img-responsive img-circle" alt="" style="height: 100px; width: 100px;" class="img-circle" src="<?php echo SITEURL.(NOIMAGE); ?>" alt="" />
                        <?php } ?>
            
              <h3 class="profile-username text-center"><?php echo ucfirst($user[0]['rec_firstname']); echo ' ';echo ucfirst($user[0]['rec_lastname']);  ?></h3>

              <?php if($user[0]['designation'])
                    {
              ?>
              <p class="text-muted text-center"><?php echo ucwords($user[0]['designation']); ?></p>
              <?php
                    }
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
             <strong><i class="fa fa-envelope-o margin-r-5"></i>Email</strong>

              <p><?php echo $user[0]['rec_email']; ?></p>

          <?php 
            if($user[0]['rec_phone'])
            {
           ?>
           <hr>
              <strong><i class="fa fa-phone margin-r-5"></i>Phone Number</strong>
              <p>
                 <?php echo $user[0]['rec_phone']; ?>                        
              </p>      
              <?php
                }
              ?>

              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i>Company Location</strong>

               <p class="text-muted">
               <?php 

                            $cityname = $this->db->get_where('cities', array('city_id' => $user[0]['re_comp_city']))->row()->city_name;

                            echo $cityname; if( $cityname){echo ",";}

                            $statename = $this->db->get_where('states', array('state_id' => $user[0]['re_comp_state']))->row()->state_name;

                            echo $statename;if( $statename){echo ",";}

                            $countryname = $this->db->get_where('countries', array('country_id' => $user[0]['re_comp_country']))->row()->country_name; 
                                            
                            echo $countryname;
                ?>
                </p>
              
             <hr>
              <strong><i class="fa fa-industry margin-r-5"></i>Company Address</strong>

              <p><?php echo $user[0]['re_comp_address']; ?></p>
                
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a href="#company_information" data-toggle="tab"><i class="fa fa-fw fa-info-circle margin-r-5"></i>Company Information</a>
              </li>

            </ul>

            <div class="tab-content">

              <div class="active tab-pane" id="company_information">
                <!-- Post -->
                <div class="post">

                  <form class="form-horizontal">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Company Name</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['re_comp_name'];?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Email Address</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['re_comp_email']; ?> 
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Phone Number</label>
                    <div class="col-sm-2 control-label">

                  <?php if( $user[0]['re_comp_phone'])
                        {
                    ?>
                    <?php echo $user[0]['re_comp_phone']; ?>
                     <?php 
                        }
                        else
                        {
                          echo PROFILENA;
                        }
                  ?>
                    </div>
                  </div>
                 

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Website</label>
                    <div class="col-sm-2 control-label">
                     <?php if( $user[0]['re_comp_site'])
                            {
                                echo $user[0]['re_comp_site']; 
                            }
                            else
                            {
                                echo PROFILENA;
                            }
                      ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Interview Process</label>
                    <div class="col-sm-2 control-label">
                      <?php
                            if( $user[0]['re_comp_interview'])
                            {
                                echo $user[0]['re_comp_interview']; 
                            }
                            else
                            {
                                echo PROFILENA;
                            }
                             
                        ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Best Project</label>
                    <div class="col-sm-2 control-label">
                   <?php
                            if( $user[0]['re_comp_project'])
                            {
                                echo $user[0]['re_comp_project']; 
                            }
                            else
                            {
                                echo PROFILENA;
                            }
                                 
                    ?>   
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Other Activities</label>
                    <div class="col-sm-2 control-label">
                      <?php 
                            if( $user[0]['re_comp_activities'])
                            {
                               echo $user[0]['re_comp_activities']; 
                            }
                            else
                            {
                                echo PROFILENA;
                            }

                      ?>
                    </div>
                  </div>

                </form>

                </div>
                <!-- /.post -->
            
              </div>
              <!-- tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

</body>
</html>

<!-- This script and css are used for tabbing at graduation and work experience Start -->
<script type="text/javascript">
   function openCity(evt, cityName,e) {
   // Declare all variables
   var i, tabcontent, tablinks;
   
   // Get all elements with class="tabcontent" and hide them
   tabcontent = document.getElementsByClassName("tabcontent");
   for (i = 0; i < tabcontent.length; i++) {
     tabcontent[i].style.display = "none";
   }
   
   // Get all elements with class="tablinks" and remove the class "active"
   tablinks = document.getElementsByClassName("tablinks");
   for (i = 0; i < tablinks.length ; i++) {
     tablinks[i].className = tablinks[i].className.replace(" active", "");
   }
   
   // Show the current tab, and add an "active" class to the button that opened the tab
   document.getElementById(cityName).style.display = "block";
   evt.currentTarget.className += " active";
  evt.preventDefault();
   }
</script>
<style>
   #work6 {
   display: block;
   }
   #gra1 {
   display: block;
   }
</style>
<!-- This script and css are used for tabbing at graduation and work experience ENd -->
