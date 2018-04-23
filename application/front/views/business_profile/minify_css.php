
<?php
// add css files
// COMMON HEAD CSS MINIFY START
$this->minify->css(array('common-style.css',
    'media.css',
    'animate.css',
    '1.10.3.jquery-ui.css',
    'header.css',
    'style.css',
    'font-awesome.min.css',
));
echo $this->minify->deploy_css(FALSE, 'common-header.min.css');
// COMMON HEAD CSS MINIFY END
// BUSINESS PROFILE START
// BUSINESS_INFO START   
$bus_info = array('1.10.3.jquery-ui.css',
    'business.css',
);
$this->minify->css($bus_info);
echo $this->minify->deploy_css(FALSE, 'business_profile/business-common.min.css');
// BUSINESS_INFO END 

// BUSINESS_PROFILE_POST START   
$bus_profile_post = array('../dragdrop/fileinput.css',
    '../dragdrop/themes/explorer/theme.css',
    '../css_min/business_profile/business-common.min.css',
    '../as-videoplayer/build/mediaelementplayer.css',
);
$this->minify->css($bus_profile_post);
echo $this->minify->deploy_css(FALSE, 'business_profile/business_profile.min.css');
// BUSINESS_PROFILE_POST END 

// BUSINESS PROFILE END   




//	//	$this->minify->js(array('helpers.js', 'jqModal.js'));
//echo $this->minify->deploy_js(FALSE, 'custom_js_name.min.js');
?>
<div id="container">
    <h1>Welcome to CodeIgniter Minify library!</h1>


    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>