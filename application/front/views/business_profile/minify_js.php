<?php
unlink('assets/js_min/webpage/business-profile/audio.min.js');
unlink('assets/js_min/webpage/business-profile/bus_search_login.min.js');
unlink('assets/js_min/webpage/business-profile/common.min.js');
unlink('assets/js_min/webpage/business-profile/contact_info.min.js');
unlink('assets/js_min/webpage/business-profile/contacts.min.js');
unlink('assets/js_min/webpage/business-profile/dashboard.min.js');
unlink('assets/js_min/webpage/business-profile/description.min.js');
unlink('assets/js_min/webpage/business-profile/details.min.js');
unlink('assets/js_min/webpage/business-profile/edit_profile.min.js');
unlink('assets/js_min/webpage/business-profile/followers.min.js');
unlink('assets/js_min/webpage/business-profile/following.min.js');
unlink('assets/js_min/webpage/business-profile/home.min.js');
unlink('assets/js_min/webpage/business-profile/image.min.js');
unlink('assets/js_min/webpage/business-profile/information.min.js');
unlink('assets/js_min/webpage/business-profile/pdf.min.js');
unlink('assets/js_min/webpage/business-profile/photos.min.js');
unlink('assets/js_min/webpage/business-profile/post_detail.min.js');
unlink('assets/js_min/webpage/business-profile/search.min.js');
unlink('assets/js_min/webpage/business-profile/user_dashboard.min.js');
unlink('assets/js_min/webpage/business-profile/user_dashboard_1.min.js');
unlink('assets/js_min/webpage/business-profile/userlist.min.js');
unlink('assets/js_min/webpage/business-profile/videos.min.js');

$bus_audio = array('webpage/business-profile/audio.js');
$bus_bus_search_login = array('webpage/business-profile/bus_search_login.js');
$bus_common = array('webpage/business-profile/common.js');
$bus_contact_info = array('webpage/business-profile/contact_info.js');
$bus_contacts = array('webpage/business-profile/contacts.js');
$bus_dashboard = array('webpage/business-profile/dashboard.js');
$bus_description = array('webpage/business-profile/description.js');
$bus_details = array('webpage/business-profile/details.js');
$bus_edit_profile = array('webpage/business-profile/edit_profile.js');
$bus_followers = array('webpage/business-profile/followers.js');
$bus_following = array('webpage/business-profile/following.js');
$bus_home = array('webpage/business-profile/home.js');
$bus_image = array('webpage/business-profile/image.js');
$bus_information = array('webpage/business-profile/information.js');
$bus_pdf = array('webpage/business-profile/pdf.js');
$bus_photos = array('webpage/business-profile/photos.js');
$bus_post_detail = array('webpage/business-profile/post_detail.js');
$bus_search = array('webpage/business-profile/search.js');
$bus_user_dashboard = array('webpage/business-profile/user_dashboard.js');
$bus_user_dashboard_1 = array('webpage/business-profile/user_dashboard_1.js');
$bus_userlist = array('webpage/business-profile/userlist.js');
$bus_videos = array('webpage/business-profile/videos.js');

$this->minify->js($bus_audio);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/audio.min.js');

$this->minify->js($bus_bus_search_login);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_search_login.min.js');

$this->minify->js($bus_common);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/common.min.js');

$this->minify->js($bus_contact_info);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/contact_info.min.js');

$this->minify->js($bus_contacts);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/contacts.min.js');

$this->minify->js($bus_dashboard);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/dashboard.min.js');

$this->minify->js($bus_description);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/description.min.js');

$this->minify->js($bus_details);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/details.min.js');

$this->minify->js($bus_edit_profile);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/edit_profile.min.js');

$this->minify->js($bus_followers);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/followers.min.js');

$this->minify->js($bus_following);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/following.min.js');

$this->minify->js($bus_home);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/home.min.js');

$this->minify->js($bus_image);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/image.min.js');

$this->minify->js($bus_information);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/information.min.js');

$this->minify->js($bus_pdf);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/pdf.min.js');

$this->minify->js($bus_photos);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/photos.min.js');

$this->minify->js($bus_post_detail);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/post_detail.min.js');

$this->minify->js($bus_search);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/search.min.js');

$this->minify->js($bus_user_dashboard);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/user_dashboard.min.js');

$this->minify->js($bus_user_dashboard_1);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/user_dashboard_1.min.js');

$this->minify->js($bus_userlist);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/userlist.min.js');

$this->minify->js($bus_videos);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/videos.min.js');


//$this->minify->js(array('helpers.js', 'jqModal.js'));
//echo $this->minify->deploy_js(FALSE, FALSE, 'custom_js_name.min.js');
?>
<div id="container">
    <h1>Welcome to CodeIgniter Minify library!</h1>


    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>