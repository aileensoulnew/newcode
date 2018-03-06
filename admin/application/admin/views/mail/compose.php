
<?php
echo $header;
echo $leftmenu;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
              <i class="fa fa-envelope" ></i>
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
            <li class="active">Compose Mail</li>
        </ol>
        <!-- <div class="fr">
                         <button name="Add" class="btn bg-orange btn-flat margin" ><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i> Add User</button>
        </div> -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
         

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Subjects</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="<?php echo base_url('email/compose/job'); ?>"><i class="fa fa-arrow-circle-right"></i> <?php echo $subject[0]['varsubject'];?></a></li>
                <li><a href="<?php echo base_url('email/compose/recruiter'); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo $subject[1]['varsubject'];?></a></li>
                <li><a href="<?php echo base_url('email/compose/freelancer'); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo $subject[2]['varsubject'];?></a></li>
                <li><a href="<?php echo base_url('email/compose/business'); ?>"><i class="fa fa-arrow-circle-right"></i> <?php echo $subject[3]['varsubject'];?> </a>
                </li>
                <li><a href="<?php echo base_url('email/compose/artistic'); ?>"><i class="fa fa-arrow-circle-right"></i><?php echo $subject[4]['varsubject'];?></a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
       
        </div>
        <!-- /.col -->

    <?php
            $form_attr = array('id' => 'compose_mail', 'enctype' => 'multipart/form-data','onsubmit'=> 'return validateForm(this);');
            echo form_open_multipart('email/compose_insert/'.$slug, $form_attr);
    ?>
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <div class="form-group">
                <input type="text" name="toemail" class="form-control" placeholder="To:" >
              </div>
              <div class="form-group">
                <input type="text" name="subjectmail" class="form-control" placeholder="Subject:" value="<?php echo $email[0]['varsubject'];?>">
              </div>
              <div class="form-group">
                    <textarea id="compose" name="compose" class="form-control" style="height: 300px"><?php echo $email[0]['varmailformat'];?></textarea>
              </div>
              <!-- <div class="form-group">
                <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> Attachment
                  <input type="file" name="attachment">
                </div>
                <p class="help-block">Max. 32MB</p>
              </div> -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
               <!--  <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                
               <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
             <!--  <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button> -->


            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->

        </div>
        <!-- /.col -->
        </form>
       
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
  <!--content-wrapper-->

<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

<script type="text/javascript">
    //validation for edit email formate form
    $(document).ready(function () {

        $("#compose_mail").validate({
            rules: {
                toemail: {
                    required: true,
                },
                subjectmail: {
                    required: true,
                },
                compose: {
                    required: true,
                },
                  
            },
            messages:
                    {
                        toemail: {
                            required: "Please enter Receiver Email",
                        },
                        subjectmail: {
                            required: "Please enter Subject of Email",
                        },
                        compose: {
                            required: "Please Enter Compose Email",
                        },
                        
                    },
        });
 });


 $(function () {
    //Add text editor
    $("#compose").wysihtml5();
  });
 
</script>

<script type="text/javascript">  
    function validateForm(formObj) {  

        if (formObj.toemail.value!='') 
        {  
            formObj.submit.disabled = true;  
            return true;   
        }  
    }  
</script>
