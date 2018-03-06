<!-- start head -->
<?php
echo $head;
?>
<!--post save success pop up style strat -->
<style>
    
    .okk{
        text-align: center;
    }

    
    .pop_content .okbtn{
        position: absolute;
        transition: all 200ms;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        padding: 8px 18px;
        background-color: #0A2C5D;
        left: 170px;
        margin-top: 8px;
        width: 100px; 
        border-radius: 8px;
    }


    .pop_content .cnclbtn {
        position: absolute;
        transition: all 200ms;
        font-size: 16px;
        text-decoration: none;
        color: #fff;
        padding: 8px 18px;
        background-color: #0A2C5D;
        right: 170px;
        margin-top: 8px;
        width: 100px;
        border-radius: 8px;
    }

    .popup .pop_content {
        text-align: center;
        margin-top: 40px;

    }
    .model_ok_cancel{
        width:200px !important;
    }

</style>

<!--post save success pop up style end -->

 <?php if(IS_NOT_CSS_MINIFY == '0'){ ?>  
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
<?php }else{?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
<?php }?>


<style type="text/css" media="screen">
    #row2 { overflow: hidden; width: 100%; }
    #row2 img { height: 350px;width: 100%; }
    .upload-img{    float: right;
                    position: relative;
                    margin-top: -135px;
                    right: 50px; }

    label.cameraButton {
        display: inline-block;
        margin: 1em 0;
        cursor: pointer;
        /* Styles to make it look like a button */
        padding: 0.5em;
        border: 2px solid #666;
        border-color: #EEE #CCC #CCC #EEE;
        background-color: #DDD;
        opacity: 0.7;
    }

    /* Look like a clicked/depressed button */
    label.cameraButton:active {
        border-color: #CCC #EEE #EEE #CCC;
    }

    /* This is the part that actually hides the 'Choose file' text box for camera inputs */
    label.cameraButton input[accept*="camera"] {
        display: none;
    }




</style>
<!-- END HEAD -->
<!-- start header -->
<?php echo $header; ?>



<!-- END HEADER -->


<body   class="page-container-bg-solid page-boxed">

    <section>
        <div class="container">
            <div class="row" id="row1" style="display:none;">
                <div class="col-md-12 text-center">
                    <div id="upload-demo" style="width:100%"></div>
                </div>
                <div class="col-md-12 cover-pic" style="padding-top: 25px;text-align: center;">
                    <button class="btn btn-success  cancel-result" onclick="">Cancel</button>

                    <button class="btn btn-success set-btn upload-result " onclick="myFunction()">Upload Image</button>

                    <div id="message1" style="display:none;">
                        <div id="floatBarsG">
                            <div id="floatBarsG_1" class="floatBarsG"></div>
                            <div id="floatBarsG_2" class="floatBarsG"></div>
                            <div id="floatBarsG_3" class="floatBarsG"></div>
                            <div id="floatBarsG_4" class="floatBarsG"></div>
                            <div id="floatBarsG_5" class="floatBarsG"></div>
                            <div id="floatBarsG_6" class="floatBarsG"></div>
                            <div id="floatBarsG_7" class="floatBarsG"></div>
                            <div id="floatBarsG_8" class="floatBarsG"></div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12"  style="visibility: hidden; ">
                    <div id="upload-demo-i" style="background:#e1e1e1;width:100%;padding:30px;height:300px;margin-top:30px"></div>
                </div>
            </div>


            <div class="container">
                <div class="row" id="row2">
                    <?php
                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
                    $image = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $image_ori = $image[0]['profile_background'];
                    if ($image_ori) {
                        ?>

                        <div class="bg-images">
                            <img src="<?php echo base_url(RECBGIMAGE . $recdata[0]['profile_background']); ?>" name="image_src" id="image_src" / ></div>
                        <?php
                    } else {
                        ?>

                        <div class="bg-images">
                            <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" / ></div>
                    <?php }
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>   

