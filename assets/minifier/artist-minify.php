<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/artist/address.js" => "../js_min/webpage/artist/address.js",
		"../js/webpage/artist/art_image_notification.js" => "../js_min/webpage/artist/art_image_notification.js",
		"../js/webpage/artist/art_information.js" => "../js_min/webpage/artist/art_information.js",
		"../js/webpage/artist/artistic_common.js" => "../js_min/webpage/artist/artistic_common.js",
		"../js/webpage/artist/audios.js" => "../js_min/webpage/artist/audios.js",
		"../js/webpage/artist/dashboard.js" => "../js_min/webpage/artist/dashboard.js",
		"../js/webpage/artist/details.js" => "../js_min/webpage/artist/details.js",
		"../js/webpage/artist/followers.js" => "../js_min/webpage/artist/followers.js",
		"../js/webpage/artist/following.js" => "../js_min/webpage/artist/following.js",
		"../js/webpage/artist/home.js" => "../js_min/webpage/artist/home.js",
		"../js/webpage/artist/information.js" => "../js_min/webpage/artist/information.js",
		"../js/webpage/artist/notification-home.js" => "../js_min/webpage/artist/notification-home.js",
		"../js/webpage/artist/pdf.js" => "../js_min/webpage/artist/pdf.js",
		"../js/webpage/artist/photos.js" => "../js_min/webpage/artist/photos.js",
		"../js/webpage/artist/portfolio.js" => "../js_min/webpage/artist/portfolio.js",
		"../js/webpage/artist/postnewpage.js" => "../js_min/webpage/artist/postnewpage.js",
		"../js/webpage/artist/profile.js" => "../js_min/webpage/artist/profile.js",
		"../js/webpage/artist/recommen_candidate.js" => "../js_min/webpage/artist/recommen_candidate.js",
		"../js/webpage/artist/search.js" => "../js_min/webpage/artist/search.js",
		"../js/webpage/artist/user_dashboard.js" => "../js_min/webpage/artist/user_dashboard.js",
		"../js/webpage/artist/user_search.js" => "../js_min/webpage/artist/user_search.js",
		"../js/webpage/artist/userlist.js" => "../js_min/webpage/artist/userlist.js",
		"../js/webpage/artist/videos.js" => "../js_min/webpage/artist/videos.js",
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
