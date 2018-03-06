<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	$js = array(
		"../js/webpage/aboutus.js" 	=> "../js_min/webpage/aboutus.js",
		"../js/webpage/blog_detail.js" => "../js_min/webpage/blog_detail.js",
		"../js/webpage/contactus.js" => "../js_min/webpage/contactus.js",
		"../js/webpage/feedback.js" => "../js_min/webpage/feedback.js",
		"../js/webpage/main.js" => "../js_min/webpage/main.js",
		"../js/webpage/blog/blog.js" => "../js_min/webpage/blog/blog.js",
		"../js/webpage/blog/blog_detail.js" => "../js_min/webpage/blog/blog_detail.js",
		"../js/webpage/dashboard/cover.js" => "../js_min/webpage/dashboard/cover.js",
		"../js/webpage/login/index.js" => "../js_min/webpage/login/index.js",
		"../js/webpage/notification/artistic_post.js" => "../js_min/webpage/notification/artistic_post.js",
		"../js/webpage/notification/bus_image.js" => "../js_min/webpage/notification/bus_image.js",
		"../js/webpage/notification/business_post.js" => "../js_min/webpage/notification/business_post.js",
		"../js/webpage/notification/notification.js" => "../js_min/webpage/notification/notification.js",
		"../js/webpage/profile/profile.js" => "../js_min/webpage/profile/profile.js",
		"../js/webpage/registration/changepassword.js" => "../js_min/webpage/registration/changepassword.js",
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
