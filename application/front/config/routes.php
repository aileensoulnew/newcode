<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


/* product Login end */
//$route['login'] = 'Login/index';

$route['default_controller'] = 'main';
//$route['default_controller'] = 'user_post';

$route['basic-information'] = 'user_info';
$route['educational-information'] = 'user_info';

$route['dashboard/logout'] = 'dashboard/logout';
$route['dashboard/image'] = 'dashboard/image';
$route['dashboard/photos/(:any)'] = 'Userprofile';
$route['dashboard/(:any)'] = 'Userprofile';
$route['profiles/(:any)'] = 'Userprofile';
$route['details/(:any)'] = 'Userprofile';
$route['followers/(:any)'] = 'Userprofile';
$route['following/(:any)'] = 'Userprofile';
$route['contacts/(:any)'] = 'Userprofile';
$route['questions/(:any)'] = 'Userprofile';
$route['searchh'] = 'user_post/search';

$route['userprofile_page'] = 'userprofile_page';
$route['userprofile_page/(:any)'] = 'userprofile_page/$1';

$route['opportunities'] = 'user_post';
$route['contact-request'] = 'userprofile_page/contact_request';

$route['questions/(:any)/(:any)'] = 'userprofile_page/question_detail/$1/$2';

//$route['default_controller'] = 'under_construction';


$route['404_override'] = 'My404Page';
//$route['translate_uri_dashes'] = FALSE;


$route['about-us'] = "about_us";
$route['disclaimer-policy'] = "Disclaimer";
$route['contact-us'] = "contact_us";
$route['terms-and-condition'] = "main/terms_condition";
$route['privacy-policy'] = "main/privacy_policy";
$route['advertise-with-us'] = "advertise_with_us";


$route['sitemap/job-profile'] = "sitemap/job_profile";
$route['sitemap/recruiter-profile'] = "sitemap/recruiter_profile";
$route['sitemap/freelance-profile'] = "sitemap/freelance_profile";
$route['sitemap/business-profile'] = "sitemap/business_profile";
$route['sitemap/artistic-profile'] = "sitemap/artistic_profile";

$route['load_more/dataaaaa'] = "load_more/dataaaaa";


$route['profile'] = "profile";
$route['profiles'] = "dashboard";
$route['profiles/basic-information/(:any)'] = "user_basic_info";
$route['profiles/opportunities/(:any)'] = "user_opportunities";
//$route['profiles/(:any)'] = "dashboard";


//$route['business-profile'] = "business_profile/index";
$route['business-profile'] = "business_live/index";
$route['business-profile/category'] = "business_live/category";
$route['business-profile/category/(:any)'] = "business_live/categoryBusinessList/$1";
$route['business-profile/search'] = "business_live/business_search";


$route['business-profile/reactivate'] = "business_profile/reactivate";

