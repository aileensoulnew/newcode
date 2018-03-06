<?php
echo $header;
echo $leftmenu;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <img src="<?php echo SITEURL . '/img/i2.jpg' ?>" alt=""  style="height: 50px; width: 50px;">
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
            <li class="active">Freelancer Projects</li>
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
                        <h3 class="box-title">Freelancer Projects</h3>      

                        <div class="box-tools">
                            <?php echo form_open('recruiter/search_post', array('method' => 'post', 'id' => 'search_frm', 'class' => 'form-inline', 'autocomplete' => 'off')); ?>
                            <div class="input-group input-group-sm" >



                     <!--    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search"> -->

                                <input type="text" class="form-control input-sm" value="<?php echo $search_keyword; ?>" placeholder="Search" name="search_keyword" id="search_keyword">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default" id="search_btn"><i class="fa fa-search"></i></button>          
                                </div><!--input-group-btn-->
                                <?php echo form_close(); ?>

                                <?php
                                if ($this->session->userdata('user_search_keyword')) {
                                    ?>

                                    <a href="<?php echo base_url('recruiter/clear_search_post') ?>">Clear Search</a>

                                    <?php
                                }
                                ?>

                            </div><!--input-group input-group-sm-->
                        </div><!--box-tools-->
                    </div><!-- box-header -->

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <?php
                                    if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'post') {

                                        $segment2 = 'post';
                                    } else {

                                        $segment2 = 'search_post';
                                    }
                                    ?>

                                    <th><i class="fa fa-bullhorn"></i> 
                                        <a href="javascript:void(0);">ID.</a></th>

                                    <th><i class="fa fa-user"></i>
                                        <a href="<?php echo ( $this->uri->segment(3) == 'rec_firstname' && $this->uri->segment(4) == 'ASC') ? site_url($this->uri->segment(1) . '/' . $segment2 . '/rec_firstname/DESC/' . $offset) : site_url($this->uri->segment(1) . '/' . $segment2 . '/rec_firstname/ASC/' . $offset); ?>"> 
                                            Name
                                        </a>

<?php echo ( $this->uri->segment(3) == 'rec_firstname' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'rec_firstname' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' ); ?>

                                    </th>

                                    <th><i class="fa fa-fw fa-navicon"></i> 
                                        <a href="javascript:void(0);">Post Name</a>
                                    </th>

                                    <th><i class="fa fa-fw fa-calendar-check-o"></i> 
                                        <a href="javascript:void(0);">Required Experience</a>
                                    </th>

                                    <th><i class="fa fa-fw fa-home"></i> 
                                        <a href="javascript:void(0);">Location</a>
                                    </th>

                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Status</a>
                                    </th>

                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Created Date</a>
                                    </th>

                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Modify Date</a>
                                    </th>

                                    <th><i class=" fa fa-edit"></i> 
                                        <a href="javascript:void(0);">Action</a>
                                    </th>
                                </tr>

<?php
if ($total_rows != 0) {

    $i = $offset + 1;
    foreach ($users as $user) {
        ?>

                                        <tr id="delete<?php echo $user['post_id'] ?>">
                                            <td><?php echo $i++; ?></td>

                                            <td><?php echo ucfirst($user['fullname']);
                                echo ' ';
                                echo ucfirst($user['username']); ?></td>

                                            <td><?php echo $user['post_name']; ?></td>

                                            <td>

        <?php
        if ($user['post_exp_month'] || $user['post_exp_year']) {
            if ($user['post_exp_year']) {
                echo $user['post_exp_year'];
            }
            if ($user['post_exp_month']) {

                if ($user['post_exp_year'] == '0') {
                    echo 0;
                }
                echo ".";
                echo $user['post_exp_month'];
            }
            echo " Year";
        } else {
            echo PROFILENA;
        }
        ?>                     
                                            </td>

                                            <td> 
                                                <?php
                                                $cityname = $this->db->get_where('cities', array('city_id' => $user['city']))->row()->city_name;

                                                echo $cityname;
                                                if ($cityname) {
                                                    echo ",<br>";
                                                }

                                                $statename = $this->db->get_where('states', array('state_id' => $user['state']))->row()->state_name;

                                                echo $statename;
                                                if ($statename) {
                                                    echo ",<br>";
                                                }

                                                $countryname = $this->db->get_where('countries', array('country_id' => $user['country']))->row()->country_name;

                                                echo $countryname;
                                                ?>
                                            </td>

                                            <td id="active<?php echo $user['post_id'] ?>">
                                                <?php
                                                if ($user['status'] == 1) {
                                                    ?>
                                                    <button class="btn btn-block btn-primary btn-sm"  onclick="deactive_post(<?php echo $user['post_id']; ?>);">Active</button>
                                                    <?php } else {
                                                    ?>

                                                    <button class="btn btn-block btn-success btn-sm" onclick="active_post(<?php echo $user['post_id']; ?>);">Deactive</button>

                                                <?php } ?></button>
                                            </td>

                                            <td><?php echo $user['created_date']; ?></td>

                                            <td><?php echo $user['modify_date']; ?></td>

                                            <td>

                                                <!-- <button class="btn btn-primary btn-xs">
                                                 <i class="fa fa-pencil"></i>
                                                </button> -->

                                                <button class="btn btn-danger btn-xs" onclick="delete_post(<?php echo $user['post_id']; ?>);">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>

                                                <a class="btn btn-success btn-xs" href="<?php echo base_url('freelancer_hire/post_profile/' . $user['post_id']); ?>">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                              <!--   <button class="btn btn-success btn-xs onclick="<?php //echo base_url('job/profile'); ?>">
                                                <i class="fa fa-fw fa-eye"></i>
                                                </button> -->
                                            </td>

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
//deactive user Start
    function deactive_post(post_id)
    {

        $.fancybox.open('<div class="message"><h2>Are you Sure you want to  deactive this Post?</h2><button id="activate" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #activate').on('click', function ()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "recruiter/deactive_post" ?>',
                data: 'post_id=' + post_id,
                success: function (response)
                {
                    $.fancybox.close();
                    $('#' + 'active' + post_id).html(response);
                }
            });
        });
    }
//deactive user End

//active user Start
    function active_post(post_id)
    {

        $.fancybox.open('<div class="message"><h2>Are you Sure you want to  active this Post?</h2><button id="deactivate" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #deactivate').on('click', function ()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "recruiter/active_post" ?>',
                data: 'post_id=' + post_id,
                success: function (response)
                {
                    $.fancybox.close();
                    $('#' + 'active' + post_id).html(response);
                }
            });
        });
    }
//active user End\

//Delete user Start
    function delete_post(post_id)
    {

        $.fancybox.open('<div class="message"><h2>Are you Sure you want to Delete this Post?</h2><button id="delete" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #delete').on('click', function ()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "recruiter/delete_post" ?>',
                data: 'post_id=' + post_id,
                success: function (response)
                {
                    window.location.reload();
                }
            });
        });
    }
//Delete user End

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

// $(function() {

// });
</script>