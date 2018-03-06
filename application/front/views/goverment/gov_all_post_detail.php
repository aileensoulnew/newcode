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

			<!-- all post start -->
			<?php 
			foreach ($govjob_post as $post_key => $post_value) {
				
			?>
			<a href="<?php echo base_url('goverment/postdetails/'.$post_value['id']); ?>">

			<div class="gov-job-detail-left">
				<div class="gov-job-title">
					<table>
						<tr>
							<td>
								<?php if($post_value['post_image']){?>
								<img src="<?php echo GOV_POST_THUMB_IMAGE . $post_value['post_image']; ?>">
								<?php }else{?>
								<img src="<?php echo GOV_POST_NOIMAGE; ?>">
								<?php }?>
							</td>
							<td class="pl10">
								<h3><?php echo ucwords(ucfirst($post_value['title'])); ?></h3>
								<p class="job-field"><b>Last Date:</b> <?php echo date('d-M-Y', strtotime($post_value['last_date'])); ?></p>
							</td>
						</tr>
					</table>
				</div>
				<div class="gov-job-field">
					<ul>
						<li><p class="job-field"><b>Post Name:</b> <?php echo ucwords(ucfirst($post_value['post_name'])); ?></p></li>
						<li class="text-right"><p class="job-field"><b>Job Location:</b> <?php echo ucwords(ucfirst($post_value['job_location'])); ?></p></li>
						<li><p class="job-field"><b>No. of Vacancies:</b> 
						<?php 
						if($post_value['no_vacancies']){ 
						 echo ucwords(ucfirst($post_value['no_vacancies'])); 
						 }else{
						?>
						Not Specified
						<?php }?>
					    </p></li>
						<li class="text-right"><p class="job-field"><b>Required Exp :</b> 
						<?php 
						if($post_value['req_exp']){ 
						 echo ucwords(ucfirst($post_value['req_exp'])); 
						 }else{
						?>
						Not Specified
						<?php }?>
					    </p></li>
						<li><p class="job-field"><b>Pay Scale :</b>
						<?php 
						if($post_value['pay_scale']){ 
						 echo ucwords(ucfirst($post_value['pay_scale'])); 
						 }else{
						?>
						Not Specified
						<?php }?>
						</p></li>	
					</ul>
				</div>
				<div class="gov-job-detail">
					<p><b>Job Discription :</b></p>
					<ul>
						<li> 
							<?php
							 $num_words = 29;
                             $words = array();
                                       $words = explode(" ",  $post_value['description'], $num_words);
                                       $shown_string = "";
                                        if(count($words) == 29){
                                          $words[28] ='.....';
                                        }

                                         $shown_string = implode(" ", $words); 
                                          //echo "<pre>"; print_r($shown_string); die();
                                         echo $this->common->make_links($shown_string);
                              ?>

							<!-- <?php //echo $post_value['description']; ?> -->

							</li>
					</ul>
					<div class="gov-read-more">
						<span>Read More</span>
					</div>
				</div>
				
			</div>
		    </a>
			<?php }?>
			<!-- all post end -->
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
</body>
</html>