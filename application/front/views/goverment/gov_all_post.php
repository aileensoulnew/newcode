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
    <body class="page-container-bg-solid page-boxed gov-all-post">
    <?php echo $header; ?>
     <?php echo $job_header2_border;?>   
     

	<div class="user-midd-section" id="paddingtop_fixed">
		<div class="container padding-360">
			<div class="gov-job-detail-left">
			<div class="gov-job-saved-box">
				<h3>All Government Jobs</h3>
				<div class="contact-frnd-post">
					<ul class="all-job-cat">

						<?php

							foreach ($govjob_category as $gov_key => $gov_value) { ?>
							<li>
							<a href="<?php echo base_url('goverment/allpostdetail/'.$gov_value['id']); ?>">
								<div class="all-job-box">
									<div class="job-box-left">
										<?php if($gov_value['image']){ ?>
										<img src="<?php echo GOV_CATE_IMAGE . $gov_value['image']; ?>">
										<?php }else{?>
										<img src="<?php echo GOV_CATE_NOIMAGE; ?>">
										<?php }?>
									</div>
									<div class="all-job-right">
										<span class="job-name"><?php echo $gov_value['name']?></span>
									</div>
								</div>
							</a>
						</li>							
							<?php } ?>						
					</ul>
				</div>
			</div>
			
			</div>
		
			<div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
					
						<div class="fw text-center">
                         <script type="text/javascript">
  ( function() {
    if (window.CHITIKA === undefined) { window.CHITIKA = { 'units' : [] }; };
    var unit = {"calltype":"async[2]","publisher":"Aileensoul","width":300,"height":250,"sid":"Chitika Default"};
    var placement_id = window.CHITIKA.units.length;
    window.CHITIKA.units.push(unit);
    document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
}());
</script>
<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
						</div>
						
						<div class="fw pt10 text-right">
									<a href="https://www.chitika.com/publishers/apply?refid=aileensoul"><img src="https://images.chitika.net/ref_banners/300x250_hidden_ad.png" /></a>
								</div>
                </div>
				<div class="tablate-add">

                            <script type="text/javascript">
						  ( function() {
							if (window.CHITIKA === undefined) { window.CHITIKA = { 'units' : [] }; };
							var unit = {"calltype":"async[2]","publisher":"Aileensoul","width":160,"height":600,"sid":"Chitika Default"};
							var placement_id = window.CHITIKA.units.length;
							window.CHITIKA.units.push(unit);
							document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
						}());
						</script>
						<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
                        </div>
		</div>
		
	</div>

  <?php echo $footer;  ?>
</body>
</html>