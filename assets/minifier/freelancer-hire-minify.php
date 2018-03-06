<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/freelancer-hire/add_post_live.js" => "../js_min/webpage/freelancer-hire/add_post_live.js",
		"../js/webpage/freelancer-hire/freelancer_add_post.js" => "../js_min/webpage/freelancer-hire/freelancer_add_post.js",
		"../js/webpage/freelancer-hire/freelancer_apply_list.js" => "../js_min/webpage/freelancer-hire/freelancer_apply_list.js",
		"../js/webpage/freelancer-hire/freelancer_edit_post.js" => "../js_min/webpage/freelancer-hire/freelancer_edit_post.js",
		"../js/webpage/freelancer-hire/freelancer_hire_address_info.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_address_info.js",
		"../js/webpage/freelancer-hire/freelancer_hire_basic_info.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_basic_info.js",
		"../js/webpage/freelancer-hire/freelancer_hire_common.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_common.js",
		"../js/webpage/freelancer-hire/freelancer_hire_post.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_post.js",
		"../js/webpage/freelancer-hire/freelancer_hire_professional_info.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_professional_info.js",
		"../js/webpage/freelancer-hire/freelancer_hire_profile.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_profile.js",
		"../js/webpage/freelancer-hire/freelancer_hire_search_result.js" => "../js_min/webpage/freelancer-hire/freelancer_hire_search_result.js",
		"../js/webpage/freelancer-hire/freelancer_save.js" => "../js_min/webpage/freelancer-hire/freelancer_save.js",
		"../js/webpage/freelancer-hire/hire_registration.js" => "../js_min/webpage/freelancer-hire/hire_registration.js",
		"../js/webpage/freelancer-hire/project_live.js" => "../js_min/webpage/freelancer-hire/project_live.js",
		"../js/webpage/freelancer-hire/project_live_login.js" => "../js_min/webpage/freelancer-hire/project_live_login.js",
		"../js/webpage/freelancer-hire/recommen_candidate.js" => "../js_min/webpage/freelancer-hire/recommen_candidate.js",
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
