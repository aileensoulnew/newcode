<!-- start head -->
<?php  echo $head; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/business/business.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/timeline.css?ver='.time()); ?>">
<link rel="stylesheet" href="<?php echo base_url('css/select2-4.0.3.min.css?ver='.time()); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/common/mobile.css') ;?>" />
    <!-- END HEAD -->
    <!-- start header -->
<?php echo $header; ?>
    <!-- END HEADER -->
     <header>
    <div class="bg-search">
        <div class="header2">
            <div class="container">
                <div class="row">
                  <div class="col-md-2 col-sm-5">
                       <div class="pushmenu pushmenu-left">
                            <ul class="">
                              <li <?php if($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'business_profile_post'){?> class="active" <?php } ?>><a href="<?php echo base_url('business_profile/business_profile_post'); ?>">Home</a>
                                    </li>
                                <!-- Friend Request Start-->

                                <div>

                                </div>
                                <!-- Friend Request End-->

                                <!-- END USER LOGIN DROPDOWN -->
                            </ul>
                        </div> 
                    </div>
                  
                     <div class="col-md-10 col-sm-10">
                        <div class="job-search-box1 clearfix">
                        <form>
                            <fieldset class="col-md-5">
                             <!--    <label>Find Your Skills</label>
                              -->   <input type="text" name="" placeholder="Find Your Skill">
                            </fieldset>
                            <fieldset class="col-md-5">
                             <!--    <label>Find Your Location</label>
                              -->   <input type="text" name="" placeholder="Find Your Location">
                            </fieldset>
                            <fieldset class="col-md-2">
                                <button> Search</button>
                            </fieldset>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div> 
    </header>


   <!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function()
{


/* Uploading Profile BackGround Image */
$('body').on('change','#bgphotoimg', function()
{

$("#bgimageform").ajaxForm({target: '#timelineBackground',
beforeSubmit:function(){},
success:function(){

$("#timelineShade").hide();
$("#bgimageform").hide();
},
error:function(){

} }).submit();
});



/* Banner position drag */
$("body").on('mouseover','.headerimage',function ()
{
var y1 = $('#timelineBackground').height();
var y2 =  $('.headerimage').height();
$(this).draggable({
scroll: false,
axis: "y",
drag: function(event, ui) {
if(ui.position.top >= 0)
{
ui.position.top = 0;
}
else if(ui.position.top <= y1 - y2)
{
ui.position.top = y1 - y2;
}
},
stop: function(event, ui)
{
}
});
});


/* Bannert Position Save*/
$("body").on('click','.bgSave',function ()
{
var id = $(this).attr("id");
var p = $("#timelineBGload").attr("style");
var Y =p.split("top:");
var Z=Y[1].split(";");
var dataString ='position='+Z[0];
$.ajax({
type: "POST",
url: "<?php echo base_url('business_profile/image_saveBG_ajax'); ?>",
data: dataString,
cache: false,
beforeSend: function(){ },
success: function(html)
{
if(html)
{
  window.location.reload();
$(".bgImage").fadeOut('slow');
$(".bgSave").fadeOut('slow');
$("#timelineShade").fadeIn("slow");
$("#timelineBGload").removeClass("headerimage");
$("#timelineBGload").css({'margin-top':html});
return false;
}
}
});
return false;
});



});
</script>
</head>
<body>

<!-- cover pic start -->
<!-- cover pic end -->
         <div>
            <div class="container">
                
               
        </div>
        </div>

      
       

        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container">
                <div class="row">
                   
                    <div class="col-md-2">

                     <div  class="add-post-button">
   
        <a class="btn btn-3 btn-3b" href="<?php echo base_url('business_profile/business_profile_addpost'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Add Post</a>
  </div>
   <div  class="add-post-button">
   
      
        <a class="btn btn-3 btn-3b"href="<?php echo base_url('recruiter'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Recruiter</a>
  </div>
   </div>
                       
                        <div class="col-md-8 col-sm-8">
                        <div class="common-form">
                            <div class="job-saved-box">
                                <h3>Add New Post</h3>

                            <?php echo form_open_multipart(base_url('business_profile/business_profile_addpost_insert'), array('id' => 'business_profile_addpost','name' => 'business_profile_addpost','class' => 'clearfix')); ?>


                               <?php
                             $productname =  form_error('productname');
                             $postcategory =  form_error('image');
                             $description =  form_error('description');
                             
                            ?>

                            <fieldset class="full-width"><span style="color:red">Fields marked with asterisk (*) are mandatory</span></fieldset>

                            <fieldset  <?php if($productname) {  ?> class="error-msg" <?php } ?>><label>Product Name:<span style="color:red">*</span></label>
                              <input type="text" name="productname" id="productname" placeholder="Enter Product Name">
                              <?php echo form_error('productname'); ?>  
                            </fieldset>
                            

                            <fieldset <?php if($image) {  ?> class="error-msg" <?php } ?>><label>Product Image:<span style="color:red">*</span></label>
                              <input type="file" name="image" id="image">
                              <?php echo form_error('image'); ?>  
                            </fieldset>


                             <fieldset <?php if($description) {  ?> class="error-msg" <?php } ?> class="full-width">
                             
                             <textarea name ="description" id="description" rows="4" cols="50" placeholder="Enter Description" style="resize: none;"></textarea>
                                        
                               <?php echo form_error('description'); ?> 
                            </fieldset> 
                           


                 <div class="fr">           

                     <fieldset class="hs-submit full-width">
                                  <input type="reset" name="reset" value="Clear">
                                <input type="submit" name="productpost" id="productpost">
                                
                            </fieldset>
                      </div></form>
                                          
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                    </div>
                                </div>


                          
                        </div>
                    </div>
    </section>
    <footer>
<?php echo $footer?>
        </footer>

</body>

</html>


<!--<script src="<?php // echo base_url('js/jquery-ui.min.js?ver='.time()); ?>"></script>-->
<script src="<?php echo base_url('js/jquery.wallform.js?ver='.time()); ?>"></script>
 <script type="text/javascript" src="<?php echo site_url('js/jquery-ui.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js?ver='.time()); ?>"></script>


<script src="<?php echo base_url('js/fb_login.js?ver='.time()); ?>"></script>
<script type="text/javascript">

            //validation for edit email formate form

            $(document).ready(function () { 

                $("#business_profile_addpost").validate({

                    rules: {

                        productname: {

                            required: true,
                        },


                        image: {

                            required: true,
                        },


                        description: {
                            required: true,
                            
                        },

                       

                    },

                    messages: {

                        productname: {

                            required: "Product name Is Required.",
                            
                        },

                        image: {

                            required: "Image Is Required.",
                            
                        },

                        description: {
                            required: "Description is required",
                            
                        },
                       

                    },

                });
                   });
  </script>

  <!-- script for skill textbox automatic start (option 2)-->

 <!--<script src="<?php echo base_url('js/select2-4.0.3.min.js?ver='.time()); ?>"></script>-->
<!-- script for skill textbox automatic end (option 2)-->

  <script>

  //select2 autocomplete start for Location
$('#searchplace').select2({
        
        placeholder: 'Find Your Location',
         maximumSelectionLength: 1,
        ajax:{

         
          url: "<?php echo base_url(); ?>business_profile/location",
          dataType: 'json',
          delay: 250,
          
          processResults: function (data) {
            
            return {
             
              results: data


            };
            
          },
           cache: true
        }
      });
//select2 autocomplete End for Location

</script>
<script type="text/javascript" defer="defer" src="<?php echo base_url('js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>