//$route['business-profile/business-information'] = "business_profile/business_information";
//$route['business-profile/business-information-insert'] = "business_profile/business_information_insert";
//$route['business-profile/business-information-update'] = "business_profile/business_information_update";
//$route['business-profile/business-information-edit'] = "business_profile/business_information_update";
//$route['business-profile/contact-information'] = "business_profile/contact_information";
//$route['business-profile/contact-information-insert'] = "business_profile/contact_information_insert";
//$route['business-profile/description'] = "business_profile/description";
//$route['business-profile/description-insert'] = "business_profile/description_insert";
//$route['business-profile/image'] = "business_profile/image";
$route['business-profile/image-insert'] = "business_profile/image_insert";
$route['business-profile/details/(:any)'] = "business_profile/business_resume/$1";
$route['business-profile/details'] = "business_profile/business_resume";
$route['business-profile/home'] = "business_profile/business_profile_post";
$route['business-profile/bussiness-profile-post-add'] = "business_profile/business_profile_addpost_insert";
$route['business-profile/bussiness-profile-post-add/manage/(:any)'] = "business_profile/business_profile_addpost_insert/manage/$1";
$route['business-profile/dashboard'] = "business_profile/business_profile_manage_post";
$route['business-profile/dashboard/(:any)'] = "business_profile/business_profile_manage_post/$1";
$route['business-profile/followers'] = "business_profile/followers";
$route['business-profile/followers/(:any)'] = "business_profile/followers/$1";
$route['business-profile/following'] = "business_profile/following";
$route['business-profile/following/(:any)'] = "business_profile/following/$1";
$route['business-profile/userlist'] = "business_profile/userlist";
$route['business-profile/userlist/(:any)'] = "business_profile/userlist/$1";
$route['business-profile/contact-list'] = "business_profile/contact_list";
$route['business-profile/contacts'] = "business_profile/bus_contact";
$route['business-profile/contacts/(:any)'] = "business_profile/bus_contact/$1";
$route['business-profile/user-image-change'] = "business_profile/user_image_insert";
$route['business-profile/business-profile-save-post'] = "business_profile/business_profile_save_post";
$route['business-profile/business-profile-addpost'] = "business_profile/business_profile_addpost";
$route['business-profile/photos'] = "business_profile/business_photos";
$route['business-profile/photos/(:any)'] = "business_profile/business_photos/$1";
$route['business-profile/videos'] = "business_profile/business_videos";
$route['business-profile/videos/(:any)'] = "business_profile/business_videos/$1";
$route['business-profile/audios'] = "business_profile/business_audios";
$route['business-profile/audios/(:any)'] = "business_profile/business_audios/$1";
$route['business-profile/pdf'] = "business_profile/business_pdf";
$route['business-profile/pdf/(:any)'] = "business_profile/business_pdf/$1";
$route['business-profile/business-profile-contactperson'] = "business_profile/business_profile_contactperson";
$route['business-profile/contact-person/(:any)'] = "business_profile/business_profile_contactperson/$1";
$route['business-profile/post-detail'] = "business_profile/postnewpage";
$route['business-profile/post-detail/(:any)/(:any)'] = "business_profile/postnewpage/$1/$2";
$route['business-profile/creat-pdf'] = "business_profile/creat_pdf";
$route['business-profile/business-profile-editpost'] = "business_profile/business_profile_editpost";
$route['notification/business-profile-post/(:any)'] = "notification/business_post/$1";
$route['notification/business-profile-post-detail/(:any)/(:any)'] = "notification/bus_post_img/$1/$2";


//$route['business-profile/signup/business-information'] = "business_profile_registration/business_information";
//$route['business-profile/signup/contact-information'] = "business_profile_registration/contact_information";
//$route['business-profile/signup/description'] = "business_profile_registration/description";
//$route['business-profile/signup/image'] = "business_profile_registration/image";

$route['business-profile/registration/business-information'] = "business_profile_registration/business_registration/$1";
$route['business-profile/registration/contact-information'] = "business_profile_registration/business_registration/$1";
$route['business-profile/registration/description'] = "business_profile_registration/business_registration/$1";
$route['business-profile/registration/image'] = "business_profile_registration/business_registration/$1";

$route['business-profile/signup/edit/business-information'] = "business_profile_registration/business_information_edit";
$route['business-profile/signup/edit/contact-information'] = "business_profile_registration/contact_informatio_edit";
$route['business-profile/signup/edit/description'] = "business_profile_registration/description_edit";
$route['business-profile/signup/edit/image'] = "business_profile_registration/image_edit";
//$route['business-profile/signup/business-registration'] = "business_profile_registration/business_registration";

$route['message/b/(:any)'] = "message/business_profile/$1";
$route['message/rj/(:any)'] = "recmessage/recjob/$1";

$route['freelance'] = "freelancer";


