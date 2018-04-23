<?php
// BUSINESS_COMMON START   
$bus_info = array(
    'webpage/business-profile/common.js',
);
$this->minify->js($bus_info);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/common.min.js');


// BUSINESS_AUDIO START   
$bus_audio = array(
    'webpage/business-profile/common.js',
);
$this->minify->js($bus_audio);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/audio.min.js');

// CONTACT LIST START   
$bus_audio = array(
    'webpage/business-profile/common.js',
);
$this->minify->js($bus_audio);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/contact_list.min.js');


// BUSINESS_CONTACT_PERSON START   
$bus_contatt_person = array(
    'webpage/business-profile/common.js',
);
$this->minify->js($bus_contatt_person);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/contactperson.min.js');

// BUSINESS_DETAILS START   
$bus_details = array(
    'webpage/business-profile/common.js',
);
$this->minify->js($bus_details);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/details.min.js');


// BUSINESS_INFO START   
$bus_info = array('webpage/business-profile/information.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_info);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/information.min.js');
// BUSINESS_INFO END 

// BUSINESS_CONTACT START   
$bus_contact = array('webpage/business-profile/contacts.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_contact);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/contacts.min.js');

// BUSINESS_EDIT_PROFILE START   
$bus_edit_profile = array('webpage/business-profile/edit_profile.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_edit_profile);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/edit_profile.min.js');

// FOLLOWERS START   
$followers = array('webpage/business-profile/followers.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($followers);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/followers.min.js');

// FOLLOWING START   
$following = array('webpage/business-profile/following.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($following);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/following.min.js');

// PDF START   
$pdf = array('webpage/business-profile/pdf.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($pdf);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/pdf.min.js');

// PHOTO START   
$photos = array('webpage/business-profile/photos.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($photos);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/photos.min.js');

// BUSINESS PROFILE MANAGE POST 
$dashboard = array('webpage/business-profile/dashboard.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($dashboard);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/dashboard.min.js');

// BUSINESS PROFILE MANAGE POST 
$profile_post = array(
    'webpage/business-profile/home.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($profile_post);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/home.min.js');

// BUSINESS RESUME MANAGE POST 
$bus_resume = array(
    'webpage/business-profile/details.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_resume);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/details.min.js');

// BUSINESS USERLIST MANAGE POST 
$bus_userlist = array(
    'webpage/business-profile/userlist.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_userlist);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/userlist.min.js');

// BUSINESS VIDEO 
$bus_video = array(
    'webpage/business-profile/videos.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_userlist);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/videos.min.js');

// BUSINESS CONTACT INFO
$contact_info = array(
    'webpage/business-profile/contact_info.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($contact_info);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/contact_info.min.js');

// BUSINESS DESCRIPTION INFO
$description = array(
    'webpage/business-profile/description.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($description);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/description.min.js');


// BUSINESS IMAGE INFO
$image = array(
    'webpage/business-profile/image.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($image);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/image.min.js');


// POSTNEWPAGE INFO
$postnewpage = array(
    'webpage/business-profile/post_detail.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($postnewpage);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/post_detail.min.js');


// RECOMMEN CANDIDATE BUSINESS
$postnewpage = array(
    'webpage/business-profile/search.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($postnewpage);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/search.min.js');

// CROPPIE START   
$croppie = array('croppie.js',
);

$this->minify->js($croppie);
echo $this->minify->deploy_js(FALSE, 'croppie.min.js');


// BUSINESS_CONTACT FOOTER CROPPI BOOTSTRAP VALIDATE  
$bus_contact_footer = array(
    '../js_min/croppie.min.js',
    'bootstrap.min.js',
    'jquery.validate.min.js',
);

$this->minify->js($bus_contact_footer);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/croppie_bootstrap_validate.min.js');

//BOOTSTARP AND VALIDATE MIN   
$bootstrap_valdidate = array(
    'bootstrap.min.js',
    'jquery.validate.min.js',
);

$this->minify->js($bootstrap_valdidate);
echo $this->minify->deploy_js(FALSE, 'bootstrap_validate.min.js');


// BUSINESS_SEARCH_LOGIN START   
$bus_search = array('webpage/business-profile/contacts.js',
    '../js_min/webpage/business-profile/common.min.js',
);

$this->minify->js($bus_search);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_search_login.min.js');

// BUSINESS_SEARCH_LOGIN HEADER START   
$bus_search_header = array('../dragdrop/js/plugins/sortable.js',
    'fileinput.js',
    '../dragdrop/themes/explorer/theme.js',
);

$this->minify->js($bus_search_header);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_search_login_header.min.js');

// BUSINESS PROFILE POST COMMON FOOTER
$bus_profile_post_common = array(
    'bootstrap.min.js',
    'jquery.form.3.51.js',
    '../dragdrop/js/plugins/sortable.js',
    'fileinput.js',
    '../dragdrop/js/locales/fr.js',
    '../dragdrop/js/locales/es.js',
    '../dragdrop/themes/explorer/theme.js',
    '../as-videoplayer/build/mediaelement-and-player.js',
    '../as-videoplayer/demo.js',
);

$this->minify->js($bus_profile_post_common);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_profile_post_common_footer.min.js');


// BUSINESS dashboard COMMON FOOTER
$bus_dashboard_common = array(
    'bootstrap.min.js',
    'jquery.validate.min.js',
    'croppie.js',
    '../dragdrop/js/plugins/sortable.js',
    'fileinput.js',
    '../dragdrop/js/locales/fr.js',
    '../dragdrop/js/locales/es.js',
    '../dragdrop/themes/explorer/theme.js',
    
);

$this->minify->js($bus_dashboard_common);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_dashboard_common_footer.min.js');

// BUSINESS EDIT PROFILE COMMON FOOTER
$bus_edit_profile_common = array(
    'bootstrap.min.js',
    'jquery.form.3.51.js',
    
);

$this->minify->js($bus_edit_profile_common);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_edit_profile_common_footer.min.js');

// BUSINESS PROFILE MANAGE POST COMMON FOOTER
$bus_profile_manage_post_common = array(
    'croppie.js',
    'bootstrap.min.js',
    'jquery.validate.min.js',
    'jquery.form.3.51.js',
    '../dragdrop/js/plugins/sortable.js',
    'fileinput.js',
    '../dragdrop/js/locales/fr.js',
    '../dragdrop/js/locales/es.js',
    '../dragdrop/themes/explorer/theme.js',
    
);

$this->minify->js($bus_profile_manage_post_common);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_profile_manage_post_common_footer.min.js');

// BUSINESS VIDEOS  COMMON FOOTER
$bus_video_common = array(
    'croppie.js',
    'bootstrap.min.js',
    'jquery.validate.min.js',
    '../as-videoplayer/build/mediaelement-and-player.js',
    '../as-videoplayer/demo.js',
   
    
);

$this->minify->js($bus_video_common);
echo $this->minify->deploy_js(FALSE, 'webpage/business-profile/bus_video_common_footer.min.js');






//$this->minify->js(array('helpers.js', 'jqModal.js'));
//echo $this->minify->deploy_js(FALSE, 'custom_js_name.min.js');
?>
<div id="container">
    <h1>Welcome to CodeIgniter Minify library!</h1>


    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>