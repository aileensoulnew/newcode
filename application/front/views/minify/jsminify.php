<?php


// BUSINESS_COMMON START   
$bus_info = array(
    'webpage/business-profile/common.js',
);
$this->minify->js($bus_info);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/common.min.js');



//$this->minify->js(array('helpers.js', 'jqModal.js'));
//echo $this->minify->deploy_js(FALSE, 'custom_js_name.min.js');
?>
<div id="container">
    <h1>Welcome to CodeIgniter Minify library!</h1>


    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>