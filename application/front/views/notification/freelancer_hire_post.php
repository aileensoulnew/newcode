<!DOCTYPE html>
<html>
<?php echo $head; ?>

<?php if (IS_NOT_CSS_MINIFY == '0') { ?>  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">

<?php } else { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">

<?php } ?>

<?php
$select_data = 'profile_background,username,fullname,freelancer_hire_user_image,profile_background,profile_background_main,designation,freelancer_hire_slug,free_hire_step';
$freehiredata = $this->freelancer_hire_model->getfreelancerhiredata($freelancerpostdata[0]['user_id'], $select_data);
?>

<body   class="page-container-bg-solid page-boxed ">
    <?php echo $header; ?>
    <?php echo $freelancer_post_header2_border; ?>
    <section>

        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container padding-360">
                <div class="row4">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                        <div class="">
                            <div class="full-box-module">   
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover"> 
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                           <?php if ($this->session->userdata('aileenuser') == $freelancerpostdata[0]['user_id']) { ?> href="<?php echo base_url('freelance-hire/employer-details'); ?>" <?php } else { ?> href="<?php echo base_url('freelance-hire/employer-details/' . $freehiredata['freelancer_hire_slug']); ?>" <?php } ?>  tabindex="-1" aria-hidden="true" rel="noopener" 
                                           title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>">

                                            <?php if ($freehiredata['profile_background'] != '') { ?>
                                                <div class="data_img">
                                                    <img src="<?php echo FREE_HIRE_BG_THUMB_UPLOAD_URL . $freehiredata['profile_background']; ?>" class="bgImage" alt="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>" >
                                                </div>
                                            <?php } else { ?>
                                                <div class="data_img bg-images no-cover-upload">
                                                    <img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage">
                                                </div>
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="left_side_box_img buisness-profile-txext">

                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" <?php if ($this->session->userdata('aileenuser') == $freelancerpostdata[0]['user_id']) { ?> href="<?php echo base_url('freelance-hire/employer-details'); ?>" <?php } else { ?> href="<?php echo base_url('freelance-hire/employer-details/' . $freehiredata['freelancer_hire_slug']); ?>" <?php } ?>  tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>">
                                                <?php
                                                $fname = $freehiredata['fullname'];
                                                $lname = $freehiredata['username'];
                                                $sub_fname = substr($fname, 0, 1);
                                                $sub_lname = substr($lname, 0, 1);

                                                if ($freehiredata['freelancer_hire_user_image']) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freehiredata['freelancer_hire_user_image'])) {
                                                            ?>
                                                            <div class="post-img-profile">
                                                                <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                            </div>
                                                        <?php } else {
                                                            ?>
                                                            <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freehiredata['freelancer_hire_user_image']; ?>" alt="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>" > 
                                                            <?php
                                                        }
                                                    } else {
                                                        $filename = $this->config->item('free_hire_profile_main_upload_path') . $freehiredata['freelancer_hire_user_image'];
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info) {
                                                            ?>
                                                            <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freehiredata['freelancer_hire_user_image']; ?>" alt="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>" >
                                                        <?php } else {
                                                            ?>
                                                            <div class="post-img-profile">
                                                                <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                            </div> 
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="post-img-profile">
                                                        <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="right_left_box_design ">
                                            <span class="profile-company-name ">
                                                <a <?php if ($this->session->userdata('aileenuser') == $freelancerpostdata[0]['user_id']) { ?> href="<?php echo base_url('freelance-hire/employer-details'); ?>" <?php } else { ?> href="<?php echo base_url('freelance-hire/employer-details/' . $freehiredata['freelancer_hire_slug']); ?>" <?php } ?> title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>"> <?php echo ucwords($freehiredata['fullname']) . ' ' . ucwords($freehiredata['username']); ?></a>  
                                            </span>
                                            <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                            <div class="profile-boxProfile-name">
                                                <a <?php if ($this->session->userdata('aileenuser') == $freelancerpostdata[0]['user_id']) { ?> href="<?php echo base_url('freelance-hire/employer-details'); ?>" <?php } else { ?> href="<?php echo base_url('freelance-hire/employer-details/' . $freehiredata['freelancer_hire_slug']); ?>" <?php } ?> title="<?php echo $freehiredata['fullname'] . " " . $freehiredata['username']; ?>"><?php
                                                    if ($freehiredata['designation']) {
                                                        echo $freehiredata['designation'];
                                                    } else {
                                                        echo "Designation";
                                                    }
                                                    ?></a>
                                            </div>
                                            <ul class=" left_box_menubar">
                                                <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>><a title="Employer Details"  class="padding_less_left" <?php if ($this->session->userdata('aileenuser') == $freelancerpostdata[0]['user_id']) { ?> href="<?php echo base_url('freelance-hire/employer-details'); ?>" <?php } else { ?> href="<?php echo base_url('freelance-hire/employer-details/' . $freehiredata['freelancer_hire_slug']); ?>" <?php } ?>><?php echo $this->lang->line("details"); ?></a></li>
                                                <li><a title="Projects" <?php if ($this->session->userdata('aileenuser') == $freelancerpostdata[0]['user_id']) { ?> href="<?php echo base_url('freelance-hire/projects'); ?>" <?php } else { ?> href="<?php echo base_url('freelance-hire/projects/' . $freehiredata['freelancer_hire_slug']); ?>" <?php } ?>><?php echo $this->lang->line("Projects"); ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>                             
                            </div>


                            <?php echo $left_footer; ?>

                        </div>

                    </div>

                    <?php
                    if (count($freelancerpostdata) > 0) {
                        foreach ($freelancerpostdata as $post) {
                            ?>
                            <div class="inner-right-part">
                                <div class="page-title">
                                    <h3>
                                        <?php
                                        echo $freelancerpostdata[0]['post_name'];
                                        ?>
                                    </h3>
                                </div>
                                <div class="all-job-box job-detail">
                                    <div class="all-job-top">
                                        <div class="job-top-detail">
                                            <h5><a href="javascript:void(0);"><?php echo $post['post_name']; ?></a></h5>

                                            <?php
                                            $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                                            $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                                            $slug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->freelancer_hire_slug;
                                            ?>
                                            <p>

                                                <a href="<?php echo base_url('freelance-hire/employer-details/' . $slug); ?>"><?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?></a>

                                                </a></p>
                                            <p class="loca-exp">
                                                <span class="location">
                                                    <?php $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city; ?>
                                                    <?php $country = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country; ?>

                                                    <?php
                                                    $cityname = $this->db->get_where('cities', array('city_id' => $city))->row()->city_name;
                                                    $countryname = $this->db->get_where('countries', array('country_id' => $country))->row()->country_name;
                                                    ?>
                                                    <span>

                                                        <?php
                                                        if ($cityname || $countryname) {
                                                            if ($cityname) {
                                                                echo $cityname . ', ';
                                                            }
                                                            echo $countryname . " (Location)";
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="loca-exp">
                                                <span class="exp">
                                                    <span>

                                                        <?php
                                                        if ($post['post_exp_month'] || $post['post_exp_year']) {
                                                            if ($post['post_exp_year']) {
                                                                echo $post['post_exp_year'];
                                                            }
                                                            if ($post['post_exp_month']) {
                                                                if ($post['post_exp_year'] == '' || $post['post_exp_year'] == '0') {
                                                                    echo 0;
                                                                }
                                                                echo ".";
                                                                echo $post['post_exp_month'];
                                                            }
                                                            echo " Year" . " (Required Experience)";
                                                        }
                                                        ?> 
                                                    </span>
                                                </span>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="detail-discription">
                                        <div class="all-job-middle">
                                            <ul>
                                                <li>
                                                    <b>Project description</b>
                                                    <span>
                                                        <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                    </span>
                                                </li>
                                                <li>
                                                    <b>Key skill</b>
                                                    <span>  <?php
                                                        $comma = " , ";
                                                        $k = 0;
                                                        $aud = $post['post_skill'];
                                                        $aud_res = explode(',', $aud);

                                                        if (!$post['post_skill']) {

                                                            echo $post['post_other_skill'];
                                                        } else if (!$post['post_other_skill']) {
                                                            foreach ($aud_res as $skill) {
                                                                if ($k != 0) {
                                                                    echo $comma;
                                                                }
                                                                $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                echo $cache_time;
                                                                $k++;
                                                            }
                                                        } else if ($post['post_skill'] && $post['post_other_skill']) {

                                                            foreach ($aud_res as $skill) {
                                                                if ($k != 0) {
                                                                    echo $comma;
                                                                }
                                                                $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                echo $cache_time;
                                                                $k++;
                                                            } echo "," . $post['post_other_skill'];
                                                        }
                                                        ?>     

                                                    </span>
                                                </li>
                                                <li><b>Field of Requirements</b>
                                                    <span> 
                                                        <?php echo $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name; ?>
                                                    </span>
                                                </li>
                                                <li><b>Rate</b>
                                                    <span>  <?php
                                                        if ($post['post_rate']) {
                                                            echo $post['post_rate'];
                                                            echo "&nbsp";
                                                            echo $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                            echo "&nbsp";
                                                            if ($post['post_rating_type'] == 0) {
                                                                echo "Hourly";
                                                            } else {
                                                                echo "Fixed";
                                                            }
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?>
                                                    </span>
                                                </li>

                                                <li><b>Estimated Time</b>
                                                    <span>
                                                        <?php
                                                        if ($post['post_est_time']) {
                                                            echo $post['post_est_time'];
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?>   
                                                    </span>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="all-job-bottom">
                                            <span class="job-post-date"><b>Posted on:  </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                     <div class="inner-right-part cust-border">
                        <div class="art-img-nn">
                            <div class="art_no_post_img">
                                <img src="<?php echo base_url('assets/img/job-no.png'); ?>">

                            </div>
                            <div class="art_no_post_text">
                                No  Project Available.
                            </div>
                        </div>
                     </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </section>
    <?php echo $login_footer ?>
    <?php echo $footer; ?>
</body>
</html>
<script>
    var base_url = '<?php echo base_url(); ?>';
    //SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $(".skill_keyword").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "freelancer/freelancer_apply_search_keyword", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
});

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END


//SCRIPT FOR CITY AUTOFILL OF SEARCH START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $(".skill_place").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "freelancer/freelancer_search_city", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
});

//SCRIPT FOR CITY AUTOFILL OF SEARCH END

//CHECK SEARCH KEYWORD AND LOCATION BLANK START
function checkvalue() {
  
    var searchkeyword1 = $.trim(document.getElementById('tags').value);

    //  var searchkeyword = searchkeyword.replace(' ', '-');
    // var searchkeyword = searchkeyword.replace(/[^' ']/g, '-');
    var searchkeyword = searchkeyword1.replace(/\s/g, '-');
    var searchkeyword = searchkeyword.replace(/[^a-zA-Z0-9\-]/g, '');
    var searchkeyword = searchkeyword.replace(/-+/g, "-");

    var searchplace1 = $.trim(document.getElementById('searchplace').value);
    var searchplace = searchplace1.replace(' ', '-');
    var searchplace = searchplace.replace(/[^a-zA-Z0-9\-]/g, '');

    

    if (searchkeyword == "" && searchplace == "") {
     
        return false;
    } else {
       
        if (searchkeyword == "") {
            window.location = base_url + 'project-in-' + searchplace;
            return false;
        } else if (searchplace == "") {
            if (searchkeyword == 'projects') {
                window.location = base_url + 'projects';
            } else {

                $.ajax({
                    type: 'POST',
                    url: base_url + "freelancer/session",
                    data: 'keyword=' + encodeURIComponent(searchkeyword1) ,
                    success: function (data) {
                       window.location = base_url + searchkeyword + '-project';
                    }
                });
              //  window.location = base_url + searchkeyword + '-project';
            }
            return false;
        } else {
             $.ajax({
                    type: 'POST',
                    url: base_url + "freelancer/session",
                    data: 'keyword=' + encodeURIComponent(searchkeyword1) + '&keyword1=' + encodeURIComponent(searchplace1) ,
                    success: function (data) {
                       window.location = base_url + searchkeyword + '-project-in-' + searchplace;
                    }
                });
            
            return false;
        }
    }
}
</script>
