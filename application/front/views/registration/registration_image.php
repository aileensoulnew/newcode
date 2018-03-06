<!-- start head -->
<?php  echo $head; ?>
 <!-- END HEAD -->

 <!-- style for imagepreview start !-->
<style>
#imagePreview {
    width: 150px;
    height: 150px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
}
</style>
<!-- style for imagepreview end !-->

<body>
	<header>
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-5">
						<div class="logo"><a href="index.html"><img src="<?php echo base_url('assets/images/logo-white.png?ver='.time()); ?>"></a></div>
					</div>
					<div class="col-md-8 col-sm-7">
					
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="user-midd-section">
			<div class="container">
				<div class="row">
					 <div class="col-md-2"></div>
          <div class="col-md-8">
						<div class="common-form">
							<h3>Regisration Form</h3>

<?php echo form_open_multipart(base_url('registration/reg_image_insert'),array('id' => 'regform','name' => 'regform','class' => "clearfix"));

 
               if ($this->session->flashdata('error')) 
               {
                      echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                }
                if ($this->session->flashdata('success'))
                 {
                         echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                }
 ?>
	
								
			                	<fieldset class="full-width">
			                  		<!-- hidden field for getting id from url Start-->
			                  		<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id?>">
			                   		<!-- hidden field for getting id from url End -->
			                  		<label>Upload your Photo</label>
			                  		<input type="file" name="photo" id="photoInput">
			                	</fieldset>
			                	<fieldset class="full-width">
			                		<div id="imagePreview" class="reg-profile">
			               			<!-- <img src="<?php //echo base_url('assets/images/user-img.png'); ?>" >  --> 
			                		</div>    
			                	</fieldset>
			                    <fieldset class="full-width">
			                    	<div class="registration-chechbox" > 
			                    	<input type="checkbox" id="checkbox"  name="checkbox" checked>
			                    	<span> I agree with <a style="color: #f0494d;"href="#">Terms of service</a> and <a style="color: #f0494d;" href="#">Privacy Policy.</a> </span>
			  						<?php echo form_error('checkbox') ?>
			                  	</fieldset>	
			                    <fieldset class="hs-submit full-width">
									<input type="submit" name="" value="Submit">
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<footer>
		<div class="footer text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="footer-logo">
							<a href="index.html"><img src="<?php echo base_url('assets/images/logo-white.png?ver='.time()); ?>"></a>
						</div>
						<ul>
							<li>E-912 Titanium City Center Anandngar Ahmedabad-380015</li>
							<li><a href="mailto:AileenSoul@gmail.com">AileenSoul@gmail.com</a></li>
							<li>+91 903-353-8102</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<p><i class="fa fa-copyright" aria-hidden="true"></i> 2017 All Rights Reserved </p>
					</div>
					<div class="col-md-6 col-sm-6">
						<ul>
							<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	</body>
</html>

<!-- Field Validation Js start -->

<!--This Script is also used For Image preview Start-->

<!--This Script is also used For Image preview End-->
<?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
?>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<?php } else{ ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
<?php } ?>


<!-- Field Validation Js End -->

<!-- Javascript for imagepreview start !-->

<script type="text/javascript">
$(function() {
    $("#photoInput").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});
</script>
<!--Javascript for imagepreview End !-->

<script type="text/javascript">

            //validation for edit email formate form

            $(document).ready(function () { 

                $("#regform").validate({

                    rules: {

                        checkbox: "required"
                    },

                    messages: {

                         checkbox: "Please accept our policy"
                     },

                });
                   });

         
  </script>