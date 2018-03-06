<?php
echo $header;
echo $leftmenu;
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-11">
          <!-- Box Comment -->


          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">

                <img alt="" style="height: 70px; width: 70px;" class="img-circle" src="<?php echo SITEURL.(NOIMAGE); ?>" alt="" />

                <span class="username"><a href="#">Admin</a></span>
                <span class="description">Shared <?php echo $blog_detail[0]['status'];?> 

                <?php 
                    echo " - ";

                   $date_time = new DateTime($blog_detail[0]['created_date']);
                    $month= $date_time->format('M').PHP_EOL;
                    echo $month;

                    $date = new DateTime($blog_detail[0]['created_date']);
                    echo $date->format('d').PHP_EOL;

                     $year = new DateTime($blog_detail[0]['created_date']);
                    echo $year->format('Y').PHP_EOL;
                  ?>

                </span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

             <?php  if($blog_detail[0]['image']) 
                                {
                        ?>
                                <img src="<?php echo SITEURL . $this->config->item('blog_view_thumb_upload_path') . $blog_detail[0]['image']; ?>" alt="" style="width: auto" >
                        <?php }else{
                        ?>
                                <img alt="" style="height: 70px; width: 70px;" class="img-circle" src="<?php echo SITEURL.(WHITEIMAGE); ?>" alt="" />
                <?php } ?>

              <p><?php echo $blog_detail[0]['title']; ?></p>

              <span class="pull-right text-muted" id="total_comment">
              <?php 
                  $condition_array = array('blog_id'=>$blog_detail[0]['id'],'status !=' =>'reject');
                  $blog_comment = $this->common->select_data_by_condition('blog_comment', $condition_array, $data='*', $short_by='id', $order_by='desc', $limit=5, $offset, $join_str = array());
                  echo count($blog_comment);
                ?>
                  comments
              </span>
            </div>
            <!-- /.box-body -->

<?php
if($comment['status'] != 'reject')
{
 //FOR GETTING USER COMMENT
  $condition_array = array('status !=' => 'reject','blog_id' => $blog_detail[0]['id']);
  $blog_comment  = $this->common->select_data_by_condition('blog_comment', $condition_array, $data='*', $short_by='id', $order_by='desc', $limit, $offset, $join_str = array());
  //echo "<pre>";print_r($blog_comment );die();

  
    foreach ($blog_comment as $comment) 
    {
  ?>  
            <div class="box-footer box-comments" id="comment<?php echo $comment['id'];?>">
              <div class="box-comment">
                <!-- User image -->
               <img alt="" style="height: 70px; width: 70px;" class="img-circle" src="<?php echo SITEURL.(NOIMAGE); ?>" alt="" />

                <div class="comment-text">
                      <span class="username">
                        <?php echo $comment['name']; ?>
                        <span class="text-muted pull-right">
                  <?php
                    $date = new DateTime($comment['comment_date']);
                    echo $date->format('d').PHP_EOL;
                    echo "-";

                    $date = new DateTime($comment['comment_date']);
                    echo $date->format('M').PHP_EOL;
                    echo "-";

                    $date = new DateTime($comment['comment_date']);
                    echo $date->format('Y').PHP_EOL;
                    ?>
                        </span>

          
                  <span>

                  <div class="input-group input-group-lg approve_action">
                  <div class="input-group-btn">

                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Action<span class="fa fa-caret-down"></span></button>
                 
                  <ul class="dropdown-menu">

                   <?php if($comment['status'] == 'pending')
                          {
                    ?>
                    <li id="action<?php echo $comment['id'];?>"><a onclick="approve('<?php echo $comment['id'];?>')">Approve</a></li>
                    <?php 
                            }//if($comment['status'] == 'pending') end
                      ?>
                   
                    <li><a onclick="reject('<?php echo $comment['id'];?>','<?php echo $comment['blog_id']; ?>')">Reject</a></li>
                  </ul>
                </div>
                 <input type="text" id="status<?php echo $comment['id'];?>" class="form-control" value="<?php echo $comment['status']; ?>">
                 </div>
                </span>

                
                 <!-- <a onclick="read_more('<?php //echo $blog['id']; ?>','<?php //echo $blog['blog_slug']; ?>')"> Read more <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
</a> -->
                  </span><!-- /.username -->
                 <?php echo $comment['message']; ?>
                </div>
                <!-- /.comment-text -->
              </div>
            </div>
<?php
      }//for loop end
    }//if($comment['status'] != 'reject') End

?>
          </div>
    </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

</body>
</html>

<!-- THIS SCRIPT IS USED FOR APPROVE USER COMMENT START -->
<script type="text/javascript">
     
function approve(comment_id) {
       $.ajax({
           type: 'POST',
           url: '<?php echo base_url()."blog/approve_comment" ?>',
           data: 'comment_id=' + comment_id,         
           // dataType: "html",
           success: function (response) 
           {
               
                   $('#action'+comment_id).remove();
                   $('#status'+comment_id).val(response);
             
           }
       });
   }
</script>
<!-- THIS SCRIPT IS USED FOR APPROVE USER COMMENT END -->

<!-- THIS SCRIPT IS USED FOR REJECT USER COMMENT START -->
<script type="text/javascript">
     
function reject(comment_id,blog_id) {
   $.ajax({
           type: 'POST',
           url: '<?php echo base_url()."blog/reject_comment" ?>',
           data: 'comment_id=' + comment_id + '&blog_id=' + blog_id ,         
           success: function (response) 
           {
                   $('#total_comment').html(response);
                   $('#comment'+comment_id).remove();     
           }
       });
   }
</script>
<!-- THIS SCRIPT IS USED FOR REJECT USER COMMENT END -->