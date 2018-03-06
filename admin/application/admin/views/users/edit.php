<?php
echo $header;
echo $leftmenu;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <img src="<?php echo SITEURL . '/img/i1.jpg' ?>" alt=""  style="height: 50px; width: 50px;">
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
            <li class="active">ALL User</li>
        </ol>
        <!-- <div class="fr">
                         <button name="Add" class="btn bg-orange btn-flat margin" ><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i> Add User</button>
        </div> -->
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
                    $form_attr = array('id' => 'edit_user','name' => 'edit_user' ,'enctype' => 'multipart/form-data','onsubmit' => 'return check_dob();');
                    echo form_open_multipart('user_manage/edit_insert/'.$users[0]['user_id'], $form_attr);
                    ?>
                    <div class="box-body col-md-12">

                        <!-- BLOG TITLE START -->
                        <div class="form-group col-md-5">
                            <label for="blogtitle" name="blogtitle" id="blogtitle">First Name*</label>
                            <input type="text" class="form-control" name="first_name" id="blog_title" value="<?php
                            if ($users[0]['first_name']) {
                                echo $users[0]['first_name'];
                            }
                            ?>">

                        </div>
                        <!-- BLOG TITLE END -->

                        <!--  TAG SELECTION START -->
                        <div class="form-group col-md-5" >
                            <label>Last Name*</label>

                            <input type="text" class="form-control" name="last_name" id="tag" value="<?php
                            if ($users[0]['last_name']) {
                                echo $users[0]['last_name'];
                            }
                            ?>">
                        </div>
                        <!-- TAG SELECTION END -->

                        <!-- BLOG DESCRIPTION START -->
                        <div class="form-group col-md-5">
                            <label for="blogdescription" name="blogdescription" id="blogdescription">User Email *</label>
                            <input type="text" class="form-control" name="user_email" id="tag" value=" <?php
                            if ($users[0]['user_email']) {
                                echo $users[0]['user_email'];
                            }
                            ?>">
                            <!--   <?php //echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => "textarea", 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;', 'value' => ''));         ?> --><br>
                        </div>
                        <!-- BLOG DESCRIPTION END -->

                        <!-- BLOG META DESCRIPTION START -->
                        <div class="form-group col-md-5" >
                            <label for="blogmetadescription" name="blogmetadescription" id="blogmetadescription">Date of Birth*</label>
                            <select class="form-control" id="select_day" name="select_day" style="display:inline-block;width: 100px; margin-right: 20px; margin-bottom: 19px;">
                                <option value="" disabled selected value>Day</option>
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php if ($day == $i) echo 'selected="selected"' ?>><?php echo $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select class="form-control" id="select_month" name="select_month" style="display:inline-block;width: 100px; margin-right: 20px">
                                <option value="" disabled selected value>Month</option>
                                <option value="1" <?php if ($month == '01') echo 'selected="selected"' ?>>Jan</option>
                                <option value="2" <?php if ($month == '02') echo 'selected="selected"' ?>>Feb</option>
                                <option value="3" <?php if ($month == '03') echo 'selected="selected"' ?>>Mar</option>
                                <option value="4" <?php if ($month == '04') echo 'selected="selected"' ?>>Apr</option>
                                <option value="5" <?php if ($month == '05') echo 'selected="selected"' ?>>May</option>
                                <option value="6" <?php if ($month == '06') echo 'selected="selected"' ?>>Jun</option>
                                <option value="7" <?php if ($month == '07') echo 'selected="selected"' ?>>Jul</option>
                                <option value="8" <?php if ($month == '08') echo 'selected="selected"' ?>>Aug</option>
                                <option value="9" <?php if ($month == '09') echo 'selected="selected"' ?>>Sep</option>
                                <option value="10" <?php if ($month == '10') echo 'selected="selected"' ?>>Oct</option>
                                <option value="11" <?php if ($month == '11') echo 'selected="selected"' ?>>Nov</option>
                                <option value="12" <?php if ($month == '12') echo 'selected="selected"' ?>>Dec</option>

                            </select>
                            <select class="form-control" id="select_year" name="select_year" style="display:inline-block;width: 100px;">
                                <option value="" disabled selected value>Year</option>
                                <?php
                                for ($i = date('Y'); $i >= 1900; $i--) {
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php
                                    if ($year == $i) {
                                        echo 'selected="selected"';
                                    }
                                    ?>><?php echo $i; ?></option>
                                            <?php
                                        }
                                        ?>
                            </select>

                        </div>
                         <div class="dateerror" style="color:#f00; display: block;"></div>
                        <!-- BLOG META DESCRIPTION END -->

                        <!-- BLOG IMAGE START -->
                        <div class="form-group col-md-5">
                            <label for="blogimage" name="blogimage" id="blogimage">Image *</label>
                            <input type="file" class="form-control" name="profilepic" id="image" value="" style="border: none; width: 70%; display: inline-block">
                            <?php if ($users[0]['user_image']) { ?>
                                <img src="<?php echo SITEURL . $this->config->item('user_thumb_upload_path') . $users[0]['user_image']; ?>" alt=""  style="height: 60px; width: 60px;">
                            <?php } else { ?>
                                <img alt="" style="height: 60px; width: 60px;" class="img-circle" src="<?php echo SITEURL . (NOIMAGE); ?>" alt="" />
                            <?php } ?>
                                <input type="hidden" name="image_name" value="<?php echo $users[0]['user_image']; ?>">
                        </div>
                        <!-- BLOG IMAGE END -->
                        <div class="form-group col-md-5">
                            <label for="gender">Gender *</label>
                            <select class="form-control"  name="gender" id="gender" style="width: 50%;">
                                <option value="" disabled selected value>Gender</option>
                                <option value="M" <?php if ($users[0]['user_gender'] == "M") echo 'selected="selected"'; ?>>Male</option>
                                <option value="F" <?php if ($user[0]['user_gender'] == "F") echo 'selected="selected"'; ?>>Female</option>
                            </select>

                        </div>
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

