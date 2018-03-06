<?php
  echo $header;
  echo $leftmenu;
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>
            <img src="<?php echo SITEURL .'/img/i1.jpg' ?>" alt=""  style="height: 50px; width: 50px;">
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
            <li class="active">Job profile</li>
        </ol>
    </section>

 

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image --> 
          <div class="box box-primary mt0">
            <div class="box-body box-profile">

             <?php  if($user[0]['job_user_image']) 
                                {
                        ?>
                                <img class="profile-user-img img-responsive img-circle" src="<?php echo SITEURL . $this->config->item('job_profile_thumb_upload_path') . $user[0]['job_user_image']; ?>" alt=""  style="height: 100px; width: 100px;">
                        <?php }else{
                        ?>
                                <img class="profile-user-img img-responsive img-circle" alt="" style="height: 100px; width: 100px;" class="img-circle" src="<?php echo SITEURL.(NOIMAGE); ?>" alt="" />
                        <?php } ?>
            
              <h3 class="profile-username text-center"><?php echo ucfirst($user[0]['fname']); echo ' ';echo ucfirst($user[0]['lname']);  ?></h3>

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
           
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

               <p class="text-muted">
               <?php 

                            $cityname = $this->db->get_where('cities', array('city_id' => $user[0]['city_id']))->row()->city_name;

                            echo $cityname; if( $cityname){echo ",";}

                            $statename = $this->db->get_where('states', array('state_id' => $user[0]['state_id']))->row()->state_name;

                            echo $statename;if( $statename){echo ",";}

                            $countryname = $this->db->get_where('countries', array('country_id' => $user[0]['country_id']))->row()->country_name; 
                                            
                            echo $countryname;
                ?>
                </p>
              

          <?php 
            if($user[0]['keyskill'])
            {
           ?>
           <hr>
              <strong><i class="fa fa-pencil margin-r-5"></i>Skills</strong>

              <p>
                 <?php
                            $aud = $user[0]['keyskill'];
                                                            
                            $aud_res = explode(',', $aud);
                                                            
                            foreach ($aud_res as $skill) 
                            {
                                                            
                                $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                              ?>
                              <span class="label label-primary"><?php echo  $cache_time; ?></span>
                  <?php
                              }
                  ?>    
                          
              </p>

              
              <?php
                }
              ?>

            <?php 
              if($other_skill)
              {
            ?>
            <hr>
              <strong><i class="fa fa-pencil margin-r-5"></i>Other Skills</strong>

              <p>
                 <?php
                            foreach ($other_skill as $skill) 
                            {
                                                            
                            
                  ?>
                    <span class="label bg-red"><?php echo  $skill['skill']; ?></span>
                  <?php
                              }
                  ?>    
                          
              </p>

             
              <?php
                }
              ?>

            <?php 
            if($user[0]['curricular'])
            {
           ?>
             <hr>
              <strong><i class="fa fa-pencil-square-o margin-r-5"></i>Extra Curricular Activities</strong>

              <p><?php echo $user[0]['curricular']; ?></p>
                
            <?php
                }
            ?>

             <hr>
              <strong><i class="fa fa-thumbs-o-up margin-r-5"></i>Interest</strong>

              <p><?php echo $user[0]['interest']; ?></p>
                

            <?php 
            if($user[0]['reference'])
            {
           ?>
             <hr>
              <strong><i class="fa fa-newspaper-o margin-r-5"></i>Reference</strong>

              <p><?php echo $user[0]['reference']; ?></p>
                
            <?php
                }
            ?>

            <?php 
            if($user[0]['carrier'])
            {
           ?>
              <hr>
              <strong><i class="fa fa-file-text-o margin-r-5"></i>Carrier Objectives</strong>

              <p><?php echo $user[0]['carrier']; ?></p>

            <?php
                }
            ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a href="#basic_information" data-toggle="tab"><i class="fa fa-fw fa-info-circle margin-r-5"></i>Basic Information</a>
              </li>

              <li><a href="#address" data-toggle="tab"><i class="fa fa-fw fa-home margin-r-5"></i>Address</a>
              </li>

              <li><a href="#education" data-toggle="tab"><i class="fa fa-fw fa-university margin-r-5"></i>Education Qualification</a>
              </li>

