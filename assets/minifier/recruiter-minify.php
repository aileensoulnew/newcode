<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/recruiter/add_post.js" => "../js_min/webpage/recruiter/add_post.js",
		"../js/webpage/recruiter/add_post_login.js" => "../js_min/webpage/recruiter/add_post_login.js",
		"../js/webpage/recruiter/basic_info.js" => "../js_min/webpage/recruiter/basic_info.js",
		"../js/webpage/recruiter/company_info.js" => "../js_min/webpage/recruiter/company_info.js",
		"../js/webpage/recruiter/edit_post.js" => "../js_min/webpage/recruiter/edit_post.js",
		"../js/webpage/recruiter/rec_post.js" => "../js_min/webpage/recruiter/rec_post.js",
		"../js/webpage/recruiter/rec_post_login.js" => "../js_min/webpage/recruiter/rec_post_login.js",
		"../js/webpage/recruiter/rec_profile.js" => "../js_min/webpage/recruiter/rec_profile.js",
		"../js/webpage/recruiter/rec_reg.js" => "../js_min/webpage/recruiter/rec_reg.js",
		"../js/webpage/recruiter/rec_search.js" => "../js_min/webpage/recruiter/rec_search.js",
		"../js/webpage/recruiter/rec_search_login.js" => "../js_min/webpage/recruiter/rec_search_login.js",
		"../js/webpage/recruiter/recommen_candidate.js" => "../js_min/webpage/recruiter/recommen_candidate.js",
		"../js/webpage/recruiter/saved_candidate.js" => "../js_min/webpage/recruiter/saved_candidate.js",
		"../js/webpage/recruiter/search.js" => "../js_min/webpage/recruiter/search.js",
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
