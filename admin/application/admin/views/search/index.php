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
            <li class="active"> User</li>
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
                        <?php if($module == 1){ ?>
                        <h3 class="box-title">Job User</h3>
                        <?php }elseif($module == 2){?>
                        <h3 class="box-title">Recruiter User</h3>
                        <?php }elseif($module == 3){ ?>
                        <h3 class="box-title">Freelancer Hire User</h3>
                        <?php }elseif($module == 4){ ?>
                        <h3 class="box-title">Freelancer Apply User</h3>
                        <?php }elseif($module == 5){?>
                        <h3 class="box-title">Business User</h3>
                        <?php }elseif($module == 6){?>
                        <h3 class="box-title">Artistic User</h3>
                        <?php }?>
                    
                    <div class="box-tools">
                       
                           <div class="input-group input-group-sm" >

                        <div class="input-group-btn">
                                        
                        </div><!--input-group-btn-->

                    </div><!--input-group input-group-sm-->
                </div><!--box-tools-->
                </div><!-- box-header -->

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-bordered">
                <tbody>
                <tr>
                 

                    <th><i class="fa fa-bullhorn"></i> 
                    <a href="javascript:void(0);">ID.</a></th>

                    <th><i class="fa fa-user"></i>
                    <a href="javascript:void(0);"> 
                     Name
                     </a>

                     <?php echo ( $this->uri->segment(3) == 'fname' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'fname' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' ); ?>

                    </th>

                    <th><i class="fa fa-envelope"></i> 
                     <a href="javascript:void(0);">Email</a>
                     </th>

                    <th><i class="fa fa-fw fa-phone-square"></i> 
                     <a href="javascript:void(0);">Search Keyword</a>
                     </th>

                    <th><i class="fa fa-fw fa-venus"></i> 
                     <a href="javascript:void(0);">Search Location</a>
                     </th>

                    <th><i class="fa fa-fw fa-home"></i> 
                     <a href="javascript:void(0);">User Location</a>
                     </th>
                     
                     <th><i class="fa fa-fw fa-bullhorn"></i> 
                     <a href="javascript:void(0);">Timing</a>
                     </th>

                </tr>
               
                 <?php
                if ($total_rows != 0) 
                {
                    
                        $i = $offset + 1; 
                        foreach ($users as $user) {
                ?>

                <tr id="delete<?php echo $user['job_id']?>">
                    <td><?php echo $i++; ?></td>

                    <td><?php echo ucfirst($user['first_name']); echo ' ';echo ucfirst($user['last_name']);  ?></td>

                    <td><?php echo $user['user_email']; ?></td>
                    <td><?php echo $user['search_keyword']; ?></td>

                    <td><?php if($user['search_location'])
                              {
                                echo $user['search_location']; 
                              }
                              else
                              {
                                echo PROFILENA;
                              }
                            ?>
                      </td>
 <?php $cityname = $this->db->get_where('cities', array('city_id' => $user['user_location']))->row()->city_name; ?>
                    <td><?php  echo $cityname; ?>
                       
                    </td>
                     <td><?php echo date("d-m-Y H:i:s", strtotime($user['created_date']));?>
                       
                    </td>


                </tr>
                 <?php
                      }//for loop close
                        }//if close
                        else 
                        {

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
                            if ($total_rows > 0) 
                            {

                                if ($this->pagination->create_links())
                                {
                                            $rec1 = $offset + 1;
                                            $rec2 = $offset + $limit;
                                            if ($rec2 > $total_rows) 
                                            {
                                                $rec2 = $total_rows;
                                            }

                            ?>

                <div style="margin-left: 20px;">

                    <?php  echo "Records $rec1 - $rec2 of $total_rows"; ?>

                </div><?php     
                            }
                            else 
                            {

                    ?>

                <div style="margin-left: 20px;">

                        <?php echo "Records 1 - $total_rows of $total_rows"; ?>

                </div>

                        <?php

                            }   }      

                        ?>
</div><!-- dta_left col-md-6--> 

<!-- /pagination Start-->

<?php
                        if ($this->pagination->create_links()) 
                        {

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

//Enable search button when user write something on textbox Start
 $(document).ready(function(){
    $('#search_btn').attr('disabled',true);

    $('#search_keyword').keyup(function()
    {  
        if($(this).val().length !=0)
        {
            $('#search_btn').attr('disabled', false);
        }
        else
        {  
            $('#search_btn').attr('disabled', true);        
        }
    })

     $('body').on('keydown', '#search_keyword', function(e) {
    console.log(this.value);
    if (e.which === 32 &&  e.target.selectionStart === 0) {
      return false;
    }  
  });
});
//Enable search button when user write something on textbox End

// $(function() {
 
// });
</script>