<?php
    if ($user[0]['project_name'] != "" || $user[0]['project_duration'] != "" || $user[0]['project_description'] != "" || $user[0]['training_as'] != "" || $user[0]['training_duration'] != "" || $user[0]['training_organization'] != "") 
    {
?>
              <li><a href="#project" data-toggle="tab"><i class="fa fa-fw fa-tasks margin-r-5"></i>Project And Training / Internship</a>
              </li>
<?php
    }
?>
              <li><a href="#work_exp" data-toggle="tab"><i class="fa fa-fw fa-industry margin-r-5"></i>Work Experience</a>
              </li>

            </ul>

            <div class="tab-content">

              <div class="active tab-pane" id="basic_information">
                <!-- Post -->
                <div class="post">

                  <form class="form-horizontal">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-2 control-label">
                     <?php echo ucfirst($user[0]['fname']); echo ' ';echo ucfirst($user[0]['lname']);  ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['email']; ?> 
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Phone Number</label>
                    <div class="col-sm-2 control-label">

                  <?php if( $user[0]['phnno'])
                        {
                    ?>
                    <?php echo $user[0]['phnno']; ?>
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
                     <label for="inputName" class="col-sm-2 control-label">Marital Status</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['marital_status']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Nationality</label>
                    <div class="col-sm-2 control-label">
                      <?php
                              $cache_time = $this->db->get_where('nation', array('nation_id' => $user[0]['nationality']))->row()->nation_name;
                              echo $cache_time;
                        ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Language</label>
                    <div class="col-sm-2 control-label">
                   <?php
                                             $aud = $user[0]['language'];
                                             
                                             $aud_res = explode(',', $aud);
                                             foreach ($aud_res as $lan) {
                                             
                                                 $cache_time = $this->db->get_where('language', array('language_id' => $lan))->row()->language_name;
                                                 $language1[] = $cache_time;
                                             }
                                             $listFinal = implode(', ', $language1);
                                             echo $listFinal;
                                             ?>   
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Date Of Birth</label>
                    <div class="col-sm-2 control-label">
                      <?php echo date('d/m/Y',strtotime($user[0]['dob'])); ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['gender']; ?>
                    </div>
                  </div>
                </form>

                </div>
                <!-- /.post -->

              </div>
              <!-- active tab-pane -->
            
            <div class="tab-pane" id="address">
                <!-- Post -->
                <div class="post">
                
                  <form class="form-horizontal">

                        <div class="text-center">
                                <h3 class="head_title">Present Address</h3>
                        </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-2 control-label">
                     <?php
                              $cache_time = $this->db->get_where('countries', array('country_id' => $user[0]['country_id']))->row()->country_name;
                              echo $cache_time;
                      ?>  
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">State</label>
                    <div class="col-sm-2 control-label">
                     <?php
                                $cache_time = $this->db->get_where('states', array('state_id' => $user[0]['state_id']))->row()->state_name;
                                echo $cache_time;
                      ?> 
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-2 control-label">
                     <?php if($user[0]['city_id'])
                          {
                             $cache_time = $this->db->get_where('cities', array('city_id' => $user[0]['city_id']))->row()->city_name;
                              echo $cache_time;
                          }
                          else
                          {
                            echo PROFILENA;
                          }
                      ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Pincode</label>
                    <div class="col-sm-2 control-label">
                    <?php 
                          if($user[0]['pincode'])
                          {
                            echo $user[0]['pincode']; 
                          }
                          else
                          {
                            echo PROFILENA;
                          }
                      ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['address']; ?>
                    </div>
                  </div>

                    <div class="text-center">
                                <h3 class="head_title">Permenant Address</h3>
                    </div>

                     <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-2 control-label">
                    <?php
                          $cache_time = $this->db->get_where('countries', array('country_id' => $user[0]['country_permenant']))->row()->country_name;
                          echo $cache_time;
                    ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">State</label>
                    <div class="col-sm-2 control-label">
                     <?php
                            $cache_time = $this->db->get_where('states', array('state_id' => $user[0]['state_permenant']))->row()->state_name;
                            echo $cache_time;
                      ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-2 control-label">
                     <?php
                          if($user[0]['city_permenant'])
                          {
                            $cache_time = $this->db->get_where('cities', array('city_id' => $user[0]['city_permenant']))->row()->city_name;
                            echo $cache_time;
                          }
                           else
                          {
                            echo PROFILENA;
                          }
                      ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Pincode</label>
                    <div class="col-sm-2 control-label">
                     <?php 
                            if($user[0]['pincode_permenant'])
                            {
                                echo $user[0]['pincode_permenant']; 
                            }
                             else
                            {
                                echo PROFILENA;
                            }
                      ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-2 control-label">
                     <?php echo $user[0]['address_permenant']; ?>
                    </div>
                  </div>

                </form>

                </div>
                <!-- /.post -->

              </div>
              <!-- tab-pane -->

              <div class="tab-pane" id="education">
                <!-- Post -->
                <div class="post">
                
                  <form class="form-horizontal">

                  <!-- Primary Education Data Start -->
                  <?php if($job_edu[0]['board_primary'])
                        {
                  ?>
                   <div class="text-center">
                                <h3 class="head_title">Primary Education</h3>
                    </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Board</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['board_primary']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">School</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['school_primary']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Percentage</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $job_edu[0]['percentage_primary']; ?>%
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Year of Passing</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $job_edu[0]['pass_year_primary']; ?>
                    </div>
                  </div>

                   <?php
                          if ($job_edu[0]['edu_certificate_primary'] != "") 
                          {
                   ?>
                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Education Certificate</label>
                    <div class="col-sm-2 control-label">
                            <a class="example-image-link" href="<?php echo SITEURL.($this->config->item('job_edu_thumb_upload_path').$job_edu[0]['edu_certificate_primary'])?>" data-lightbox="example-1">certificate </a>
                    </div>
                  </div>
                  <?php
                          }
                        }
                  ?>
                  <!-- Primary Education Data End -->

                  <!-- Secondary Education Data Start -->
                  <?php if($job_edu[0]['board_secondary'])
                        {
                  ?>
                   <div class="text-center">
                                <h3 class="head_title">Secondary Education</h3>
                    </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Board</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['board_secondary']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">School</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['school_secondary']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Percentage</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $job_edu[0]['percentage_secondary']; ?>%
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Year of Passing</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $job_edu[0]['pass_year_secondary']; ?>
                    </div>
                  </div>

                   <?php
                          if ($job_edu[0]['edu_certificate_secondary'] != "") 
                          {
                   ?>
                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Education Certificate</label>
                    <div class="col-sm-2 control-label">
                            <a class="example-image-link" href="<?php echo SITEURL.($this->config->item('job_edu_thumb_upload_path').$job_edu[0]['edu_certificate_secondary'])?>" data-lightbox="example-1">certificate </a>
                    </div>
                  </div>
                  <?php
                          }
                        }
                  ?>
                  <!-- Secondary Education Data End -->

                  <!-- Higher Secondary Education Data Start -->
                  <?php if($job_edu[0]['board_higher_secondary'])
                        {
                  ?>
                   <div class="text-center">
                                <h3 class="head_title">Higher secondary Education</h3>
                    </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Board</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['board_higher_secondary']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Stream</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['stream_higher_secondary']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">School</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $job_edu[0]['school_higher_secondary']; ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Percentage</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $job_edu[0]['percentage_higher_secondary']; ?>%
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Year of Passing</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $job_edu[0]['pass_year_higher_secondary']; ?>
                    </div>
                  </div>

                   <?php
                          if ($job_edu[0]['edu_certificate_higher_secondary'] != "") 
                          {
                   ?>
                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Education Certificate</label>
                    <div class="col-sm-2 control-label">
                            <a class="example-image-link" href="<?php echo SITEURL.($this->config->item('job_edu_thumb_upload_path').$job_edu[0]['edu_certificate_higher_secondary'])?>" data-lightbox="example-1">certificate </a>
                    </div>
                  </div>
                  <?php
                          }
                        }
                  ?>
                  <!-- Higher Secondary Education Data End -->

                  <!-- Graduation Education Data Start -->
                  <?php if($job_graduation)
                        {
                  ?>
                   <div class="text-center">
                                <h3 class="head_title">Graduation</h3>
                    </div>

                    <?php                                
                            $i = 1;
                            foreach ($job_graduation as $graduation) 
                            {
                                        if ($graduation['degree']) 
                                          {  
                      ?>

<!-- this div is userd for change content on number -->
 <div id="gra<?php echo $i; ?>" class="tabcontent data_exp">

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Degree</label>
                    <div class="col-sm-2 control-label">
                          <?php
                                $cache_time = $this->db->get_where('degree', array('degree_id' => $graduation['degree']))->row()->degree_name;
                                echo $cache_time;
                          ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Stream</label>
                    <div class="col-sm-2 control-label">
                          <?php
                                $cache_time = $this->db->get_where('stream', array('stream_id' => $graduation['stream']))->row()->stream_name;
                                echo $cache_time;
                          ?>
                    </div>
                  </div>
                  
                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">University</label>
                    <div class="col-sm-2 control-label">
                           <?php
                                  $cache_time = $this->db->get_where('university', array('university_id' => $graduation['university']))->row()->university_name;
                                  echo $cache_time;
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">College</label>
                    <div class="col-sm-2 control-label">
                           <?php echo $graduation['college']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Grade</label>
                    <div class="col-sm-2 control-label">
                         <?php
                                if ($graduation['grade']) 
                                {
                                    $cache_time = $this->db->get_where('university', array('university_id' => $graduation['university']))->row()->university_name;
                                    echo $cache_time;
                                }
                                else
                                {
                                  echo PROFILENA;
                                }
                        ?>
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Percentage</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $graduation['percentage'];?>%
                    </div>
                  </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Year of Passing</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $graduation['pass_year']; ?>
                    </div>
                  </div>

                   <?php
                          if ($graduation['edu_certificate'] != "") 
                          {
                   ?>
                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Education Certificate</label>
                    <div class="col-sm-2 control-label">
                            <a class="example-image-link" href="<?php echo SITEURL.($this->config->item('job_edu_thumb_upload_path').$graduation['edu_certificate'])?>" data-lightbox="example-1">certificate</a>
                    </div>
                  </div>
                  <?php
                          }//if complete of edu_certificate
                  ?>
              </div><!-- div complte of class tabcontent data_exp -->
                  <?php
                        }//if compalte of $graduation['degree']

                         $i++;

                      }//for loop complete

                    ?>
                   <div class="tab pagi_exp" style="">

                        <?php if(count($job_graduation) >= 1 ){ ?>
                        <button class="tablinks  " onclick="openCity(event, 'gra1')">1</button>
                        <?php } ?>

                        <?php if(count($job_graduation) >= 2 ){ ?>
                        <button class="tablinks" onclick="openCity(event, 'gra2')">2</button>
                        <?php } ?>

                        <?php if(count($job_graduation) >= 3 ){ ?>
                        <button class="tablinks" onclick="openCity(event, 'gra3')">3</button>
                        <?php } ?>

                        <?php if(count($job_graduation) >= 4 ){ ?>
                        <button class="tablinks" onclick="openCity(event, 'gra4')">4</button>
                        <?php } ?>

                        <?php if(count($job_graduation) >= 5 ){ ?>
                        <button class="tablinks" onclick="openCity(event, 'gra5')">5</button>
                        <?php } ?>
                        </div>
                  <?php
                    }//if compalte of $graduation['job_graduation']
                  ?>
  

                  <!-- Graduation Education Data Start -->

                </form>

                </div>
                <!-- /.post -->

              </div>
              <!-- tab-pane -->

<?php
    if ($user[0]['project_name'] != "" || $user[0]['project_duration'] != "" || $user[0]['project_description'] != "" || $user[0]['training_as'] != "" || $user[0]['training_duration'] != "" || $user[0]['training_organization'] != "") 
    {
?>
                                             
              <div class="tab-pane" id="project">
                <!-- Post -->
                <div class="post">
                
                  <form class="form-horizontal">

                    <div class="text-center">
                                <h3 class="head_title">Project</h3>
                    </div>

                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Project Name (Title)</label>
                    <div class="col-sm-2 control-label">

                          <?php if($user[0]['project_name'])
                                {
                                    echo $user[0]['project_name']; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Duration</label>
                    <div class="col-sm-2 control-label">
                          <?php if($user[0]['project_duration'])
                                {
                                    echo $user[0]['project_duration']; echo '&nbspmonth'; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Project Description</label>
                    <div class="col-sm-2 control-label">
                           <?php if($user[0]['project_description'])
                                {
                                    echo $user[0]['project_description']; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

          
                   <div class="text-center">
                                <h3 class="head_title">Training / Internship</h3>
                    </div>


                   <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Intern / Trainee As</label>
                    <div class="col-sm-2 control-label">
                          <?php if($user[0]['training_as'])
                                {
                                    echo $user[0]['training_as']; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Duration</label>
                    <div class="col-sm-2 control-label">
                          <?php if($user[0]['training_duration'])
                                {
                                    echo $user[0]['training_duration']; echo '&nbspmonth'; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Name of Organization</label>
                    <div class="col-sm-2 control-label">
                          <?php if($user[0]['training_organization'])
                                {
                                    echo $user[0]['training_organization']; 
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
<?php
      }
?>

              <div class="tab-pane" id="work_exp">
                <!-- Post -->
                <div class="post">
                
                  <form class="form-horizontal">

                  <?php
                          if ($user[0]['experience'] == "Fresher") 
                          {
                  ?>
                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Work Experience</label>
                    <div class="col-sm-2 control-label">
                          Fresher
                    </div>
                  </div>
                  <?php
                            }
                            else
                            {
                  ?>
                  
                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Total Experience</label>
                    <div class="col-sm-2 control-label">

                    <?php 
                                $total_work_year=0;
                                $total_work_month=0;
                                foreach ($job_work as $work1) 
                                {
                                                            
                                    $total_work_year+=$work1['experience_year'];
                                    $total_work_month+=$work1['experience_month'];
                                }


                            if($total_work_month == '12 month' && $total_work_year =='0 year')
                            {
                                    echo "1 year";
                            }
                            else if($total_work_year !='0 year' && $total_work_month == '12 month')
                            {
                                      $month = explode(' ', $total_work_year);
                                      $year=$month[0];
                                      $years=$year + 1;
                                      echo $years." Years";
    
                            }
                            else if($work1['experience'] == "Fresher")
                            {
                                        echo "Fresher";
                            }
                            else
                            {
                                        echo $total_work_year; echo "&nbsp"; echo "Year";
                                        echo "&nbsp";
                                        echo $total_work_month; echo "&nbsp"; echo "Month";
                            }                                                
                                                            
                      ?> 
                    </div>
                  </div>

<?php   
          $i = 6;
          foreach ($job_work as $work) 
          {
?>

<!-- this div is userd for change content on number -->
   <div id="work<?php echo $i; ?>" class="tabcontent data_exp">

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Job Title</label>
                    <div class="col-sm-2 control-label">
                          <?php echo $work['jobtitle']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Name</label>
                    <div class="col-sm-2 control-label">
                         <?php echo $work['companyname']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Email Address</label>
                    <div class="col-sm-2 control-label">
                          <?php if($work['companyemail'])
                                {
                                    echo $work['companyemail']; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Company Phone Number</label>
                    <div class="col-sm-2 control-label">
                          <?php if($work['companyphn'])
                                {
                                    echo $work['companyphn']; 
                                }
                                else
                                {
                                    echo PROFILENA;
                                }
                            ?>
                    </div>
                  </div>

                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Experience</label>
                    <div class="col-sm-2 control-label">

<?php 
        if ($work['experience_year'] == "0 year" && $work['experience_month'] == "12 month") 
        {
                echo "1 Year";
        } 
       elseif($work['experience_year'] != "0 year" && $work['experience_month'] == "12 month") {
                                                               
                $month1 = explode(' ', $work['experience_year']);
                $year1=$month1[0];
                $years1=$year1 + 1;
                echo $years1." Years";
          }
          else
          {
                echo $work['experience_year'];
                echo "&nbsp";
                echo $work['experience_month'];
          }
?>
                    </div>
                  </div>

                <?php
                        if ($work['work_certificate'] != "") 
                        {
                ?>
                  <div class="form-group">
                     <label for="inputName" class="col-sm-2 control-label">Experience Certificate</label>
                    <div class="col-sm-2 control-label">
                          <a class="example-image-link" href="<?php echo SITEURL.($this->config->item('job_work_thumb_upload_path') . $work['work_certificate']) ?>" data-lightbox="example-1">certificate</a>
                    </div>
                  </div>
                  <?php
                          }
                  ?>
         </div><!-- div complte of class tabcontent data_exp -->
  <?php 
        $i++;
        }//for loop complete
    ?>                                  
            <div class="tab pagi_exp">
              <?php if(count($job_work) >= 1){ ?>   
              <button class="tablinks" onclick="openCity(event, 'work6')">1</button>

              <?php } if(count($job_work) >= 2){ ?>
              <button class="tablinks" onclick="openCity(event, 'work7')">2</button>
                                                
              <?php } if(count($job_work) >= 3){ ?>
              <button class="tablinks" onclick="openCity(event, 'work8')">3</button>

              <?php } if(count($job_work) >= 4){ ?>
              <button class="tablinks" onclick="openCity(event, 'work9')">4</button>

              <?php } if(count($job_work) >= 5){ ?>
              <button class="tablinks" onclick="openCity(event, 'work10')">5</button>
              <?php }?>
            </div>
                                            
                  <?php      
                            }//else complete
                  ?>

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
