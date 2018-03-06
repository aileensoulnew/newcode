<?php
echo $header;
echo $leftmenu;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
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
            <li class="active">Blog</li>
        </ol>
        <div class="fr">      
                         <a name="Add" href="<?php echo base_url('blog/add'); ?>" class="btn bg-orange btn-flat margin-r-5" ><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>Add Blog</a>
                         <!-- <a name="Add" href="<?php //echo base_url('blog/add'); ?>">Add Blog</a> -->
        </div>
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
                        <h3 class="box-title">Job User</h3>      
                    
                    <div class="box-tools">
                       <?php echo form_open('job/search', array('method' => 'post', 'id' => 'search_frm', 'class' => 'form-inline','autocomplete' => 'off')); ?>
                           <div class="input-group input-group-sm" >


                        <input type="text" class="form-control input-sm" value="<?php echo $search_keyword; ?>" placeholder="Search" name="search_keyword" id="search_keyword">

                        <div class="input-group-btn">
                                <button type="submit" class="btn btn-default" id="search_btn"><i class="fa fa-search"></i></button>          
                        </div><!--input-group-btn-->
                <?php echo form_close(); ?>
                     
                     <?php if ($this->session->userdata('user_search_keyword')) 
                            { 
                    ?>

                            <a href="<?php echo base_url('job/clear_search') ?>">Clear Search</a>

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

                        if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'user') 
                        {

                                $segment2 = 'user';

                        } 
                        else 
                        {

                                $segment2 = 'search';

                        }

                ?>

                    <th><i class="fa fa-bullhorn"></i> 
                    <a href="javascript:void(0);">ID.</a></th>

                    <th><i class="fa fa-user"></i>
                    <a href="<?php echo ( $this->uri->segment(3) == 'fname' && $this->uri->segment(4) == 'ASC') ? site_url($this->uri->segment(1) . '/' . $segment2 . '/fname/DESC/' . $offset) : site_url($this->uri->segment(1) . '/' . $segment2 . '/fname/ASC/' . $offset); ?>"> 
                     Title
                     </a>

                     <?php echo ( $this->uri->segment(3) == 'fname' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'fname' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' ); ?>

                    </th>
                    
                    <th><i class="fa fa-bullhorn"></i> 
                    <a href="javascript:void(0);">Category</a></th>
                    
                     <th><i class="fa fa-bullhorn"></i> 
                    <a href="javascript:void(0);">Related blog</a></th>

<!--                    <th><i class="fa fa-envelope"></i> 
                     <a href="javascript:void(0);">Tag Name</a>
                     </th>-->

                    <th><i class="fa fa-fw fa-image"></i> 
                     <a href="javascript:void(0);">Image</a>
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
                if (count($blog_detail) != 0) 
                {

                        $i = $offset + 1; 
                        foreach ($blog_detail as $blog) {
                ?>

                <tr id="delete<?php echo $blog['id'];?>">
                    <td><?php echo $i++; ?></td> 

                    <td><?php echo $blog['title']; ?></td>
                    <td><?php 
       $category =  explode(',', $blog['blog_category_id']);
      foreach($category as $catid){ 
  echo  '*' . $this->db->get_where('blog_category', array('id' => $catid))->row()->name . "<br>";
      }?></td>
                    
                    <td><?php 
       $related =  explode(',', $blog['blog_related_id']);
      foreach($related as $relid){ 
  echo  '*' . $this->db->get_where('blog', array('id' => $relid))->row()->title . "<br>";
      }?></td>
      

<!--                     <td>
                       <?php echo $blog['tag']; ?>
                     </td>-->

                    <td> 
                        <?php  if($blog['image']) 
                                {
                        ?>
                                <img src="<?php echo SITEURL . $this->config->item('blog_view_main_upload_path') . $blog['image']; ?>" alt=""  style="height: 70px; width: 70px;">
                        <?php }else{
                        ?>
                                <img alt="" style="height: 70px; width: 70px;" class="img-circle" src="<?php echo SITEURL.(NOIMAGE); ?>" alt="" />
                        <?php } ?>
                    </td>

                    <td id="active<?php echo $blog['id'];?>">
                        <?php if ($blog['status'] == 'publish') 
                              {
                        ?>
                                    <button class="btn btn-block  btn-primary btn-sm"  onclick="publish(<?php echo $blog['id'];?>);">Published</button>
                        <?php 
                            }else{ ?>

                                        <button class="btn btn-block btn-success btn-sm" onclick="draft(<?php echo $blog['id'];?>);">Draft</button>

                         <?php }?>
                    </td>

                    <td><?php echo $blog['created_date']; ?></td>

                    <td><?php echo $blog['modify_date']; ?></td>

                    <td>
                        <button class="btn btn-primary btn-xs" onclick="location.href='<?php echo base_url();?>blog/edit/<?php echo $blog['id']; ?>'" >
                         <i class="fa fa-pencil"></i>
                        </button>

                        <button class="btn btn-danger btn-xs" onclick="delete_blog(<?php echo $blog['id']; ?>);">
                        <i class="fa fa-trash-o"></i>
                        </button>

                        <a class="btn btn-success btn-xs" href="<?php echo base_url('blog/blogdetail/'.$blog['id'] ); ?>">
                         <i class="fa fa-fw fa-eye"></i>
                        </a>
                      <!--   <button class="btn btn-success btn-xs onclick="<?php //echo base_url('job/profile');?>">
                        <i class="fa fa-fw fa-eye"></i>
                        </button> -->
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
//deactive user Start
   function publish(id) 
   {
   
       $.fancybox.open('<div class="message"><h2>Are you Sure you want to change this status to draft?</h2><button id="activate" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #activate').on('click', function () 
        {
            $.ajax({
                         type: 'POST',
                          url: '<?php echo base_url() . "blog/publish" ?>',
                          data: 'id=' + id,
                          success: function (response) 
                          {    
                                 $.fancybox.close();
                                $('#'+'active'+id).html(response);
                          }
            });   
        });
    }
//deactive user End

//active user Start
   function draft(id) 
   {
     
       $.fancybox.open('<div class="message"><h2>Are you Sure you want to change this status to publish?</h2><button id="deactivate" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #deactivate').on('click', function () 
        {
            $.ajax({
                         type: 'POST',
                          url: '<?php echo base_url() . "blog/draft" ?>',
                          data: 'id=' + id,
                          success: function (response) 
                          {        
                                  $.fancybox.close();  
                                  $('#'+'active'+id).html(response);
                          }
            });   
        });
    }
//active user End\

//DELETE USER START
   function delete_blog(id) 
   {
   
       $.fancybox.open('<div class="message"><h2>Are you Sure you want to Delete this Blog?</h2><button id="delete" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #delete').on('click', function () 
        {
            $.ajax({
                         type: 'POST',
                          url: '<?php echo base_url() . "blog/delete_blog" ?>',
                          data: 'id=' + id,
                          success: function (response) 
                          {         
                                $.fancybox.close(); 
                                $('#'+'delete'+id).remove();
                          }
            });   
        });
    }
//DELETE USER END

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