<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>
<script>
    $(document).ready(function () {
        $("#edit_user").validate({
          ignore: '*:not([name])',
          rules: {
              first_name:{
                  required: true,
              }
              last_name:{
                  require:true,
              }
              user_email:{
                  require:true,
              }
          }
          
          message:{
              first_name:{
              required:"First name is required",
          }
              last_name:{
                  required:"Last name is required",
              }
              user_email:{
                  required:"Email id is required",
              }
              
          }

        })

    });
</script>
<script>

//Enable search button when user write something on textbox Start
    $(document).ready(function () {
        $('#search_btn').attr('disabled', true);

        $('#search_keyword').keyup(function ()
        {
            if ($(this).val().length != 0)
            {
                $('#search_btn').attr('disabled', false);
            } else
            {
                $('#search_btn').attr('disabled', true);
            }
        })

        $('body').on('keydown', '#search_keyword', function (e) {
            console.log(this.value);
            if (e.which === 32 && e.target.selectionStart === 0) {
                return false;
            }
        });
    });
//Enable search button when user write something on textbox End

</script>
<script>
    function check_dob(){
        
         var selyear = $("#select_year").val();
            var selmonth = $("#select_month").val();
            var selday = $("#select_day").val();
        
         var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth()+1; //January is 0!
        var yyyy = todaydate.getFullYear();

        if(dd<10) {
            dd='0'+dd
        } 

        if(mm<10) {
            mm='0'+mm
        } 

           var todaydate = yyyy+'/'+mm+'/'+dd;
           var value =  selyear+'/'+selmonth+'/'+selday;


            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);
           //var one = new Date(value).getTime();
         // var second = new Date(todaydate).getTime();
    //alert(one); alert(second);

        if (d1 < d2){
        
           $(".dateerror").html("Date of birth always less than to today's date.");
            
            return false;
         }else{


            if ((0 == selyear % 4) && (0 != selyear % 100) || (0 == selyear % 400))
            {


                if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {

                    if (selday == 31) {

                        $(".dateerror").html("This month has only 30 days.");
                        return false;
                    }
                } else if (selmonth == 2) { //alert("hii");
                    if (selday == 31 || selday == 30) {
                        $(".dateerror").html("This month has only 29 days.");
                        return false;

                    }

                }

            } else {


                if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {

                    if (selday == 31) {

                        $(".dateerror").html("This month has only 30 days.");
                        return false;
                    }
                } else if (selmonth == 2) {
                    if (selday == 31 || selday == 30 || selday == 29) {
                        $(".dateerror").html("This month has only 28 days.");
                        return false;

                    }

                }

            }
        }
    }
</script>
