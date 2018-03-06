<?php
echo $header;
echo $leftmenu;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
              <i class="fa fa-rss" aria-hidden="true"></i>
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
            <li class="active"><?php echo $module_name; ?></li>
        </ol>
    </section>
    <section class="content-header">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="callout callout-success">
                <p><?php echo $this->session->flashdata('success'); ?></p>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>  
            <div class="callout callout-danger" >
                <p><?php echo $this->session->flashdata('error'); ?></p>
            </div>
        <?php } ?>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $section_title; ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $form_attr = array('id' => 'add_page_frm', 'enctype' => 'multipart/form-data');
                    echo form_open_multipart('freelancer_hire/edit_insert/'.$users[0]['reg_id'], $form_attr);
                    ?>
                    <div class="box-body">
                    
                        <!-- First Name START -->
                        <div class="form-group col-sm-10">
                            <label for="firstname" name="firstname" id="blogtitle">First Name*</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $users[0]['username']; ?>">
                        </div>
                        <!-- First Name END -->
                        
                         <!-- Last Name START -->
                        <div class="form-group col-sm-10">
                            <label for="lastname" name="lastname" id="blogtitle">Last Name*</label>
                            <input type="text" class="form-control" name="last_title" id="last_title" value="<?php echo $users[0]['fullname']; ?>">
                        </div>
                        <!-- Last Name END -->
                        
                        <!-- Email START -->
                        <div class="form-group col-sm-10">
                            <label for="emailedit" name="emailedit" id="blogtitle">Email*</label>
                            <input type="text" class="form-control" name="email_edit" id="email_edit" value="<?php echo $users[0]['email']; ?>">
                        </div>
                        <!-- Email END -->

                         <!-- Phone number START -->
                        <div class="form-group col-sm-10">
                            <label for="phone_no" name="phone_no" id="phone_no">Phone number*</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" value="<?php echo $users[0]['phone']; ?>">
                        </div>
                        <!--phone number END -->    
                        
                         <!-- Skype Id  START -->
                        <div class="form-group col-sm-10">
                            <label for="skypeid" name="skypeid" id="blogtitle">Skype Id*</label>
                            <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $users[0]['skyupid']; ?>">
                        </div>
                        <!--Skype Id END -->
                         <!-- Country START -->
                        <div class="form-group col-sm-10">
                            <label for="country_edit" name="country_edit" id="country_edit">Country*</label>
                            <select  name="country" id="country"  class="form-control">
                                <option value="">Select Country</option>
                                <?php
                                            if(count($countries) > 0){
                                                foreach($countries as $cnt){
                                            if($users[0]['country'])
                                            {
                                              ?>
                                                 <option value="<?php echo $cnt['country_id']; ?>" <?php if($cnt['country_id']==$users[0]['country']) echo 'selected';?>><?php echo $cnt['country_name'];?></option>
                                                <?php
                                                }
                                                else
                                                {
                                            ?>
                                                 <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name'];?></option>
                                                  <?php
                                            }
                                            }}
                                            ?>
                                
                            </select>
                        </div>
                        <!-- Country END -->
                        <!-- state START -->
                        <div class="form-group col-sm-10">
                            <label for="state_edit" name="state_edit" id="state_edit">State*</label>
                            <select name="state" id="state"  class="form-control">
                               <?php
                                          if($users[0]['state'])
                                            {
                                            foreach($states as $cnt){
                                              ?>
                                                 <option value="<?php echo $cnt['state_id']; ?>" <?php if($cnt['state_id']==$users[0]['state']) echo 'selected';?>><?php echo $cnt['state_name'];?></option>
                                               
                                                <?php
                                                } }
                                                else
                                                {
                                            ?>
                                                 <option value="">Select country first</option>
                                                  <?php
                                            
                                            }
                                            ?>
                            </select>
                        </div>
                        <!-- State END -->
                        <!-- City START -->
                        <div class="form-group col-sm-10">
                            <label for="city_edit" name="city_edit" id="blogtitle">City*</label>
                            <select name="city" id="city" class="form-control">
                           <?php
                                        if($users[0]['city'])
                                            {
                                          foreach($cities as $cnt){
                                              ?>
                                               <option value="<?php echo $cnt['city_id']; ?>" <?php if($cnt['city_id']==$users[0]['city']) echo 'selected';?>><?php echo $cnt['city_name'];?></option>
                                                <?php
                                                } }
                                                 else if($users[0]['state'])
                                             {
                                            ?>
                                            <option value="">Select City</option>
                                            <?php
                                            foreach ($cities as $cnt) {
                                                ?>
                                                <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                                <?php
                                            }
                                        }
                                                else
                                                {
                                            ?>
                                        <option value="">Select state first</option>
                                         <?php
                                            }
                                            ?>
                                        </select>
                        </div>
                        <!-- City END -->
                         <!-- pincode` START -->
                        <div class="form-group col-sm-10">
                            <label for="pincode" name="pincode" id="blogtitle">Pincode*</label>
                            <input type="text" class="form-control" name="pincode_no" id="pincode_no" value="<?php echo $users[0]['pincode']; ?>">
                        </div>
                        <!-- pincode END -->
                        
                         <!--  Professional info START -->
                        <div class="form-group col-sm-10">
                            <label for="professionalinfo" name="professionalinfo" id="professionalinfo">Professiona Info *</label>
                            <textarea id="professional_info" name="professional_info"  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $users[0]['professional_info']; ?></textarea>
                            <?php //echo form_textarea(array('name' => 'short_description', 'id' => 'short_description', 'class' => "textarea", 'style' => 'width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'value' => '')); ?><br>
                        </div>
                        <!-- Professional Info END -->

                        <!--  Professional info START -->
                        <div class="form-group col-sm-10">
                            <label for="profile_pic" name="profile_pic" id="profile_pic">Profile pic *</label>
                            <input type="file" class="form-control" name="profilepic" id="image" value="" style="border: none; width: 280px; display: inline-block">
                             <?php if ($users[0]['freelancer_hire_user_image']) { ?>
                                <img src="<?php echo SITEURL . $this->config->item('free_hire_profile_thumb_upload_path') . $users[0]['freelancer_hire_user_image']; ?>" alt=""  style="height: 60px; width: 60px;">
                            <?php } else { ?>
                                <img alt="" style="height: 60px; width: 60px;" class="img-circle" src="<?php echo SITEURL . (NOIMAGE); ?>" alt="" />
                            <?php } ?>
                                <input type="hidden" name="image_name" value="<?php echo $users[0]['freelancer_hire_user_image']; ?>">
                        </div>
                        <!-- Professional Info END -->

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <?php
                        $save_attr = array('id' => 'btn_save', 'name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');
                        echo form_submit($save_attr);
                        ?>    
                        <button type="button" onclick="window.history.back();" class="btn btn-default">Back</button>
                        <!--<button type="submit" class="btn btn-info pull-right">Sign in</button>-->
                    </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php echo $footer; ?>



<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>
<!--script for country,state,city for ajax data start-->
<script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){ 
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() . "freelancer_hire/ajax_data"; ?>',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() . "freelancer_hire/ajax_data"; ?>',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
});
</script>
<!--script for country,state,city for ajax data end-->
