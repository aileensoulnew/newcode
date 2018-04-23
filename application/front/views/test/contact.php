
<script type="text/javascript" src="<?php echo base_url('dynamic/js/jquery.ba-hashchange.min.js'); ?>"></script>
         <script type="text/javascript" src="<?php echo base_url('dynamic/js/dynamicpage.js'); ?>"></script>
    

<?php
//$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
//if ($pageWasRefreshed) {
    echo $test_header;
//}
?>                      
<!--- middle section start -->
<div id="screen">
    <div class="common-form common-form_border">
        <h3>Company Information</h3>
        <?php echo form_open_multipart(base_url('recruiter/company_info_store'), array('id' => 'basicinfo', 'name' => 'basicinfo', 'class' => 'clearfix', 'onsubmit' => "comlogo(event)")); ?>


        <div> <span class="required_field" >( <span class="red">*</span> ) Indicates required field</span></div>


        <?php
        $comp_name = form_error('comp_name');
        $comp_email = form_error('comp_email');
        $comp_num = form_error('comp_num');
        $comp_profile = form_error('comp_profile');
        $other_activities = form_error('other_activities');
        $country = form_error('country');
        $state = form_error('state');
        $city = form_error('city');
        ?>

        <fieldset <?php if ($comp_name) { ?> class="error-msg" <?php } ?>>
            <label>Company Name :<span class="red">*</span> </label>
            <input name="comp_name" tabindex="1" autofocus type="text" id="comp_name" placeholder="Enter Company Name"  value="<?php
            if ($compname) {
                echo $compname;
            }
            ?>" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/><span id="fullname-error"></span>
        </fieldset>
        <?php echo form_error('comp_name'); ?>

        <fieldset <?php if ($comp_email) { ?> class="error-msg" <?php } ?>>
            <label>Company Email:<span class="red">* </span></label>
            <input name="comp_email" type="text" tabindex="2" id="comp_email" placeholder="Enter Company Email" value="<?php
            if ($compemail) {
                echo $compemail;
            }
            ?>" /><span id="fullname-error"></span>
        </fieldset>
        <?php echo form_error('comp_email'); ?>

        <fieldset <?php if ($comp_num) { ?> class="error-msg" <?php } ?>>
            <label>Company Number:</label>
            <input name="comp_num"  type="text" id="comp_num" tabindex="3" placeholder="Enter Comapny Number" value="<?php
            if ($compnum) {
                echo $compnum;
            }
            ?>"/><span id="email-error"></span>
        </fieldset>
        <?php echo form_error('comp_num'); ?>

        <fieldset>
            <label>Company Website:</span></label>        
            <input name="comp_site"  type="url" id="comp_url" tabindex="4" placeholder="Enter Comapny Website" value="<?php
            if ($compweb) {
                echo $compweb;
            }
            ?>" /> <span class="website_hint" style="font-size: 13px; color: #1b8ab9;">Note : <i>Enter website url with http or https</i></span>  
        </fieldset>
        <fieldset <?php if ($country) { ?> class="error-msg" <?php } ?>>
            <label>Country:<span class="red">*</span></label>

            <select tabindex="5" autofocus name="country" id="country">
                <option value="">Select Country</option>
                <?php
                if (count($countries) > 0) {
                    foreach ($countries as $cnt) {

                        if ($country1) {
                            ?>
                            <option value="<?php echo $cnt['country_id']; ?>" <?php if ($cnt['country_id'] == $country1) echo 'selected'; ?>><?php echo $cnt['country_name']; ?></option>

                            <?php
                        }
                        else {
                            ?>
                            <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                            <?php
                        }
                    }
                }
                ?>
            </select><span id="country-error"></span>
            <?php echo form_error('country'); ?>
        </fieldset>

        <fieldset <?php if ($state) { ?> class="error-msg" <?php } ?>>
            <label>State:<span class="red">*</span> </label>
            <select name="state" id="state" tabindex="6">
                <?php
                if ($state1) {
                    foreach ($states as $cnt) {
                        ?>

                        <option value="<?php echo $cnt['state_id']; ?>" <?php if ($cnt['state_id'] == $state1) echo 'selected'; ?>><?php echo $cnt['state_name']; ?></option>

                        <?php
                    }
                }
                else {
                    ?>
                    <option value="">Select country first</option>
                    <?php
                }
                ?>

            </select><span id="state-error"></span>
            <?php echo form_error('state'); ?>
        </fieldset>


        <fieldset <?php if ($city) { ?> class="error-msg" <?php } ?> class="full-width">
            <label> City:</label>
            <select name="city" id="city" tabindex="7">
                <?php
                if ($city1) {
                    foreach ($cities as $cnt) {
                        ?>

                        <option value="<?php echo $cnt['city_id']; ?>" <?php if ($cnt['city_id'] == $city1) echo 'selected'; ?>><?php echo $cnt['city_name']; ?></option>

                        <?php
                    }
                }
                else if ($state1) {
                    ?>
                    <option value="">Select City</option>
                    <?php
                    foreach ($cities as $cnt) {
                        ?>

                        <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>

                        <?php
                    }
                } else {
                    ?>
                    <option value="">Select state first</option>

                    <?php
                }
                ?>
            </select><span id="city-error"></span>
            <?php echo form_error('city'); ?> 
        </fieldset>


        <fieldset class="full-width">
            <label for="country-suggestions">Sector/Skill You hire for:</span></label>


            <textarea name ="comp_sector" id="comp_sector" rows="4" cols="50" tabindex="8" placeholder=" Ex.php, java, information technology ,automobile ,construction" style="resize: none;"><?php
                if ($compsector) {
                    echo $compsector;
                }
                ?></textarea>

        </fieldset>

        <fieldset <?php if ($comp_profile) { ?> class="error-msg" <?php } ?> class="full-width">
            <label>Company Profile:<!-- <span style="color:red">*</span> -->

                <textarea tabindex="9" name ="comp_profile" id="comp_profile" rows="4" cols="50" placeholder="Enter Company Profile" style="resize: none;"><?php
                    if ($comp_profile1) {
                        echo $comp_profile1;
                    }
                    ?></textarea>
                <?php ?> 
        </fieldset>



        <fieldset <?php if ($other_activities) { ?> class="error-msg" <?php } ?> class="full-width">
            <label>Other activities:<!-- <span style="color:red">*</span> --></label>


            <textarea name ="other_activities" tabindex="10" id="other_activities" rows="4" cols="50" placeholder="Enter Other Activities" style="resize: none;"><?php
                if ($other_activities1) {
                    echo $other_activities1;
                }
                ?></textarea>

        </fieldset>
        <fieldset id="logo_remove">
            <label>Company Logo:</label>
            <input  type="file" name="comp_logo" tabindex="11" id="comp_logo" class="comp_logo" placeholder="Company Logo" multiple="" onchange=" return comlogo();" />

            <div id="com_logo" class="com_logo" style="color:#f00; display: block;"></div>

            <div class="bestofmine_image_primary" style="color:#f00; display: block;"></div>
            <?php
            if ($complogo1) {
                ?>
                <img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $complogo1) ?>"  style="width:100px;height:100px;" class="job_education_certificate_img" >
                <?php
            }
            ?>
        </fieldset>

        <?php
        if ($complogo1) {
            ?>
            <div style="float: left;" id="logo">
                <div class="hs-submit full-width fl">
                    <input  tabindex="" type="button" style="padding: 6px 18px 6px;min-width: 0;font-size: 14px" value="Delete" onClick="delete_logo('<?php echo $rec_id; ?>', '<?php echo $complogo1; ?>')">
                </div>
            </div>

            <?php
        }
        ?>

        <fieldset>

            <input type="hidden" name="image_hidden_logo" value="<?php
            if ($complogo1) {
                echo $complogo1;
            }
            ?>">
        </fieldset>

        <fieldset class="hs-submit full-width">


            <input type="submit"  id="next" name="next" tabindex="12" value="Submit">


        </fieldset>
        </form>   
    </div>
</div>


<?php
//if ($pageWasRefreshed) {
    echo $test_footer;
//}
?>
<script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/company_info.js'); ?>"></script>
<script>
                    function ChangeUrl(title, url) {
                        if (typeof (history.pushState) != "undefined") {
                            var obj = {Title: title, Url: url};
                            history.pushState(obj, obj.Title, obj.Url);
                            $("#screen").load(url);
                        } else {
                            alert("Browser does not support HTML5.");
                        }
                    }



                    jQuery(document).ready(function ($) {

                        var options = {
                            beforeSend: function () {

                            },
                            uploadProgress: function (event, position, total, percentComplete) {

                            },
                            success: function () {
                                alert("hello");
                                window.location.href = '<?php echo base_url('recruiter/home'); ?>';
                            },
                            complete: function (response) {


                            }
                        };
// Submit the form
                        $("#basicinfo").ajaxForm(options);
                        return false;
                    });
</script>