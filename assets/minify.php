<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"js/webpage/aboutus.js" 	=> "js_min/webpage/aboutus.js",
		"js/webpage/blog_detail.js" => "js_min/webpage/blog_detail.js",
		"js/webpage/contactus.js" => "js_min/webpage/contactus.js",
		"js/webpage/feedback.js" => "js_min/webpage/feedback.js",
		"js/webpage/main.js" => "js_min/webpage/main.js",
		"js/webpage/business-profile/audio.js" => "js_min/webpage/business-profile/audio.js",
		"js/webpage/business-profile/bus_search_login.js" => "js_min/webpage/business-profile/bus_search_login.js",
		"js/webpage/business-profile/common.js" => "js_min/webpage/business-profile/common.js",
		"js/webpage/business-profile/contact_info.js" => "js_min/webpage/business-profile/contact_info.js",
		"js/webpage/business-profile/contacts.js" => "js_min/webpage/business-profile/contacts.js",
		"js/webpage/business-profile/dashboard.js" => "js_min/webpage/business-profile/dashboard.js",
		"js/webpage/business-profile/description.js" => "js_min/webpage/business-profile/description.js",
		"js/webpage/business-profile/details.js" => "js_min/webpage/business-profile/details.js",
		"js/webpage/business-profile/edit_profile.js" => "js_min/webpage/business-profile/edit_profile.js",
		"js/webpage/business-profile/followers.js" => "js_min/webpage/business-profile/followers.js",
		"js/webpage/business-profile/following.js" => "js_min/webpage/business-profile/following.js",
		"js/webpage/business-profile/home.js" => "js_min/webpage/business-profile/home.js",
		"js/webpage/business-profile/image.js" => "js_min/webpage/business-profile/image.js",
		"js/webpage/business-profile/information.js" => "js_min/webpage/business-profile/information.js",
		"js/webpage/business-profile/pdf.js" => "js_min/webpage/business-profile/pdf.js",
		"js/webpage/business-profile/photos.js" => "js_min/webpage/business-profile/photos.js",
		"js/webpage/business-profile/post_detail.js" => "js_min/webpage/business-profile/post_detail.js",
		"js/webpage/business-profile/search.js" => "js_min/webpage/business-profile/search.js",
		"js/webpage/business-profile/user_dashboard.js" => "js_min/webpage/business-profile/user_dashboard.js",
		"js/webpage/business-profile/user_dashboard_1.js" => "js_min/webpage/business-profile/user_dashboard_1.js",
		"js/webpage/business-profile/userlist.js" => "js_min/webpage/business-profile/userlist.js",
		"js/webpage/business-profile/videos.js" => "js_min/webpage/business-profile/videos.js",
		"js/webpage/artist/address.js" => "js_min/webpage/artist/address.js",
		"js/webpage/artist/art_image_notification.js" => "js_min/webpage/artist/art_image_notification.js",
		"js/webpage/artist/art_information.js" => "js_min/webpage/artist/art_information.js",
		"js/webpage/artist/artistic_common.js" => "js_min/webpage/artist/artistic_common.js",
		"js/webpage/artist/audios.js" => "js_min/webpage/artist/audios.js",
		"js/webpage/artist/dashboard.js" => "js_min/webpage/artist/dashboard.js",
		"js/webpage/artist/details.js" => "js_min/webpage/artist/details.js",
		"js/webpage/artist/followers.js" => "js_min/webpage/artist/followers.js",
		"js/webpage/artist/following.js" => "js_min/webpage/artist/following.js",
		"js/webpage/artist/home.js" => "js_min/webpage/artist/home.js",
		"js/webpage/artist/information.js" => "js_min/webpage/artist/information.js",
		"js/webpage/artist/notification-home.js" => "js_min/webpage/artist/notification-home.js",
		"js/webpage/artist/pdf.js" => "js_min/webpage/artist/pdf.js",
		"js/webpage/artist/photos.js" => "js_min/webpage/artist/photos.js",
		"js/webpage/artist/portfolio.js" => "js_min/webpage/artist/portfolio.js",
		"js/webpage/artist/postnewpage.js" => "js_min/webpage/artist/postnewpage.js",
		"js/webpage/artist/profile.js" => "js_min/webpage/artist/profile.js",
		"js/webpage/artist/recommen_candidate.js" => "js_min/webpage/artist/recommen_candidate.js",
		"js/webpage/artist/search.js" => "js_min/webpage/artist/search.js",
		"js/webpage/artist/user_dashboard.js" => "js_min/webpage/artist/user_dashboard.js",
		"js/webpage/artist/user_search.js" => "js_min/webpage/artist/user_search.js",
		"js/webpage/artist/userlist.js" => "js_min/webpage/artist/userlist.js",
		"js/webpage/artist/videos.js" => "js_min/webpage/artist/videos.js",
		"js/webpage/blog/blog.js" => "js_min/webpage/blog/blog.js",
		"js/webpage/blog/blog_detail.js" => "js_min/webpage/blog/blog_detail.js",
		"js/webpage/dashboard/cover.js" => "js_min/webpage/dashboard/cover.js",
		"js/webpage/freelancer-apply/apply_search.js" => "js_min/webpage/freelancer-apply/apply_search.js",
		"js/webpage/freelancer-apply/freelancer_applied_post.js" => "js_min/webpage/freelancer-apply/freelancer_applied_post.js",
		"js/webpage/freelancer-apply/freelancer_apply_common.js" => "js_min/webpage/freelancer-apply/freelancer_apply_common.js",
		"js/webpage/freelancer-apply/freelancer_apply_search_result.js" => "js_min/webpage/freelancer-apply/freelancer_apply_search_result.js",
		"js/webpage/freelancer-apply/freelancer_post_address_information.js" => "js_min/webpage/freelancer-apply/freelancer_post_address_information.js",
		"js/webpage/freelancer-apply/freelancer_post_avability.js" => "js_min/webpage/freelancer-apply/freelancer_post_avability.js",
		"js/webpage/freelancer-apply/freelancer_post_basic_information.js" => "js_min/webpage/freelancer-apply/freelancer_post_basic_information.js",
		"js/webpage/freelancer-apply/freelancer_post_education.js" => "js_min/webpage/freelancer-apply/freelancer_post_basic_information.js",
		"js/webpage/freelancer-apply/freelancer_post_portfolio.js" => "js_min/webpage/freelancer-apply/freelancer_post_portfolio.js",
		"js/webpage/freelancer-apply/freelancer_post_professional_information.js" => "js_min/webpage/freelancer-apply/freelancer_post_professional_information.js",
		"js/webpage/freelancer-apply/freelancer_post_profile.js" => "js_min/webpage/freelancer-apply/freelancer_post_profile.js",
		"js/webpage/freelancer-apply/freelancer_post_rate.js" => "js_min/webpage/freelancer-apply/freelancer_post_rate.js",
		"js/webpage/freelancer-apply/freelancer_save_post.js" => "js_min/webpage/freelancer-apply/freelancer_save_post.js",
		"js/webpage/freelancer-apply/post_apply.js" => "js_min/webpage/freelancer-apply/post_apply.js",
		"js/webpage/freelancer-apply/progressbar.js" => "js_min/webpage/freelancer-apply/progressbar.js",
		"js/webpage/freelancer-apply/registation.js" => "js_min/webpage/freelancer-apply/registation.js",
		"js/webpage/freelancer-hire/add_post_live.js" => "js_min/webpage/freelancer-hire/add_post_live.js",
		"js/webpage/freelancer-hire/freelancer_add_post.js" => "js_min/webpage/freelancer-hire/freelancer_add_post.js",
		"js/webpage/freelancer-hire/freelancer_apply_list.js" => "js_min/webpage/freelancer-hire/freelancer_apply_list.js",
		"js/webpage/freelancer-hire/freelancer_edit_post.js" => "js_min/webpage/freelancer-hire/freelancer_edit_post.js",
		"js/webpage/freelancer-hire/freelancer_hire_address_info.js" => "js_min/webpage/freelancer-hire/freelancer_hire_address_info.js",
		"js/webpage/freelancer-hire/freelancer_hire_basic_info.js" => "js_min/webpage/freelancer-hire/freelancer_hire_basic_info.js",
		"js/webpage/freelancer-hire/freelancer_hire_common.js" => "js_min/webpage/freelancer-hire/freelancer_hire_common.js",
		"js/webpage/freelancer-hire/freelancer_hire_post.js" => "js_min/webpage/freelancer-hire/freelancer_hire_post.js",
		"js/webpage/freelancer-hire/freelancer_hire_professional_info.js" => "js_min/webpage/freelancer-hire/freelancer_hire_professional_info.js",
		"js/webpage/freelancer-hire/freelancer_hire_profile.js" => "js_min/webpage/freelancer-hire/freelancer_hire_profile.js",
		"js/webpage/freelancer-hire/freelancer_hire_search_result.js" => "js_min/webpage/freelancer-hire/freelancer_hire_search_result.js",
		"js/webpage/freelancer-hire/freelancer_save.js" => "js_min/webpage/freelancer-hire/freelancer_save.js",
		"js/webpage/freelancer-hire/hire_registration.js" => "js_min/webpage/freelancer-hire/hire_registration.js",
		"js/webpage/freelancer-hire/project_live.js" => "js_min/webpage/freelancer-hire/project_live.js",
		"js/webpage/freelancer-hire/project_live_login.js" => "js_min/webpage/freelancer-hire/project_live_login.js",
		"js/webpage/freelancer-hire/recommen_candidate.js" => "js_min/webpage/freelancer-hire/recommen_candidate.js",
		"js/webpage/job/all_post_login.js" => "js_min/webpage/job/all_post_login.js",
		"js/webpage/job/cover_profile_common.js" => "js_min/webpage/job/cover_profile_common.js",
		"js/webpage/job/index.js" => "js_min/webpage/job/index.js",
		"js/webpage/job/job_all_post.js" => "js_min/webpage/job/job_all_post.js",
		"js/webpage/job/job_applied_post.js" => "js_min/webpage/job/job_applied_post.js",
		"js/webpage/job/job_education.js" => "js_min/webpage/job/job_education.js",
		"js/webpage/job/job_header2_border.js" => "js_min/webpage/job/job_header2_border.js",
		"js/webpage/job/job_printpreview.js" => "js_min/webpage/job/job_printpreview.js",
		"js/webpage/job/job_project.js" => "js_min/webpage/job/job_project.js",
		"js/webpage/job/job_reg.js" => "js_min/webpage/job/job_reg.js",
		"js/webpage/job/job_save_post.js" => "js_min/webpage/job/job_save_post.js",
		"js/webpage/job/job_search.js" => "js_min/webpage/job/job_search.js",
		"js/webpage/job/job_search_login.js" => "js_min/webpage/job/job_search_login.js",
		"js/webpage/job/job_skill.js" => "js_min/webpage/job/job_skill.js",
		"js/webpage/job/job_work_exp.js" => "js_min/webpage/job/job_work_exp.js",
		"js/webpage/job/progressbar_common.js" => "js_min/webpage/job/progressbar_common.js",
		"js/webpage/job/recruiter_post.js" => "js_min/webpage/job/recruiter_post.js",
		"js/webpage/job/recruiter_post_login.js" => "js_min/webpage/job/recruiter_post_login.js",
		"js/webpage/job/search_common.js" => "js_min/webpage/job/search_common.js",
		"js/webpage/job/search_job_reg&skill.js" => "js_min/webpage/job/search_job_reg&skill.js",
		"js/webpage/login/index.js" => "js_min/webpage/login/index.js",
		"js/webpage/notification/artistic_post.js" => "js_min/webpage/notification/artistic_post.js",
		"js/webpage/notification/bus_image.js" => "js_min/webpage/notification/bus_image.js",
		"js/webpage/notification/business_post.js" => "js_min/webpage/notification/business_post.js",
		"js/webpage/notification/notification.js" => "js_min/webpage/notification/notification.js",
		"js/webpage/profile/profile.js" => "js_min/webpage/profile/profile.js",
		"js/webpage/recruiter/add_post.js" => "js_min/webpage/recruiter/add_post.js",
		"js/webpage/profile/add_post_login.js" => "js_min/webpage/profile/add_post_login.js",
		"js/webpage/profile/basic_info.js" => "js_min/webpage/profile/basic_info.js",
		"js/webpage/profile/company_info.js" => "js_min/webpage/profile/company_info.js",
		"js/webpage/profile/edit_post.js" => "js_min/webpage/profile/edit_post.js",
		"js/webpage/profile/rec_post.js" => "js_min/webpage/profile/rec_post.js",
		"js/webpage/profile/rec_post_login.js" => "js_min/webpage/profile/rec_post_login.js",
		"js/webpage/profile/rec_profile.js" => "js_min/webpage/profile/rec_profile.js",
		"js/webpage/profile/rec_reg.js" => "js_min/webpage/profile/rec_reg.js",
		"js/webpage/profile/rec_search.js" => "js_min/webpage/profile/rec_search.js",
		"js/webpage/profile/rec_search_login.js" => "js_min/webpage/profile/rec_search_login.js",
		"js/webpage/profile/recommen_candidate.js" => "js_min/webpage/profile/recommen_candidate.js",
		"js/webpage/profile/saved_candidate.js" => "js_min/webpage/profile/saved_candidate.js",
		"js/webpage/profile/search.js" => "js_min/webpage/profile/search.js",
		"js/webpage/registration/changepassword.js" => "js_min/webpage/registration/changepassword.js",
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
