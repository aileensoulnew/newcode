   <div class="search-banner">
        <div class="container">
            <div class="row banner-main-div">
                <div class="col-md-6 col-sm-6 banner-left">
                    <h1 class="pb15">Startup India is a revolutionary initiative started</h1><p>Startup India is a revolutionary initiative started</p>
                </div>
                <div class="col-md-6 col-sm-6 banner-right">
                    <div class="reg-form-box">
                        <div class="reg-form">
                            <h3>Welcome in Recruiter Profile</h3>
                            <form id="basicinfo" name="basicinfo" >
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                              <input name="first_name" tabindex="1" autofocus type="text" id="first_name"  placeholder="First Name" value="<?php
                                                if ($firstname) {
                                                    echo trim(ucfirst(strtolower($firstname)));
                                                } else {
                                                    echo trim(ucfirst(strtolower($userdata['first_name'])));
                                                }
                                                ?>" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/><span id="fullname-error "></span>
                                               <?php echo form_error('first_name'); ?>
                                        </div>
                                        <div class="col-md-6">
                                           <input name="last_name" type="text" tabindex="2" id="last_name" placeholder="Last Name"
                                               value="<?php
                                               if ($lastname) {
                                                   echo trim(ucfirst(strtolower($lastname)));
                                               } else {
                                                   echo trim(ucfirst(strtolower($userdata['last_name'])));
                                               }
                                               ?>" id="last_name" /><span id="fullname-error" ></span>
                                               <?php echo form_error('last_name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <input name="email"  type="text" id="email" tabindex="3" placeholder="Email Address"  value="<?php
                                                if ($email) {
                                                    echo $email;
                                                } else {
                                                    echo $userdata['email'];
                                                }
                                                ?>" /><span id="email-error" ></span>
                                      
                                               <?php echo form_error('email'); ?>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                             <input name="comp_name" tabindex="4" autofocus type="text" id="comp_name" placeholder="Company Name"  value="<?php
                                                    if ($compname) {
                                                        echo $compname;
                                                    }
                                                    ?>" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value"/><span id="fullname-error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <input name="comp_num"  type="text" id="comp_num" tabindex="5" placeholder="Company Number" value="<?php
                                                    if ($compnum) {
                                                        echo $compnum;
                                                    }
                                                    ?>"/><span id="email-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <input name="comp_email" type="text" tabindex="6" id="comp_email" placeholder="Company Email Address" value="<?php
                                                    if ($compemail) {
                                                        echo $compemail;
                                                    }
                                                    ?>" /><span id="fullname-error"></span>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select tabindex="7" autofocus name="country" id="country">
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
                                        </div>
                                        <div class="col-md-6">
                                           <select name="state" id="state" tabindex="8">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select name="city" id="city" tabindex="9">
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
                                        </div>
                                
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                             <textarea tabindex="10" name ="comp_profile" id="comp_profile" rows="4" cols="50" placeholder="About Company Profile" style="resize: none;"><?php
                                            if ($comp_profile1) {
                                                echo $comp_profile1;
                                            }
                                            ?></textarea>
                                        </div>
                                
                                    </div>
                                </div>
                                <input type="hidden" id="segment" value="<?php echo  $this->uri->segment(3); ?>">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                             <button id="submit" class="btn1 recruiter_registration" name="submit" tabindex="11" onclick="return reg_loader();" class="cus_btn_sub">Register</button>

                                        </div>
                                
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>