<div class="container">    
    <div class="upload-img">
        <?php if ($returnpage == '') { ?>
            <label class="cameraButton"><i class="fa fa-camera" aria-hidden="true"></i>
                <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
            </label>
        <?php } ?>

    </div>
    <div class="profile-photo">
        <div class="profile-pho">

            <div class="user-pic">
                <?php if ($postdata[0]['recruiter_user_image'] != '') { ?>
                    <img src="<?php echo base_url(USERIMAGE . $postdata[0]['recruiter_user_image']); ?>" alt="" >
                <?php } else { ?>
                    <img alt="" class="img-circle" src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                <?php } ?>
                <?php if ($returnpage == ' ') { ?>
                    <a href="javascript:void(0);" onclick="updateprofilepopup();"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a>
                <?php } ?>

            </div>
        </div>


        <!-- menubar --><div class="profile-main-rec-box-menu  col-md-12 ">

            <div class="left-side-menu col-md-2">  </div>
            <div class="right-side-menu col-md-8">
                <ul class="">



                    <li <?php if ($this->uri->segment(1) == 'notification' && $this->uri->segment(2) == 'rec_profile') { ?> class="active" <?php } ?>>
                        
                            <a href="<?php echo base_url('notification/rec_profile'); ?>">Details</a>
                    
                    </li>




                    <li <?php if ($this->uri->segment(1) == 'notification' && $this->uri->segment(2) == 'rec_post') { ?> class="active" <?php } ?>>
                        
                            <a href="<?php echo base_url('notification/rec_post'); ?>">Post</a>
                       
                    </li>


                     
                </ul>
            </div>

            <div class="col-md-2">
                <div class="flw_msg_btn fr">
                    <ul>
                        <li>
                            <a href="http://35.165.1.109:81/chat/abc/4">Message</a></li>

                    </ul>
                </div>
            </div>

        </div>  
        <!-- menubar -->    
    </div>                       
    <div class="job-menu-profile1">
        <a href="javscript: void(0);" title="<?php echo $postdata[0]['rec_firstname'] . ' ' . $postdata[0]['rec_lastname']; ?>"><h5><?php echo $postdata[0]['rec_firstname'] . ' ' . $postdata[0]['rec_lastname']; ?></h5></a>
        <!-- text head start -->
        <div class="profile-text" >

            <?php
            if ($returnpage == '') {
                if ($postdata[0]['designation'] == "") {
                    ?>
                                            
                    <center><a id="designation" class="designation" title="Designation">Current Work</a></center>
                    <?php
                } else {
                    ?> 
                    <a id="designation" class="designation" title="<?php echo ucwords($postdata[0]['designation']); ?>"><?php echo ucwords($postdata[0]['designation']); ?></a>
                    <?php
                }
            } else {
                echo ucwords($postdata[0]['designation']);
            }
            ?>


        </div>
        <div  class="add-post-button">
            <?php if ($returnpage == '') { ?>
                <a class="btn btn-3 btn-3b" href="<?php echo base_url('recruiter/add_post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Add Post</a>
            <?php } ?>
        </div>
        <!-- text head end -->
    </div>
    <div class="col-md-7 col-sm-7">
        <div class="common-form">
            <div class="job-saved-box">
                <h3>Post</h3>
                <div class="contact-frnd-post">
                    <?php
                    foreach ($postdata as $post) {
                        ?>
                        <div class="job-contact-frnd ">
                            <div class="profile-job-post-detail clearfix" id="<?php echo "removepost" . $post['post_id']; ?>">
                                <!-- vishang 14-4 end -->
                                <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                        <div class="profile-job-details col-md-12">
                                            <ul>
                                                <li class="fr">
                                                    Created Date : <?php echo date('d/m/Y',strtotime($post['created_date'])); ?>
                                                </li>
                                                <li>
                                                    <a href="#" title="Post Title"  style="font-size: 19px;font-weight: 600;cursor:default;">
                                                        <?php 
                                                $post_title =  $this->db->select('name')->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                                        
                                                        echo $post_title ?> </a>     </li>
                                                <li>   
                                                    <div class="fr lction">
                                                    <?php $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name; ?>
                                                            <?php  
                                                            if($cityname)
                                                            { 
                                                            ?>
                                                            <p><i class="fa fa-map-marker" aria-hidden="true">

                                                            
                                                            </i><?php echo $cityname; ?> </p>
                                                            
                                                            <?php
                                                             }

                                                             else{}?> 
                                                    </div>
                                                    <a class="display_inline" title="Company Name" href="#"> <?php echo $post['re_comp_name']; ?> </a>
                                                </li>
                                                <li><a class="display_inline" title="Recruiter Name" href="#"> <?php echo $post['rec_firstname']; ?> </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="profile-job-profile-menu">
                                        <ul class="clearfix">
                                            <li> <b> Skills</b> <span> 
                                                <?php
                                   $comma = ", ";
                                                                        $k = 0;
                                                                        $aud = $post['post_skill'];
                                                                        $aud_res = explode(',', $aud);
                                                                        foreach ($aud_res as $skill) {
                                                                            if ($k != 0) {
                                                                                echo $comma;
                                                                            }
                                                                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                            echo $cache_time;
                                                                            $k++;
                                                                        }
                                                                        ?>     
                                                
                                                </span>
                                            </li>
                                            <li><b>Other Skill</b><span> <?php if($post['other_skill'] != ''){ echo $post['other_skill']; } else{ echo PROFILENA;} ?></span>
                                            </li>
                                            <li><b>Description</b><span><p><?php echo $post['post_description']; ?></p></span>
                                            </li>
                                            <li><b>Interview Process</b><span><?php echo $post['interview_process']; ?></span>
                                            </li>
                                            <!-- vishang 14-4 start -->
                                            <li>
                                                <b>Require Experience</b>
                                                <span>
                                                 
                                                    <p><?php if($post['min_year'] !='0' || $post['min_year'] ==''){ echo $post['min_year'] .'.'; } ?> <?php if($post['min_month'] !='0' || $post['min_month'] ==''){ echo $post['min_month']. ' year'; } ?></p>  
                                                </span>
                                            </li>
                                            <li><b>Maximum Salary</b><span><?php echo $post['min_sal']; ?></span>
                                            </li>

                                            <li><b>Minimum Salary</b><span><?php echo $post['max_sal']; ?></span>
                                            </li>

                                            <li><b>No of Position</b><span><?php echo $post['post_position']; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="profile-job-profile-button clearfix">
                                        <div class="profile-job-details col-md-12">
                                           
                                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>


                </div>


            </div>





            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


                </head>
                <body>

                    <div class="user-midd-section">
                        <div class="container">
                            <div class="row">


                                <div class="col-md-4">



                                </div>


                            </div>
                        </div>
                    </div>
                    </section>
                    <footer>

                        <?php echo $footer; ?>
                    </footer>
                    <div class="modal fade message-box" id="bidmodal-2" role="dialog">
                        <div class="modal-dialog modal-lm">
                            <div class="modal-content">
                                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                                <div class="modal-body">
                                    <span class="mes">
                                        <div id="popup-form">
                                            <?php echo form_open_multipart(base_url('recruiter/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                            <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                            <input type="hidden" name="hitext" id="hitext" value="1">
                                            <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                            <?php echo form_close(); ?>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Model Popup Open -->
                    <!-- Bid-modal  -->
                    <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
                        <div class="modal-dialog modal-lm">
                            <div class="modal-content">
                                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                                <div class="modal-body">
                                    <span class="mes"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Model Popup Close -->
                </body>

            </html>




            <!-- script for skill textbox automatic end (option 2)-->


            
            
            
            






 <?php if(IS_NOT_JS_MINIFY == '0'){ ?>  
            <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>
<?php }else{?>
             <script src="<?php echo base_url('assets/js_min/croppie.js'); ?>"></script>
<?php }?>
            <script>

                    var data = <?php echo json_encode($demo); ?>;
                  
                    $(function () {
                        $("#tags").autocomplete({
                            source: function (request, response) {
                                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                response($.grep(data, function (item) {
                                    return matcher.test(item.label);
                                }));
                            },
                            minLength: 1,
                            select: function (event, ui) {
                                event.preventDefault();
                                $("#tags").val(ui.item.label);
                                $("#selected-tag").val(ui.item.label);
                            }
                            ,
                            focus: function (event, ui) {
                                event.preventDefault();
                                $("#tags").val(ui.item.label);
                            }
                        });
                    });

            </script>

            <?php if(IS_NOT_JS_MINIFY == '0'){ ?>  
            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
            <?php }else{?>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
            <?php }?>
            <script>
                    function removepopup(id) {
                        $('.biderror .mes').html("<div class='pop_content'>Are you sure want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                        $('#bidmodal').modal('show');
                    }
                    function updateprofilepopup(id) {
                        $('#bidmodal-2').modal('show');
                    }
            </script>

            <script type="text/javascript">
                function checkvalue() {
                    var searchkeyword = document.getElementById('tags').value;
                    var searchplace = document.getElementById('searchplace').value;
                    if (searchkeyword == "" && searchplace == "") {
                        return false;
                    }
                }
            </script>




            <script>
                //select2 autocomplete start for skill
                $('#searchskills').select2({

                    placeholder: 'Find Your Skills',

                    ajax: {

                        url: "<?php echo base_url(); ?>recruiter/keyskill",
                        dataType: 'json',
                        delay: 250,

                        processResults: function (data) {

                            return {
                
                                results: data


                            };

                        },
                        cache: true
                    }
                });
                //select2 autocomplete End for skill

                //select2 autocomplete start for Location
                $('#searchplace').select2({

                    placeholder: 'Find Your Location',
                    maximumSelectionLength: 1,
                    ajax: {

                        url: "<?php echo base_url(); ?>recruiter/location",
                        dataType: 'json',
                        delay: 250,

                        processResults: function (data) {

                            return {
                            
                                results: data


                            };

                        },
                        cache: true
                    }
                });
                //select2 autocomplete End for Location

            </script>
            <script>
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function () {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>

            <!-- cover image start -->
            <script>
                function myFunction() {
                    // alert("hhhjhj");
                    document.getElementById("upload-demo").style.visibility = "hidden";
                    document.getElementById("upload-demo-i").style.visibility = "hidden";
                    document.getElementById('message1').style.display = "block";

                }


                function showDiv() {
                    document.getElementById('row1').style.display = "block";
                    document.getElementById('row2').style.display = "none";
                }
            </script>

            <script type="text/javascript">
                $uploadCrop = $('#upload-demo').croppie({
                    enableExif: true,
                    viewport: {
                        width: 1250,
                        height: 350,
                        type: 'square'
                    },
                    boundary: {
                        width: 1250,
                        height: 350
                    }
                });


                $('.upload-result').on('click', function (ev) {
                    $uploadCrop.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function (resp) {

                        $.ajax({
                            url: "<?php echo base_url() ?>recruiter/ajaxpro",
                            type: "POST",
                            data: {"image": resp},
                            success: function (data) {
                                html = '<img src="' + resp + '" />';
                                if (html) {
                                    window.location.reload();
                                }
                            }
                        });

                    });
                });

                $('.cancel-result').on('click', function (ev) {

                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";


                });

                //aarati code start
                $('#upload').on('change', function () {
            
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        }).then(function () {
                            console.log('jQuery bind complete');
                        });

                    }
                    reader.readAsDataURL(this.files[0]);



                });

                $('#upload').on('change', function () {

                    var fd = new FormData();
                    fd.append("image", $("#upload")[0].files[0]);

                    files = this.files;
                    size = files[0].size;



                    if (size > 4194304)
                    {
                        alert("Allowed file size exceeded. (Max. 4 MB)")

                        document.getElementById('row1').style.display = "none";
                        document.getElementById('row2').style.display = "block";

                        return false;
                    }


                    $.ajax({

                        url: "<?php echo base_url(); ?>recruiter/image",
                        type: "POST",
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function (response) {

                        }
                    });
                });

                //aarati code end
            </script>
            <!-- cover image end -->
            <!-- remove post start -->

            <script type="text/javascript">
                function remove_post(abc)
                {


                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "recruiter/remove_post" ?>',
                        data: 'post_id=' + abc,
                        success: function (data) {

                            $('#' + 'removepost' + abc).html(data);
                            $('#' + 'removepost' + abc).parent().removeClass();
                            var numItems = $('.contact-frnd-post .job-contact-frnd').length;

                            if (numItems == '0') {
                                var nodataHtml = "<div class='text-center rio'><h4 class='page-heading  product-listing' style='border:0px;margin-bottom: 11px;'>No Job Post.</h4></div>";
                                $('.contact-frnd-post').html(nodataHtml);
                            }




                        }
                    });




                }
            </script>

            <script>
                function divClicked() {
                    var divHtml = $(this).html();
                    var editableText = $("<textarea/>");
                    editableText.val(divHtml);
                    $(this).replaceWith(editableText);
                    editableText.focus();
                    // setup the blur event for this new textarea
                    editableText.blur(editableTextBlurred);
                }

                function editableTextBlurred() {
                    var html = $(this).val();
                    var viewableText = $("<a>");
                    viewableText.html(html);
                    $(this).replaceWith(viewableText);
                    // setup the click event for this new div
                    viewableText.click(divClicked);

                    $.ajax({
                        url: "<?php echo base_url(); ?>recruiter/ajax_designation",
                        type: "POST",
                        data: {"designation": html},
                        success: function (response) {

                        }
                    });
                }

                $(document).ready(function () {
                    $("a.designation").click(divClicked);
                });
            </script>