//FREELANCER HIRE ROUTES SETTINGS
$route['freelance-hire'] = "freelancer_hire/freelancer_hire";
$route['freelance-hire/home'] = "freelancer_hire/recommen_candidate";
$route['freelance-hire/employer-details'] = "freelancer_hire/freelancer_hire_profile";
$route['freelance-hire/employer-details/(:any)'] = "freelancer_hire/freelancer_hire_profile/$1";
$route['freelance-hire/projects'] = "freelancer_hire/freelancer_hire_post";
$route['freelance-hire/projects/(:any)'] = "freelancer_hire/freelancer_hire_post/$1";
$route['freelance-hire/freelancer-save'] = "freelancer_hire/freelancer_save";
$route['freelance-hire/add-projects'] = "freelancer_hire/freelancer_add_post";
$route['freelance-hire/basic-information'] = "freelancer_hire/freelancer_hire_basic_info";
$route['freelance-hire/address-information'] = "freelancer_hire/freelancer_hire_address_info";
$route['freelance-hire/professional-information'] = "freelancer_hire/freelancer_hire_professional_info";
$route['freelance-hire/search'] = "search/freelancer_hire_search";
$route['freelance-hire/search/0/(:any)'] = "search/freelancer_hire_search/0/$1";
$route['freelance-hire/search/(:any)/0'] = "search/freelancer_hire_search/$1/0";
$route['freelance-hire/search/(:any)/(:any)'] = "search/freelancer_hire_search/$1/$2";
$route['freelance-hire/edit-projects/(:any)'] = "freelancer_hire/freelancer_edit_post/$1";
$route['freelance-hire/reactivate'] = "freelancer_hire/reactivate";
$route['freelance-hire/deactivate'] = "freelancer_hire/deactivate_hire";
$route['freelance-hire/freelancer-applied/(:any)'] = "freelancer_hire/freelancer_apply_list/$1";
$route['notification/freelance-hire/(:any)'] = "notification/freelancer_hire_post/$1";
$route['freelance-hire/project'] = "freelancer_hire/live_post";
$route['freelance-hire/project/(:any)'] = "freelancer_hire/live_post/$1";
$route['freelance-hire/freelancer-shortlisted/(:any)'] = "freelancer_hire/freelancer_shortlist_list/$1";
$route['freelance-hire/registration'] = "freelancer_hire/hire_registation";
$route['freelance-hire/registration/live-post'] = "freelancer_hire/hire_registation";
//$route['freelance-hire'] = "freelancer_hire/freelancer_hire/freelancer_hire_basic_info";



//FREELANCER APPLY ROUTES SETTINGS
$route['freelance-work/home'] = "freelancer/freelancer_apply_post";
$route['freelance-work/home/live-post'] = "freelancer/freelancer_apply_post/$1";
$route['freelance-work/freelancer-details/(:any)'] = "freelancer/freelancer_post_profile/$1";
$route['freelance-work/freelancer-details'] = "freelancer/freelancer_post_profile";
$route['freelance-work/saved-projects'] = "freelancer/freelancer_save_post";
$route['freelance-work/applied-projects'] = "freelancer/freelancer_applied_post";
$route['freelance-work/basic-information'] = "freelancer/freelancer_post_basic_information";
$route['freelance-work/address-information'] = "freelancer/freelancer_post_address_information";
$route['freelance-work/address-information/(:any)'] = "freelancer/freelancer_post_address_information/$1";
$route['freelance-work/professional-information'] = "freelancer/freelancer_post_professional_information";
$route['freelance-work/professional-information/(:any)'] = "freelancer/freelancer_post_professional_information/$1";
$route['freelance-work/rate'] = "freelancer/freelancer_post_rate";
$route['freelance-work/rate/(:any)'] = "freelancer/freelancer_post_rate/$1";
$route['freelance-work/avability'] = "freelancer/freelancer_post_avability";
$route['freelance-work/avability/(:any)'] = "freelancer/freelancer_post_avability/$1";
$route['freelance-work/education'] = "freelancer/freelancer_post_education";
$route['freelance-work/education/(:any)'] = "freelancer/freelancer_post_education/$1";
$route['freelance-work/portfolio'] = "freelancer/freelancer_post_portfolio";
$route['freelance-work/portfolio/(:any)'] = "freelancer/freelancer_post_portfolio/$1";
$route['freelance-work/search'] = "search/freelancer_post_search";
$route['freelance-work/deactivate'] = "freelancer/deactivate";
$route['freelance-work/reactivate'] = "freelancer/reactivate";
$route['freelance-work/registration'] = "freelancer/registation";
$route['freelance-work'] = "freelancer/freelancer_post/freelancer_post_basic_information";


 $route['projects'] = "search/freelancer_post_search";
 $route['projects/(:any)'] = "search/freelancer_post_search/$1";

$route['(:any)-project'] = "search/freelancer_post_search";
$route['project-in-(:any)'] = "search/freelancer_post_search";
$route['(:any)-project-in-(:any)'] = "search/freelancer_post_search";

$route['freelance-work'] = "freelancer/freelancer_post";
//$route['freelance-work/home/'] = "freelancer/freelancer_apply_post";
//$route['freelance-work/home/live-post'] = "freelancer/freelancer_apply_post";
//$route['freelance-work/home/live-post/(:any)'] = "freelancer/freelancer_apply_post/$1";

