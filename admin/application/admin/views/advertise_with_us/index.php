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
            <li class="active">Advertise With Us</li>
        </ol>
        <!-- <div class="fr">
                         <button name="Add" class="btn bg-orange btn-flat margin" ><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i> Add User</button>
        </div> -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row" >
            <div class="col-xs-12" >
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="callout callout-success">
                        <p><?php echo $this->session->flashdata('success'); ?></p>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error')) { ?>  
                    <div class="callout callout-danger">
                        <p><?php echo $this->session->flashdata('error'); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Advertise With Us</h3>      
                        <div class="box-tools">
                            <?php
                            if ($this->session->userdata('user_search_keyword')) {
                                ?>
                                <a href="<?php echo base_url('feedback/clear_search') ?>">Clear Search</a>
                                <?php
                            }
                            ?>
                        </div><!--box-tools-->
                    </div><!-- box-header -->

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <?php
                                    if ($this->uri->segment(2) == '') {

                                        $segment2 = '';
                                    }
                                    ?>
                                    <th><i class="fa fa-bullhorn"></i> 
                                        <a href="javascript:void(0);">ID.</a>
                                    </th>
                                    <th><i class="fa fa-user"></i> 
                                        <a href="javascript:void(0);">Full Name</a>
                                    </th>
                                    <th><i class="fa fa-envelope"></i> 
                                        <a href="javascript:void(0);">Email</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Message</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-calendar"></i> 
                                        <a href="javascript:void(0);">Created_date</a>
                                    </th>
                                </tr>

                                <?php
                                if ($total_rows != 0) {

                                    $i = $offset + 1;
                                    foreach ($advertise_with_us as $advertise) {
                                        ?>

                                        <tr>
                                            <td><?php echo $advertise['id'] ?></td>

                                            <td><?php echo $advertise['firstname'] . ' ' . $advertise['lastname']; ?></td>

                                            <td><?php echo $advertise['email']; ?></td>

                                            <td><?php echo $advertise['message']; ?></td>

                                            <td><?php echo $advertise['created_date']; ?></td>

                                        </tr>
                                        <?php
                                    }//for loop close
                                }//if close
                                else {
                                    ?>

                                    <tr>

                                        <td align="center" colspan="11"> Oops! No Data Found</td>

                                    </tr>  

                                    <?php
                                }
                                ?>

                            </tbody></table>

                    </div><!--box-body table-responsive no-padding -->

                </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="dta_left col-md-6" id="pagination">

                <?php
                if ($total_rows > 0) {

                    if ($this->pagination->create_links()) {
                        $rec1 = $offset + 1;
                        $rec2 = $offset + $limit;
                        if ($rec2 > $total_rows) {
                            $rec2 = $total_rows;
                        }
                        ?>

                        <div style="margin-left: 20px;">

                            <?php echo "Records $rec1 - $rec2 of $total_rows"; ?>

                        </div><?php
                    } else {
                        ?>

                        <div style="margin-left: 20px;">

                            <?php echo "Records 1 - $total_rows of $total_rows"; ?>

                        </div>

                        <?php
                    }
                }
                ?>
            </div><!-- dta_left col-md-6--> 
            <!-- /pagination Start-->
            <?php
            if ($this->pagination->create_links()) {

                $tot_client = ceil($total_rows / $limit);
                $cur_client = ceil($offset / $limit) + 1;
                ?>
                <div class="text-right data_right col-md-6">
                    <div id="example2_paginate" class="dataTables_paginate paging_simple_numbers">
                        <?php echo $this->pagination->create_links(); ?> 
                    </div>
                </div>
            <?php } ?>
            <!-- /pagination End-->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<!-- Bid-modal  -->
<div class="modal fade message-box biderror" id="bidmodal" role="dialog"  >
    <div class="modal-dialog modal-lm" >
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<!-- Model Popup Close -->


<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>
