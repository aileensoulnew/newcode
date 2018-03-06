<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  

         <?php if (IS_OUTSIDE_CSS_MINIFY == '0'){?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">    
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <?php }else{?>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">    
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">
        <?php }?>
           
    </head>
    <body class="page-container-bg-solid page-boxed">
    <?php echo $header; ?>
     <?php echo $job_header2_border;?>   
     <?php echo $footer;  ?>

	<div class="user-midd-section" id="paddingtop_fixed">
		<div class="container padding-360">
			<div class="gov-job-detail-left">
				<div class="gov-job-title">
					<table>
						<tr>
							<td>
								<?php if($govjob_post[0]['post_image']){?>
								<img src="<?php echo GOV_POST_THUMB_IMAGE . $govjob_post[0]['post_image']; ?>">
								<?php }else{?>
								<img src="<?php echo GOV_POST_NOIMAGE; ?>">
								<?php }?>
							</td>
							<td class="pl10">
								<h3><?php echo ucwords(ucfirst($govjob_post[0]['title'])); ?></h3>
								<p class="job-field"><b>Last Date:</b> <?php echo date('d-M-Y', strtotime($govjob_post[0]['last_date'])); ?></p>
							</td>
						</tr>
					</table>
				</div>
				<div class="gov-job-field">
					<ul>
						<li><p class="job-field"><b>Post Name:</b><?php echo ucwords(ucfirst($govjob_post[0]['post_name'])); ?></p></li>
						<li class="text-right"><p class="job-field"><b>Job Location:</b> <?php echo ucwords(ucfirst($govjob_post[0]['job_location'])); ?></p></li>
						<li><p class="job-field"><b>No. of Vacancies:</b> 

						<?php 
						if($govjob_post[0]['no_vacancies']){ 
						 echo ucwords(ucfirst($govjob_post[0]['no_vacancies'])); 
						 }else{
						?>
						Not Specified
						<?php }?>
					  </p></li>
						<li class="text-right"><p class="job-field"><b>Required Exp :</b> 

						<?php 
						if($govjob_post[0]['req_exp']){ 
						 echo ucwords(ucfirst($govjob_post[0]['req_exp'])); 
						 }else{
						?>
						Not Specified
						<?php }?>
					 </p></li>
						<li><p class="job-field"><b>Pay Scale :</b> 
						<?php if($govjob_post[0]['pay_scale']){ 
						 echo ucwords(ucfirst($govjob_post[0]['pay_scale'])); 
						 }else{
						?>
						Not Specified
						<?php }?>
					</p></li>
						
					</ul>
				</div>
				<div class="gov-job-detail">

					<?php if($govjob_post[0]['description']){?>
					<p><b>Job Discription :</b></p>
					<ul>
						<li><?php echo $govjob_post[0]['description']; ?></li>
					</ul>
					<?php }?>
					<?php if($govjob_post[0]['eligibility']){?>
					<p><b>Eligibility Criteria  :</b></p>
					<ul>
						<li><?php echo $govjob_post[0]['eligibility']; ?></li>
					</ul>
					<?php }?>
					<!-- <p><b>Company Profile:</b></p>
					<p>SBI Life Insurance Co. Ltd
SBI Life Insurance Company Limited is a joint venture between the State Bank of India and BNP Paribas Assurance. SBI Life Insurance is registered with an authorized capital of Rs 2000 crores and a Paid-up capital of Rs 1000 Crores. SBI owns 74% of the total capital and BNP Paribas Assurance the remaining 26%. </p>
					<p>State Bank of India enjoys the largest banking franchise in India. Along with its 6 Associate Banks, SBI Group has the unrivalled strength of over 16,000 branches across the country, arguably the largest in the world. </p>
					<p>State Bank of India enjoys the largest banking franchise in India. Along with its 6 Associate Banks, SBI Group has the unrivalled strength of over 16,000 branches across the country, arguably the largest in the world. </p> -->
				</div>
				<div class="gov-job-apply-btn">
					<a href="<?php echo $govjob_post[0]['apply_link']; ?>" target="blank">Apply</a>
				</div>
			</div>
			<div class="gov-job-detail-right">
				<div class="gov-job-right-title">
					<h3>Government job<a href="<?php echo base_url('goverment/allpost/'); ?>" class="pull-right">All Job</a></h3>
				</div>
				<div class="gov-job-list">					
				 <ul>
							 <?php 
            foreach ($govjob_category as $gov_key => $gov_value) { ?>
							<li><a href="<?php echo base_url('goverment/allpostdetail/'.$gov_value['id']); ?>"><?php echo $gov_value['name']?></a></li>
               <?php } ?>		
					</ul>					
				</div>
			</div>
		</div>
	</div>

   <?php if (IS_OUTSIDE_JS_MINIFY == '0'){?>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
<?php }else{?>
	<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
<?php }?>
<script>
 var base_url = '<?php echo base_url(); ?>';
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
var data1 = <?php echo json_encode($city_data); ?>;
</script>

 <?php if (IS_OUTSIDE_JS_MINIFY == '0'){?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/search.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/information.js?ver='.time()); ?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/search.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/information.js?ver='.time()); ?>"></script>
<?php }?>
</body>
</html>