//$route['freelance-work/profile'] = "freelancer/freelancer_apply_reg";
$route['freelance-work/profile/live-post'] = "freelancer/registation";
$route['freelance-work/profile/live-post/(:any)'] = "freelancer/registation/$1";

$route['freelance-work'] = "freelancer_apply_live/index";
$route['freelance-work/category'] = "freelancer_apply_live/category";
$route['freelance-work/category/(:any)'] = "freelancer_apply_live/categoryFreelancerList/$1";

/* Report Route end */



//ARTISTIC ROUTES SETTINGS


//$route['artist'] = "artist/index";
$route['find-artist'] = "artist_live/index";
$route['artist/registration'] = "artist_live/registration";
$route['artist/ajax_data'] = "artist_live/ajax_data";
// $route['artist'] = "artist_live/index";
$route['artist/category'] = "artist_live/category";
$route['artist/(:any)'] = "artist_live/categoryArtistList/$1";
$route['artist/search'] = "artist_live/artist_search";


$route['artist/artistic-basic-information-insert'] = "artist/art_basic_information_insert";
$route['artist/artistic-information-update'] = "artist/art_basic_information_update";

$route['artist/artistic-address'] = "artist/art_address";
$route['artist/artistic-address-insert'] = "artist/art_address_insert";

$route['artist/artistic-information'] = "artist/art_information";
$route['artist/artistic-information-insert'] = "artist/art_information_insert";

$route['artist/artistic-portfolio'] = "artist/art_portfolio";
$route['artist/artistic-portfolio-insert'] = "artist/art_portfolio_insert";

$route['artist/home'] = "artist/art_post";
$route['artist/dashboard'] = "artist/art_manage_post";
$route['artist/dashboard/(:any)'] = "artist/art_manage_post/$1";


$route['artist/details/(:any)'] = "artist/artistic_profile/$1";
$route['artist/details'] = "artist/artistic_profile";

$route['artist/photos'] = "artist/art_photos";
$route['artist/photos/(:any)'] = "artist/art_photos/$1";

$route['artist/videos'] = "artist/art_videos";
$route['artist/videos/(:any)'] = "artist/art_videos/$1";

$route['artist/audios'] = "artist/art_audios";
$route['artist/audios/(:any)'] = "artist/art_audios/$1";


$route['artist/pdf'] = "artist/art_pdf";
$route['artist/pdf/(:any)'] = "artist/art_pdf/$1";

$route['artist/post-detail'] = "artist/postnewpage";
$route['artist/post-detail/(:any)'] = "artist/postnewpage/$1";

$route['artist/creat-pdf'] = "artist/creat_pdf";

//BLOG ROUTES SETTINGS
//$route['blog/popular'] = "blog/popular";
//$route['blog/read_more'] = "blog/read_more";
$route['blog/blog_ajax'] = "blog/blog_ajax";
$route['blog/cat_ajax'] = "blog/cat_ajax";
$route['blog/comment_insert'] = "blog/comment_insert";
//$route['blog/tag/(:any)'] = "blog/tagsearch/$1";
//$route['blog/page/(:any)'] = "blog/index/$1";
$route['blog/(:any)'] = "blog/index/$1";

//JOB ROUTES SETTINGS

$route['job'] = "job_live/index";
$route['job/category/(:any)'] = "job_live/category/$1";
$route['job/city/(:any)'] = "job_live/city/$1";
$route['job/skill/(:any)'] = "job_live/skill/$1";
$route['job/company/(:any)'] = "job_live/company/$1";
$route['job/search'] = "job_live/job_search";

$route['recruiter'] = "recruiter_live/index";
$route['recruiter/category/(:any)'] = "recruiter_live/category/$1";
$route['recruiter/city/(:any)'] = "recruiter_live/city/$1";
$route['recruiter/skill/(:any)'] = "recruiter_live/skill/$1";
$route['recruiter/company/(:any)'] = "recruiter_live/company/$1";
$route['recruiter/search'] = "recruiter_live/job_search";


$route['job/home'] = "job/job_all_post";
$route['job/home/live-post'] = "job/job_all_post/$1";

$route['job/resume'] = "job/job_printpreview";
$route['job/resume/(:any)'] = "job/job_printpreview/$1";

