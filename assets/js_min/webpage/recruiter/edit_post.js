function checkvalue_search(){var e=document.getElementById("rec_search_title").value,t=document.getElementById("rec_search_loc").value;return""==e&&""==t?!1:void 0}function leave_page(e){var t=document.getElementById("rec_search_title").value,r=document.getElementById("rec_search_loc").value;return 4==e&&""!=t&&""!=r?checkvalue_search:home(e,t,r)}function home(e,t,r){$(".biderror .mes").html("<div class='pop_content'> Do you want to discard your changes?<div class='model_ok_cancel'><a class='okbtn' id="+e+" onClick='home_profile("+e+',"'+t+'","'+r+"\")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")}function home_profile(e,t,r){var a,i;4==e&&(a=base_url+"search/recruiter_search",i="id="+e+"&skills="+t+"&searchplace="+r),$.ajax({type:"POST",url:a,data:i,success:function(a){1==e?window.location=base_url+"recruiter/recommen_candidate":2==e?window.location=base_url+"recruiter/rec_profile":3==e?window.location=base_url+"recruiter/rec_basic_information":4==e?""==t?window.location=base_url+"search/recruiter_search/0/"+r:""==r?window.location=base_url+"search/recruiter_search/"+t+"/0":window.location=base_url+"search/recruiter_search/"+t+"/"+r:5==e?window.location=base_url+"profiles/"+user_slug:6==e?window.location=base_url+"profile":7==e?window.location=base_url+"registration/changepassword":8==e?window.location=base_url+"dashboard/logout":9==e?location.href="javascript:history.back()":alert("edit profilw")}})}function imgval(){var e,t=document.getElementById("minyear").value,r=document.getElementById("maxyear").value;return e=12*t,max_exper=12*r,e>max_exper?(alert("Minimum experience is not greater than maximum experience"),!1):void 0}function split(e){return e.split(/,\s*/)}function extractLast(e){return split(e).pop()}$.validator.addMethod("regx",function(e,t,r){return e?r.test(e):!0},"Only space, only number and only special characters are not allow"),jQuery.validator.addMethod("noSpace",function(e,t){return""==e||0!=e.trim().length},"No space please and don't leave it empty"),$.validator.addMethod("reg_candidate",function(e,t,r){return r.test(e)},"Float number is not allowed"),$.validator.addMethod("greaterThan",function(e,t,r){var a=$(r);return e?parseInt(e,10)>parseInt(a.val(),10):!0}),$.validator.addMethod("greaterThan1",function(e,t,r){var a=$(r);return this.settings.onfocusout&&a.off(".validate-greaterThan").on("blur.validate-greaterThan",function(){$(t).valid()}),e?e>a.val():!0},"Max must be greater than min"),$.validator.addMethod("greaterThanmonth",function(e,t,r){var a=$("#maxyear"),i=parseInt(a.val()),n=$("#minyear"),o=parseInt(n.val()),s=$(r);return this.settings.onfocusout&&s.off(".validate-greaterThan").on("blur.validate-greaterThan",function(){$(t).valid()}),e&&i==o?parseInt(e)>=parseInt(s.val()):!0},"Max month must be greater than min month"),jQuery.validator.addMethod("isValid",function(e,t){var r=new Date,a=r.getDate(),i=r.getMonth()+1,n=r.getFullYear();10>a&&(a="0"+a),10>i&&(i="0"+i);var r=a+"/"+i+"/"+n,o=/^\d{1,2}\/\d{1,2}\/\d{4}$/;if(e.match(o))var s=e;else{e=e.split("-");var s=e[2]+"/"+e[1]+"/"+e[0]}s=s.split("/");var l=s[1]+"/"+s[0]+"/"+s[2],d=new Date(l).getTime();r=r.split("/");var u=r[1]+"/"+r[0]+"/"+r[2],c=new Date(u).getTime();return d>=c?($(".day").removeClass("error"),$(".month").removeClass("error"),$(".year").removeClass("error"),!0):($(".day").addClass("error"),$(".month").addClass("error"),$(".year").addClass("error"),!1)},"Last date should be grater than and equal to today date"),$.validator.addMethod("required1",function(e,t,r){return e?($(".day").removeClass("error"),$(".month").removeClass("error"),$(".year").removeClass("error"),!0):($(".day").addClass("error"),$(".month").addClass("error"),$(".year").addClass("error"),!1)},"Last date of apply is required."),$("#basicinfo").validate({ignore:"*:not([name])",rules:{post_name:{required:!0,regx:/^[-@.\/#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,minlength:10,maxlength:100},skills:{required:!0},position:{required:!0,number:!0,min:1,reg_candidate:/^-?(([0-9]{0,1000}))$/,maxlength:4,range:[1,1e3]},minyear:{required:!0},emp_type:{required:!0},industry:{required:!0},post_desc:{required:!0,regx:/^[-@.\/#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/},country:{required:!0},state:{required:!0},maxyear:{required:!0,greaterThan1:"#minyear"},last_date:{required1:"Last date of apply is required.",isValid:"Last date should be grater than and equal to today date."},minsal:{number:!0,maxlength:11},maxsal:{number:!0,min:0,greaterThan:"#minsal",maxlength:11},position_no:{required:!0}},messages:{post_name:{required:"Jobtitle  is required."},skills:{required:"Skill  is required."},position:{required:"You have to select minimum 1 position."},minyear:{required:"Minimum experience is required."},emp_type:{required:"Employment type is required."},industry:{required:"Industry is required."},post_desc:{required:"Post description is required."},country:{required:"Country is required."},state:{required:"State is required."},maxyear:{required:"Maximum experience is required."},last_date:{},maxsal:{greaterThan:"Maximum salary should be grater than minimum salary."},position_no:{required:"Number of position required."}}}),$("#education").bind("keydown",function(e){e.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active&&e.preventDefault()}).autocomplete({minLength:0,source:function(e,t){$.getJSON(base_url+"general/get_degree",{term:extractLast(e.term)},t)},focus:function(){return!1},select:function(e,t){var r=split(this.value);if(r.length<=20)return r.pop(),r.push(t.item.value),r.push(""),this.value=r.join(", "),!1;var a=r.pop();return $(this).val(this.value.substr(0,this.value.length-a.length-2)),$(this).effect("highlight",{},1e3),$(this).attr("style","border: solid 1px red;"),!1}}),$(function(){function e(e){return e.split(/,\s*/)}function t(t){return e(t).pop()}$("#skills2").bind("keydown",function(e){e.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active&&e.preventDefault()}).autocomplete({minLength:2,source:function(e,r){$.getJSON(base_url+"general/get_skill",{term:t(e.term)},r)},focus:function(){return!1},select:function(t,r){var a=e(this.value);if(a.length<=20)return a.pop(),a.push(r.item.value),a.push(""),this.value=a.join(", "),!1;var i=a.pop();return $(this).val(this.value.substr(0,this.value.length-i.length-2)),$(this).effect("highlight",{},1e3),$(this).attr("style","border: solid 1px red;"),!1}})}),$(function(){$("#post_name").autocomplete({source:function(e,t){var r=new RegExp("^"+$.ui.autocomplete.escapeRegex(e.term),"i");t($.grep(jobdata,function(e){return r.test(e.label)}))},minLength:1,select:function(e,t){e.preventDefault(),$("#post_name").val(t.item.label),$("#selected-tag").val(t.item.label)},focus:function(e,t){e.preventDefault(),$("#post_name").val(t.item.label)}})}),$(document).ready(function(){$("#country").on("change",function(){var e=$(this).val();e?$.ajax({type:"POST",url:base_url+"recruiter/ajax_data",data:"country_id="+e,success:function(e){$("#state").html(e),$("#city").html('<option value="">Select state first</option>')}}):($("#state").html('<option value="">Select country first</option>'),$("#city").html('<option value="">Select state first</option>'))}),$("#state").on("change",function(){var e=$(this).val();e?$.ajax({type:"POST",url:base_url+"recruiter/ajax_data",data:"state_id="+e,success:function(e){$("#city").html(e)}}):$("#city").html('<option value="">Select state first</option>')})});var modal=document.getElementById("myModal"),btn=document.getElementById("myBtn"),span=document.getElementsByClassName("close")[0],$=jQuery.noConflict();$(document).on("change","#industry",function(e){var t=$(this),r=t.val();288==r&&(t.val(""),$(".biderror .mes").html('<div class="message"><h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu"><a id="indus" class="btn">OK</a></div>'),$("#bidmodal").modal("show"),$(".message #indus").on("click",function(){$("#other_indu").removeClass("keyskill_border_active"),$("#field_error").remove();var e=$.trim(document.getElementById("other_indu").value);if(""==e)return $("#other_indu").addClass("keyskill_border_active"),$('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter("#other_indu"),!1;var t=$(".message").find('input[type="text"]'),r=t.val();$.ajax({type:"POST",url:base_url+"recruiter/recruiter_other_industry",data:"other_industry="+r,success:function(e){0==e?($("#other_indu").addClass("keyskill_border_active"),$('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written industry already available in industry Selection</span>').insertAfter("#other_indu")):1==e?($("#other_indu").addClass("keyskill_border_active"),$('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty industry  is not valid</span>').insertAfter("#other_indu")):($("#bidmodal").modal("hide"),$("#industry").html(e))}})}))}),$(function(){var e=new Date,t=(e.getDate(),e.getMonth()+1,e.getFullYear()),e=t;$("#example2").dateDropdowns({submitFieldName:"last_date",submitFormat:"dd/mm/yyyy",minYear:e,maxYear:e+1,defaultDate:date_picker,daySuffixes:!1,monthFormat:"short",dayLabel:"DD",monthLabel:"MM",yearLabel:"YYYY"}),$(".day").attr("tabindex",11),$(".month").attr("tabindex",12),$(".year").attr("tabindex",13)}),$(document).ready(function(){$(document).on("keydown",function(e){27===e.keyCode&&($("#bidmodal").modal("hide"),$("#dropdown-content_hover").hide())})});