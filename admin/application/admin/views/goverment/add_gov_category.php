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
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $section_title; ?></h3>
                    </div><!-- /.box-header -->

                     <div>
                        <?php
                                        if ($this->session->flashdata('error')) {
                                            echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                        }
                                        if ($this->session->flashdata('success')) {
                                            echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                        }?>
                    </div>
                    <!-- form start -->
                    <?php
                    $form_attr = array('id' => 'add_gov_frm', 'enctype' => 'multipart/form-data');
                    echo form_open_multipart('goverment/add_gov_category_insert', $form_attr);
                    ?>
                    <div class="box-body">                   
                    <div class="form-group col-sm-10">
                            <label for="govtitle" name="govtitle" id="govtitle">Name*</label>
                            <input type="text" class="form-control" name="gov_name" id="gov_name" value="" placeholder="Enter Category Name">
                    </div>
                    </div>

                    <div class="box-body">                   
                    <div class="form-group col-sm-10">
                            <label for="cat_img" name="cat_img" id="cat_img">Image*</label>
                            <input type="file" class="form-control" name="cat_image" id="cat_image" value="">
                    </div>
                    </div>

                    <div class="box-body">                   
                    <div class="form-group col-sm-10">
                            <label for="govstatus" name="govstatus" id="govstatus">Status*</label>
                            <input type="radio"  name="status" id="status" value="1" checked="checked"> Publish
                            <input type="radio"  name="status" id="status" value="2"> Draft
                    </div>
                    </div>


                    <div class="box-footer">
                        <?php
                        $save_attr = array('id' => 'btn_save', 'name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');
                        echo form_submit($save_attr);
                        ?>    
                        <button type="button" onclick="window.history.back();" class="btn btn-default">Back</button>                     
                    </div>
                    </form>
                </div><!-- /.box -->


            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php echo $footer; ?>
<script src="<?php echo base_url('admin/assets/js/jquery.min.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('admin/assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<script type="text/javascript">

    var base_url = '<?php echo base_url(); ?>'; 
    //validation for edit email formate form
    $(document).ready(function () {
        $("#add_gov_frm").validate({
            rules: {
                gov_name: {
                    required: true,
                    remote: { 
                    url: base_url + "goverment/check_category",
                    type: "post",
                    data: { 
                       gov_name: function() {
                       return $( "#gov_name" ).val();
                  }
               }
            }
                },
                cat_image: {
                      required: true,
                },
               
            },
            messages:
                    {
                        gov_name: {
                            required: "Please enter goverment category name",
                            remote: "Goverment category already exists",
                        },

                        cat_image: {
                            required: "Please select category image",
                        },
                       
                    },
        }); });

</script>

<script>
    $(".alert").delay(3200).fadeOut(300);
</script>