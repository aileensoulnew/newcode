<div class="col-sm-7 col-md-7 col-xs-6 hidden-mob">
                        <div class="job-search-box1 clearfix">
                         <form action=<?php echo base_url('freelance-work/search')?> method="get">
                            <fieldset class="col-md-3 col-sm-5 col-xs-5">
                              <input type="text" class="skill_keyword" id="tags" name="skills" placeholder="Post Title, Skills, Keywords">
                                </select>

                            </fieldset>
                            <fieldset class="col-md-3 col-sm-5 col-xs-5">
                               <input type="text" class="skill_place" id="searchplace" name="searchplace" placeholder="Find Your Location"> 
                            </fieldset>
                             <fieldset class="col-md-2 col-sm-2 col-xs-2">
                              <label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
                                <button onclick="return checkvalue()" id="search_btn" style="display: none;"> <?php echo $this->lang->line("search"); ?></button>
                            </fieldset>
                        <?php echo form_close();?>
                        </div>
                    </div>
