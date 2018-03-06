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
                    <?php $job_name = $this->db->get_where('job_title', array('title_id' => $post_data[0]['post_name'], 'status' => 1))->row()->name; ?>
                        <!-- First Name START -->
                        <div class="form-group col-sm-12">
                            <label for="firstname" name="firstname" id="blogtitle">Job Title</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php if($job_name){ echo $job_name;}else{echo $post_data[0]['post_name'];} ?>" readonly="readonly">
                        </div>
                        <!-- First Name END -->
                       
                        <?php $skill_post=$post_data[0]['post_skill'];
                        $skill_post1= explode(',', $skill_post);
                        foreach ($skill_post1 as $key){
                            $skill_name[] = $this->db->get_where('skill', array('skill_id' => $key, 'status' => 1))->row()->skill;
                        } 
                        $final_skill= implode(',', $skill_name);
                        ?>
                      
                         <!-- Last Name START -->
                        <div class="form-group col-sm-6">
                            <label for="lastname" name="lastname" id="blogtitle">Skills</label>
                            <input type="text" class="form-control" name="last_title" id="last_title" value="<?php echo $final_skill; ?>"readonly="readonly" >
                        </div>
                        <!-- Last Name END -->
                        
                        <!-- Email START -->
                        <div class="form-group col-sm-3">
                            <label for="emailedit" name="emailedit" id="blogtitle">No of Position</label>
                            <input type="text" class="form-control" name="email_edit" id="email_edit" value="<?php echo $post_data[0]['post_position']; ?>" readonly="readonly">
                        </div>
                        <!-- Email END -->
                         <!--Last date info start-->
                        <div class="form-group col-sm-3">
                            <label for="phone_no" name="phone_no" id="phone_no">Last Date of Apply</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" value="<?php echo date("d-m-Y", strtotime($post_data[0]['post_last_date']));  ?>" readonly="readonly">
                        </div>
                        <!--Last date info end-->
                         <!-- Phone number START -->
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="phone_no" id="phone_no">Minimum experience</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" value="<?php echo $post_data[0]['min_year']." Year"; ?>"readonly="readonly">
                        </div>
                        <!--phone number END -->    
                        
                         <!-- Skype Id  START -->
                        <div class="form-group col-sm-6">
                            <label for="skypeid" name="skypeid" id="blogtitle">Maximum experience</label>
                            <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $post_data[0]['max_year']." Year"; ?>" readonly="readonly" >
                        </div>
                        <!--Skype Id END -->
                        <?php $industyname = $this->db->get_where('job_industry', array('industry_id' => $post_data[0]['industry_type'], 'status' => 1))->row()->industry_name;  ?>
                         <!-- Country START -->
                        <div class="form-group col-sm-6">
                            <label for="country_edit" name="country_edit" id="country_edit">Industry</label>
                            <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $industyname; ?>" readonly="readonly">
                        </div>
                        <!-- Country END -->
                        
                        <!-- state START -->
                        <div class="form-group col-sm-6">
                            <label for="state_edit" name="state_edit" id="state_edit">Employment Type</label>
                           <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $post_data[0]['emp_type']; ?>" readonly="readonly">
                        </div>
                        <!-- State END -->
                        <?php $degree_post=$post_data[0]['degree_name'];
                        $degree_post1= explode(',', $degree_post);
                        foreach ($degree_post1 as $key){
                            $degree_name[] = $this->db->get_where('degree', array('degree_id' => $key, 'status' => 1))->row()->degree_name;
                        } 
                        $final_degress= implode(',', $degree_name);
                        ?>
                        <?php //$degree = $this->db->get_where('degree', array('degree_id' => $post_data[0]['degree_name'], 'status' => 1))->row()->degree_name;?>
                        <!-- City START -->
                        <div class="form-group col-sm-6">
                            <label for="city_edit" name="city_edit" id="blogtitle">Education</label>
                            <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $final_degress; ?>" readonly="readonly">
                        </div>
                        <!-- City END -->
                         <!-- pincode` START -->
                        <div class="form-group col-sm-6">
                            <label for="pincode" name="pincode" id="blogtitle">Other Education</label>
                            <input type="text" class="form-control" name="pincode_no" id="pincode_no" value="<?php echo $post_data[0]['other_education']; ?>"readonly="readonly">
                        </div>
                        <!-- pincode END -->
                        
                        
                        <?php $country = $this->db->get_where('countries', array('country_id' => $post_data[0]['country'], 'status' => 1))->row()->country_name;?>
                                    <!--minimun salary info start-->
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="salary" id="salary">Minimum Salary</label>
                            <input type="text" class="form-control" name="salary_type" id="salary_type" value="<?php echo $post_data[0]['min_sal']; ?>" readonly="readonly" >
                        </div>
                        
                        <!--minimun salary info end-->
                        <!--maximum salary info start-->
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="salary" id="salary">Maximum Salary</label>
                            <input type="text" class="form-control" name="salary_type" id="salary_type" value="<?php echo $post_data[0]['max_sal']; ?>" readonly="readonly" >
                        </div>
                        <!--maximum salary info end-->
                        <!--salary typeinfo-->
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="salary" id="salary">Salary type</label>
                            <input type="text" class="form-control" name="salary_type" id="salary_type" value="<?php echo $post_data[0]['salary_type']; ?>" readonly="readonly">
                        </div>
                        <!--salary type info end-->
                        <!--currency start-->
                        <?php $currency = $this->db->get_where('currency', array('currency_id' => $post_data[0]['post_currency'], 'status' => 1))->row()->currency_name;?>
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="" id="phone_no">Currency</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" value="<?php echo $currency; ?>" readonly="readonly">
                        </div>
                        <!--currency end-->
                        <!--Created date info start-->
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="phone_no" id="phone_no">Created Date</label>
                            <input type="text" class="form-control" name="created" id="created" value="<?php echo $post_data[0]['created_date']; ?>" readonly="readonly">
                        </div>
                        <!--Created date info end-->
                        <!--Modified date info start-->
                        <div class="form-group col-sm-6">
                            <label for="phone_no" name="phone_no" id="phone_no">Modified Date</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" value="<?php echo $post_data[0]['modify_date']; ?>" readonly="readonly" >
                        </div>
                        <!--Modified date info end-->
                        
                        
                         <!--country info start-->
                        <div class="form-group col-sm-4">
                            <label for="phone_no" name="country" id="phone_no">Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="<?php echo $country; ?>" readonly="readonly">
                        </div>
                        <!--country info end-->
                        <?php $state = $this->db->get_where('states', array('state_id' => $post_data[0]['state'], 'status' => 1))->row()->state_name;?>
                        <!--state info start-->
                        <div class="form-group col-sm-4">
                            <label for="phone_no" name="phone_no" id="phone_no">State</label>
                            <input type="text" class="form-control" name="state" id="state" value="<?php echo $state; ?>" readonly="readonly">
                        </div>
                        <!--state info end-->
                        <?php $city = $this->db->get_where('cities', array('city_id' => $post_data[0]['city'], 'status' => 1))->row()->city_name;?>
                        <!--city info start-->
                        <div class="form-group col-sm-4">
                            <label for="phone_no" name="phone_no" id="phone_no">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>" readonly="readonly">
                        </div>
                        <!--city info end-->
           
                         <!--  Professional info START -->
                        <div class="form-group col-sm-10">
                            <label for="professionalinfo" name="professionalinfo" id="professionalinfo">Job description</label>
                            <textarea id="professional_info" name="professional_info"  style="width: 100%; height: auto; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; overflow:auto; " disabled><?php echo $post_data[0]['post_description']; ?></textarea>
                            <?php //echo form_textarea(array('name' => 'short_description', 'id' => 'short_description', 'class' => "textarea", 'style' => 'width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'value' => '')); ?><br>
                        </div>
                        <!-- Professional Info END -->

                        <!--  Professional info START -->
                        <div class="form-group col-sm-10">
                            <label for="profile_pic" name="profile_pic" id="profile_pic">Interview process</label>
                            <textarea id="professional_info" name="professional_info"  style="width: 100%; height: auto; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; overflow:auto;" disabled><?php echo $post_data[0]['interview_process']; ?></textarea>
                             
                        </div>
                        <!-- Professional Info END -->
                        <?php if($post_data[0]['fresher'] == '1'){ ?>
                        <div class="form-group col-sm-10">
                            <b>Note: Freshers can also apply</b>
                        </div>
                        <?php } ?>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <?php
//                        $save_attr = array('id' => 'btn_save', 'name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');
//                        echo form_submit($save_attr);
                        ?>    
                        <!--<button type="button" onclick="window.history.back();" class="btn btn-default">Back</button>-->
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
