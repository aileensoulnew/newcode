<?php  echo $head; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/business/business.css?ver='.time()); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/common/mobile.css') ;?>" />
    <!-- END HEAD -->
    <!-- start header -->
<?php echo $header; ?>

    <!-- END HEADER -->
    <body class="page-container-bg-solid page-boxed">

      <section>
        
        </div>
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <div class="left-side-bar">
                           <ul>
                                   <li><a href="<?php echo base_url('business-profile/details'); ?>">Buisness Profile</a>
                                    </li>
                                    <li><a href="<?php echo base_url('business_profile/business_profile_post'); ?>">Home</a>
                                    </li>
                                   
                                    <li><a href="<?php echo base_url('business_profile/business_profile_manage_post'); ?>"> Manage Post</a>
                                    </li>
                                    <li><a href="<?php echo base_url('business_profile/business_profile_save_post'); ?>"">Saved Post</a>
                                    </li>
                                </ul>
                        </div>
                    </div>

                    <!-- middle section start -->
 
                    <div class="col-md-6 col-sm-8">

                    <div>
                        <?php
                                        if ($this->session->flashdata('error')) {
                                            echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                        }
                                        if ($this->session->flashdata('success')) {
                                            echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                        }?>
                    </div>

                        <div class="common-form">
                            <h3>Business Profile Editpost</h3>
                     
                        
                             <?php echo form_open_multipart(base_url('business_profile/business_profile_editpost_insert/'.$business_profile_data[0]['business_profile_post_id']), array('id' => 'business_profile_editpost','name' => 'business_profile_editpost','class' => 'clearfix')); ?>
                           <div><span style="color:red">Fields marked with asterisk (*) are mandatory</span></div>
                           
                            <fieldset class="full-width">
                                <label>Product Name:<span style="color:red">*</span></label>
                                <input type="text" name="productname" id="productname" value="<?php echo $business_profile_data[0]['product_name'];?>">  
                                <?php echo form_error('productname'); ?>
                            </fieldset>

                            <fieldset class="full-width">
                                <label style="display: block;">Product Image:<span style="color:red">*</span></label>


                                <input type="hidden" name="hiddenimg" id="hiddenimg" value="<?php echo $business_profile_data[0]['product_image']; ?>">
                                <input type="file" name="image" id="image">  


                                   <!--video and audio display start -->

                                                        
                                                            <?php
                                                      $allowed =  array('gif','png','jpg');
//                                                        $allowed = VALID_IMAGE;
                                                       $allowespdf = array('pdf');
                                                       
                                                       $filename = $business_profile_data[0]['product_image'];
                                                       

                                                       $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                      

                                                       if(in_array($ext,$allowed) ) 
                                                       { 
                                                         
                                                          ?>
                                                         
                                                       <img src="<?php echo base_url(BUSINESSPROFILEIMAGE.$business_profile_data[0]['product_image'])?>" style="width:100px;height:100px;"> 
                                                          <?php
                                                       }
                                                       elseif(in_array($ext,$allowespdf))
                                                       { ?>

                                                      

                                                        <a href="<?php echo base_url('business_profile/creat_pdf/'.$business_profile_data[0]['business_profile_post_id']) ?>">PDF</a>
                                                       <?php }
                                                       else
                                                       {
                                                        
                                                       ?>

                                                        <video width="320" height="240" controls>
                                                          <source src="<?php echo base_url(BUSINESSPROFILEIMAGE.$business_profile_data[0]['product_image']); ?>" type="video/mp4">
                                                          <source src="movie.ogg" type="video/ogg">
                                                          Your browser does not support the video tag.
                                                       </video>
                                                       <?php
                                                        }
                                                       ?>
                                                         
<!--video and audio display end -->

                                <?php echo form_error('image'); ?>
                            </fieldset>

                           <fieldset class="full-width">
                                <label>Description:<span style="color:red">*</span></label>
                                  <textarea name="description" id="description" placeholder="Enter Description"><?php echo $business_profile_data[0]['product_description']; ?></textarea>
                                <?php echo form_error('description'); ?>
                            </fieldset>

                           

                            <fieldset class="full-width hs-submit">

                                 <input type="reset" name="reset" value="Clear">
                                <input type="submit" name="producteditpost" id="producteditpost">
                               
                            </fieldset>
                            </form>             
                        </div>
                    </div>
                    

                    
                </div>
            </div>
        </div>
    </section>
   <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <!-- footer start -->
    <footer>
        
        <?php echo $footer;  ?>
    </footer>
  
</body>
</html>
<script src="<?php echo base_url('js/fb_login.js?ver='.time()); ?>"></script>
<script type="text/javascript" defer="defer" src="<?php echo base_url('js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    <!-- footer end -->