$route['job/saved-job'] = "job/job_save_post";
$route['job/applied-job'] = "job/job_applied_post";
$route['job/basic-information'] = "job/job_basicinfo_update";

$route['job/qualification'] = "job/job_education_update";
$route['job/qualification/(:any)'] = "job/job_education_update/$1";

$route['job/project'] = "job/job_project_update";
$route['job/work-area'] = "job/job_skill_update";
$route['job/work-experience'] = "job/job_work_exp_update";

$route['job/registration'] = "job/job_reg";
$route['job/registration/live-post'] = "job/job_reg";
$route['job/registration/live-post/(:any)'] = "job/job_reg/$1";
//$route['job/search'] = "job/job_search";
 $route['jobs'] = "job/job_search";
 $route['jobs/(:any)'] = "job/job_search/$1";
//$route['(:any)'] = "job/job_search";
$route['(:any)-jobs'] = "job/job_search";
$route['jobs-in-(:any)'] = "job/job_search";
$route['(:any)-jobs-in-(:any)'] = "job/job_search";

$route['job/post-(:any)/(:any)'] = "job/post/$1/$2";
$route['job/recruiter-profile/(:any)'] = "job/rec_profile/$1";


//RECRUITER ROUTES SETTINGS

$route['recruiter/registration'] = "recruiter/rec_reg";
$route['recruiter/registration/live-post'] = "recruiter/rec_reg";

$route['recruiter/basic-information'] = "recruiter/rec_basic_information";
$route['recruiter/company-information'] = "recruiter/company_info_form";

$route['recruiter/home'] = "recruiter/recommen_candidate";
//$route['recruiter/add-post-live'] = "recruiter/add_post_login";


$route['recruiter/profile'] = "recruiter/rec_profile";
$route['recruiter/profile/(:any)'] = "recruiter/rec_profile/$1";

$route['recruiter/save-candidate'] = "recruiter/save_candidate";
$route['recruiter/save-candidate/(:any)'] = "recruiter/save_candidate/$1";

$route['recruiter/post'] = "recruiter/rec_post";
$route['recruiter/post/(:any)'] = "recruiter/rec_post/$1";

$route['recruiter/jobpost'] = "recruiter/live_post";
$route['recruiter/jobpost/(:any)'] = "recruiter/live_post/$1";

$route['recruiter/add-post'] = "recruiter/add_post";

$route['recruiter/post-insert'] = "recruiter/add_post";

$route['recruiter/edit-post'] = "recruiter/edit_post";
$route['recruiter/edit-post/(:any)'] = "recruiter/edit_post/$1";
$route['recruiter/apply-list/(:any)'] = "recruiter/view_apply_list/$1";

$route['recruiter/search'] = "recruiter/recruiter_search";


// NOTIFICATION ROUTES SETTINGS
$route['notification/details/(:any)'] = "business_profile/business_resume/$1";
$route['notification/business-post/(:any)'] = "business_profile/edit_post/$1";

$route['notification/art-post/(:any)'] = "notification/art_post/$1";


$route['how-to-use-job-profile-in-aileensoul'] = "introduction/job_profile";
$route['how-to-use-recruiter-profile-in-aileensoul'] = "introduction/recruiter_profile";
$route['how-to-use-freelance-profile-in-aileensoul'] = "introduction/freelance_profile";
$route['how-to-use-business-profile-in-aileensoul'] = "introduction/business_profile";
$route['how-to-use-artistic-profile-in-aileensoul'] = "introduction/artistic_profile";

$route['artist/pdf-view/(:any)'] = "artist/pdf_display/$1";
$route['business-profile/pdf-view/(:any)'] = "business_profile/pdf_display/$1";

$route['(:any)/contacts'] = 'Userprofile';
$route['(:any)/following'] = 'Userprofile';
$route['(:any)/followers'] = 'Userprofile';
$route['(:any)/details'] = 'Userprofile';
$route['(:any)/questions'] = 'Userprofile';
$route['(:any)/profiles'] = 'Userprofile';
$route['(:any)/photos'] = 'Userprofile';
$route['(:any)/videos'] = 'Userprofile';
$route['(:any)/audios'] = 'Userprofile';
$route['(:any)/pdf'] = 'Userprofile';
$route['(:any)/article'] = 'Userprofile';
$route['(:any)'] = 'Userprofile';