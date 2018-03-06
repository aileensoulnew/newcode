<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/freelancer-apply/apply_search.js" => "../js_min/webpage/freelancer-apply/apply_search.js",
		"../js/webpage/freelancer-apply/freelancer_applied_post.js" => "../js_min/webpage/freelancer-apply/freelancer_applied_post.js",
		"../js/webpage/freelancer-apply/freelancer_apply_common.js" => "../js_min/webpage/freelancer-apply/freelancer_apply_common.js",
		"../js/webpage/freelancer-apply/freelancer_apply_search_result.js" => "../js_min/webpage/freelancer-apply/freelancer_apply_search_result.js",
		"../js/webpage/freelancer-apply/freelancer_post_address_information.js" => "../js_min/webpage/freelancer-apply/freelancer_post_address_information.js",
		"../js/webpage/freelancer-apply/freelancer_post_avability.js" => "../js_min/webpage/freelancer-apply/freelancer_post_avability.js",
		"../js/webpage/freelancer-apply/freelancer_post_basic_information.js" => "../js_min/webpage/freelancer-apply/freelancer_post_basic_information.js",
		"../js/webpage/freelancer-apply/freelancer_post_education.js" => "../js_min/webpage/freelancer-apply/freelancer_post_basic_information.js",
		"../js/webpage/freelancer-apply/freelancer_post_portfolio.js" => "../js_min/webpage/freelancer-apply/freelancer_post_portfolio.js",
		"../js/webpage/freelancer-apply/freelancer_post_professional_information.js" => "../js_min/webpage/freelancer-apply/freelancer_post_professional_information.js",
		"../js/webpage/freelancer-apply/freelancer_post_profile.js" => "../js_min/webpage/freelancer-apply/freelancer_post_profile.js",
		"../js/webpage/freelancer-apply/freelancer_post_rate.js" => "../js_min/webpage/freelancer-apply/freelancer_post_rate.js",
		"../js/webpage/freelancer-apply/freelancer_save_post.js" => "../js_min/webpage/freelancer-apply/freelancer_save_post.js",
		"../js/webpage/freelancer-apply/post_apply.js" => "../js_min/webpage/freelancer-apply/post_apply.js",
		"../js/webpage/freelancer-apply/progressbar.js" => "../js_min/webpage/freelancer-apply/progressbar.js",
		"../js/webpage/freelancer-apply/registation.js" => "../js_min/webpage/freelancer-apply/registation.js",
	);
	
/*	$css = array(
		"css/application.css"	=> "css/application.min.css",
		"css/main.css"			=> "css/main.min.css"
	);
*/	
	minifyJS($js);
//	minifyCSS($css);
?>
</body>
