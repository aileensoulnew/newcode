<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/job/all_post_login.js" => "../js_min/webpage/job/all_post_login.js",
		"../js/webpage/job/cover_profile_common.js" => "../js_min/webpage/job/cover_profile_common.js",
		"../js/webpage/job/index.js" => "../js_min/webpage/job/index.js",
		"../js/webpage/job/job_all_post.js" => "../js_min/webpage/job/job_all_post.js",
		"../js/webpage/job/job_applied_post.js" => "../js_min/webpage/job/job_applied_post.js",
		"../js/webpage/job/job_education.js" => "../js_min/webpage/job/job_education.js",
		"../js/webpage/job/job_header2_border.js" => "../js_min/webpage/job/job_header2_border.js",
		"../js/webpage/job/job_printpreview.js" => "../js_min/webpage/job/job_printpreview.js",
		"../js/webpage/job/job_project.js" => "../js_min/webpage/job/job_project.js",
		"../js/webpage/job/job_reg.js" => "../js_min/webpage/job/job_reg.js",
		"../js/webpage/job/job_save_post.js" => "../js_min/webpage/job/job_save_post.js",
		"../js/webpage/job/job_search.js" => "../js_min/webpage/job/job_search.js",
		"../js/webpage/job/job_search_login.js" => "../js_min/webpage/job/job_search_login.js",
		"../js/webpage/job/job_skill.js" => "../js_min/webpage/job/job_skill.js",
		"../js/webpage/job/job_work_exp.js" => "../js_min/webpage/job/job_work_exp.js",
		"../js/webpage/job/progressbar_common.js" => "../js_min/webpage/job/progressbar_common.js",
		"../js/webpage/job/recruiter_post.js" => "../js_min/webpage/job/recruiter_post.js",
		"../js/webpage/job/recruiter_post_login.js" => "../js_min/webpage/job/recruiter_post_login.js",
		"../js/webpage/job/search_common.js" => "../js_min/webpage/job/search_common.js",
		"../js/webpage/job/search_job_reg&skill.js" => "../js_min/webpage/job/search_job_reg&skill.js",
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
