<div class="container">
    <div class="form-box">
        <h2 class="text-center">Educational Information</h3>
            <form name="studentinfo" id="studentinfo" ng-submit="submitStudentInfoForm()" ng-validate="studentInfoValidate">
                <div class="form-group">
                    <label for="text">What are you studying right now?</label>
                    <input type="text" name="currentStudy" id="currentStudy" class="form-control" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 5th, 10th, 12th .." ng-keyup="currentStudy()" ng-model="user.currentStudy" typeahead="item as item.degree_name for item in degreeSearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorcurrentStudy" class="error">{{errorcurrentStudy}}</label>
                </div>
                <div class="form-group">
                    <label for="text">Where are you from?</label>
                    <input type="text" name="city" id="city" class="form-control" ng-keyup="cityList()" ng-model="user.cityList" placeholder="Enter your city name" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                </div>
                <div class="form-group">
                    <label for="text">University / Collage / School </label>
                    <input type="text" name="university" id="university" class="form-control" placeholder="Enter your University / Collage / school " ng-model="user.universityName" ng-keyup="universityList()" typeahead="item as item.university_name for item in universitySearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="erroruniversityName" class="error">{{erroruniversityName}}</label>
                </div>
                <p class="text-center submit-btn">
                    <button type="submit" id="submit" class="btn1">Submit<span class="ajax_load" id="student_info_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                </p>
            </form>
    </div>
    <a href="basic-information" title="Go to Back"><i class="fa fa-arrow-left" aria-hidden="true"> Back to Basic Information</i></a>
</div>