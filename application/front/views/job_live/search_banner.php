<div class="search-banner" ng-controller="searchJobController">
    <div class="container">
        <div class="text-right pt20">
            <a class="btn5" href="<?php echo $job_profile_link ?>">Create Job Profile</a>
        </div>
        <div class="search-bnr-text">
            <h1>Find The Job That Fits Your Life</h1>
        </div>
        <div class="search-box">
            <form ng-submit="searchSubmit()">
                <div class="pb20 search-input">
                    <input type="text" ng-model="keyword" id="q" name="q" placeholder="Keywords, Title, or Company" autocomplete="on">
                    <input type="text" ng-model="city" id="l" name="l" placeholder="City, State or Country" autocomplete="on">
                    <input type="submit" class="btn1" name="submit" value="Search">
                </div>
                <div class="pt5">
                    <ul class="work-timing">
                        <li>
                            <label class="control control--checkbox">Full-Time
                                <input type="checkbox" ng-model="fulltime" id="fulltime" name="fulltime" value="1"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Part-Time
                                <input type="checkbox" ng-model="parttime" id="parttime" name="parttime" value="1"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Internship
                                <input type="checkbox" ng-model="internship" id="internship" name="internship" value="1"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>