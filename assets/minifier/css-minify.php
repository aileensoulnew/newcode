<body style="font-family: monospace;">
<?php
	include_once("minifier.php");
	
	/* FILES ARRAYs
	 * Keys as input, Values as output */ 
	
	
	$css = array(
		"../css/1.10.3.jquery-ui.css"	=> "../css_min/1.10.3.jquery-ui.css",
		"../css/animate.css"			=> "../css_min/animate.css",
		"../css/artistic.css"			=> "../css_min/artistic.css",
		"../css/blog.css"			=> "../css_min/blog.css",
		"../css/business.css"			=> "../css_min/business.css",
		"../css/common-style.css"			=> "../css_min/common-style.css",
		"../css/cookieconsent.min.css"			=> "../css_min/cookieconsent.css",
		"../css/emojione.sprites.css"			=> "../css_min/emojione.sprites.css",
		"../css/emojionearea.css"			=> "../css_min/emojionearea.css",
		"../css/emojionearea.min.css"			=> "../css_min/emojionearea.min.css",
		"../css/fileinput.css"			=> "../css_min/fileinput.css",
		"../css/font-awesome.min.css"			=> "../css_min/font-awesome.min.css",
		"../css/freelancer-apply.css"			=> "../css_min/freelancer-apply.css",
		"../css/freelancer-hire.css"			=> "../css_min/freelancer-hire.css",
		"../css/header.css"			=> "../css_min/header.css",
		"../css/job.css"			=> "../css_min/job.css",
		"../css/jquery.fancybox.css"			=> "../css_min/jquery.fancybox.css",
		"../css/jquery.mCustomScrollbar.css"			=> "../css_min/jquery.mCustomScrollbar.css",
		"../css/media.css"			=> "../css_min/media.css",
		"../css/recruiter.css"			=> "../css_min/recruiter.css",
		"../css/slider.css"			=> "../css_min/slider.css",
		"../css/style.css"			=> "../css_min/style.css",
		"../css/style-main.css"			=> "../css_min/style-main.css",
		"../css/under-bootstrap.min.css"			=> "../css_min/under-bootstrap.min.css",
		"../css/under-styles.css"			=> "../css_min/under-styles.css",
	);
	
	minifyCSS($css);
?>
</body>
