<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/business-profile/audio.js" => "../js_min/webpage/business-profile/audio.js",
		"../js/webpage/business-profile/bus_search_login.js" => "../js_min/webpage/business-profile/bus_search_login.js",
		"../js/webpage/business-profile/common.js" => "../js_min/webpage/business-profile/common.js",
		"../js/webpage/business-profile/contact_info.js" => "../js_min/webpage/business-profile/contact_info.js",
		"../js/webpage/business-profile/contacts.js" => "../js_min/webpage/business-profile/contacts.js",
		"../js/webpage/business-profile/dashboard.js" => "../js_min/webpage/business-profile/dashboard.js",
		"../js/webpage/business-profile/description.js" => "../js_min/webpage/business-profile/description.js",
		"../js/webpage/business-profile/details.js" => "../js_min/webpage/business-profile/details.js",
		"../js/webpage/business-profile/edit_profile.js" => "../js_min/webpage/business-profile/edit_profile.js",
		"../js/webpage/business-profile/followers.js" => "../js_min/webpage/business-profile/followers.js",
		"../js/webpage/business-profile/following.js" => "../js_min/webpage/business-profile/following.js",
		"../js/webpage/business-profile/home.js" => "../js_min/webpage/business-profile/home.js",
		"../js/webpage/business-profile/image.js" => "../js_min/webpage/business-profile/image.js",
		"../js/webpage/business-profile/information.js" => "../js_min/webpage/business-profile/information.js",
		"../js/webpage/business-profile/pdf.js" => "../js_min/webpage/business-profile/pdf.js",
		"../js/webpage/business-profile/photos.js" => "../js_min/webpage/business-profile/photos.js",
		"../js/webpage/business-profile/post_detail.js" => "../js_min/webpage/business-profile/post_detail.js",
		"../js/webpage/business-profile/search.js" => "../js_min/webpage/business-profile/search.js",
		"../js/webpage/business-profile/user_dashboard.js" => "../js_min/webpage/business-profile/user_dashboard.js",
		"../js/webpage/business-profile/user_dashboard_1.js" => "../js_min/webpage/business-profile/user_dashboard_1.js",
		"../js/webpage/business-profile/userlist.js" => "../js_min/webpage/business-profile/userlist.js",
		"../js/webpage/business-profile/videos.js" => "../js_min/webpage/business-profile/videos.js",
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
