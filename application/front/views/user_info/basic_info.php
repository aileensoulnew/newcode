<div class="container">
    <div class="form-box">
        <h2 class="text-center">Basic Information</h3>
            <form name="basicinfo" id="basicinfo" ng-submit="submitBasicInfoForm()" ng-validate="basicInfoValidate">
                <div class="form-group">
                    <!--<p class="student-or-not">If you are a student then <a data-target="#Student-info" data-toggle="modal" href="javascript:;">Click Here.</a></p>-->
                    <p class="student-or-not">If you are a student then <a href="educational-information">Click Here.</a></p>
                </div>

                <div class="form-group">
                    <label for="text">Who are you?</label>
                    <input type="text" name="jobTitle" id="jobTitle" class="form-control" ng-keyup="jobTitle()" ng-model="user.jobTitle" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, Developer, HR, BDE, CA, Doctor.." typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorjobTitle" class="error">{{errorjobTitle}}</label>
                </div>
                <div class="form-group">
                    <label for="text">Where are you from?</label>
                    <input type="text" name="city" id="city" class="form-control" ng-keyup="cityList()" ng-model="user.cityList" placeholder="Enter your city name" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                </div>
                <div class="form-group cus_field">
                    <label for="text">What is your field?</label>
                    <select name="field" ng-model="user.field" id="field" ng-change="other_field(this)">
                        <option value="" selected="selected">Select your field</option>
                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                        <option value="0">Other</option>
                    </select>
                    <label ng-show="errorfield" class="error">{{errorfield}}</label>
                </div>
                <div class="form-group" ng-if="user.field == '0'">
                    <label for="text">Other Field</label>
                    <input type="text" class="form-control" ng-model="user.otherField" placeholder="Enter other field" ng-required="true">
                    <label ng-show="errorotherField" class="error">{{errorotherField}}</label>
                </div>
                <p class="text-center submit-btn">
                    <button type="submit" id="submit" class="btn1">Submit<span class="ajax_load" id="basic_info_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                </p>
            </form>
    </div>
</div>