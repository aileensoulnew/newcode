function login_data(){$("#login").modal("show"),$("#register").modal("hide")}function forgot_profile(){$("#forgotPassword").modal("show")}function register_profile(){$("#login").modal("hide"),$("#register").modal("show")}function submit_forgot(){var e=document.getElementById("forgot_email").value;""!=e&&($("#forgotPassword").modal("hide"),event.preventDefault())}function login(){document.getElementById("error1").style.display="none"}function remove_validation_stream(){$("#other_indu").removeClass("keyskill_border_active"),$("#field_error").remove()}$(document).ready(function(){"live"==profile_login&&$("#register").modal("show"),$.validator.addMethod("regx2",function(e,r,a){return e?a.test(e):!0},"Special character and space not allow in the beginning"),$.validator.addMethod("regx_digit",function(e,r,a){return e?a.test(e):!0},"Digit is not allow"),$.validator.addMethod("regx1",function(e,r,a){return e?a.test(e):!0},"Only space, only number and only special characters are not allow"),$("#jobseeker_regform").validate({ignore:"*:not([name])",ignore:":hidden",rules:{first_name:{required:!0,regx2:/^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,regx_digit:/^([^0-9]*)$/},last_name:{required:!0,regx2:/^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,regx_digit:/^([^0-9]*)$/},cities:{required:!0},email:{required:!0,email:!0,remote:{url:base_url+"job/check_email",async:!1,type:"post"}},fresher:{required:!0},job_title:{required:!0,regx1:/^[-@.\/#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/},industry:{required:!0},cities:{required:!0,regx1:/^[-@.\/#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/},skills:{required:!0,regx1:/^[-@.\/#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/}},messages:{first_name:{required:"First name is required."},last_name:{required:"Last name is required."},email:{required:"Email address is required.",email:"Please enter valid email id.",remote:"Email already exists"},fresher:{required:"Fresher is required."},industry:{required:"Industry is required."},cities:{required:"City is required."},job_title:{required:"Job title is required."},skills:{required:"Skill is required."}},errorPlacement:function(e,r){"fresher"==r.attr("name")?$(".fresher-error").html(e):e.insertAfter(r)}})}),$(document).ready(function(){function e(){var e=$("#first_regname").val(),r=$("#last_regname").val(),a=$("#email_reg").val(),i=$("#password_reg").val(),t=$("#selday").val(),s=$("#selmonth").val(),o=$("#selyear").val(),l=$("#selgen").val(),n={first_name:e,last_name:r,email_reg:a,password_reg:i,selday:t,selmonth:s,selyear:o,selgen:l,"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"},d=new Date,u=d.getDate(),m=d.getMonth()+1,c=d.getFullYear();10>u&&(u="0"+u),10>m&&(m="0"+m);var d=c+"/"+m+"/"+u,_=o+"/"+s+"/"+t,h=Date.parse(d),g=Date.parse(_);if(g>h)return $(".dateerror").html("Date of birth always less than to today's date."),!1;if(0==o%4&&0!=o%100||0==o%400){if(4==s||6==s||9==s||11==s){if(31==t)return $(".dateerror").html("This month has only 30 days."),!1}else if(2==s&&(31==t||30==t))return $(".dateerror").html("This month has only 29 days."),!1}else if(4==s||6==s||9==s||11==s){if(31==t)return $(".dateerror").html("This month has only 30 days."),!1}else if(2==s&&(31==t||30==t||29==t))return $(".dateerror").html("This month has only 28 days."),!1;return $.ajax({type:"POST",url:base_url+"registration/reg_insert",dataType:"json",data:n,beforeSend:function(){$("#register_error").fadeOut(),$("#btn1").html("Create an account ...")},success:function(e){"ok"==e.okmsg?window.location=base_url+"job/profile":$("#register_error").fadeIn(1e3,function(){$("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; '+e+" !</div>"),$("#btn1").html("Create an account")})}}),!1}$.validator.addMethod("lowercase",function(e,r,a){return a.test(e)},"Email Should be in Small Character"),$("#register_form").validate({rules:{first_regname:{required:!0},last_regname:{required:!0},email_reg:{required:!0,email:!0,lowercase:/^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,remote:{url:base_url+"registration/check_email",type:"post",data:{email_reg:function(){return $("#email_reg").val()},"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}}},password_reg:{required:!0},selday:{required:!0},selmonth:{required:!0},selyear:{required:!0},selgen:{required:!0}},groups:{selyear:"selyear selmonth selday"},messages:{first_name:{required:"Please enter first name"},last_name:{required:"Please enter last name"},email_reg:{required:"Please enter email address",remote:"Email address already exists"},password_reg:{required:"Please enter password"},selday:{required:"Please enter your birthdate"},selmonth:{required:"Please enter your birthdate"},selyear:{required:"Please enter your birthdate"},selgen:{required:"Please enter your gender"}},submitHandler:e})}),$(document).ready(function(){$("#forgot_password").validate({rules:{forgot_email:{required:!0,email:!0}},messages:{forgot_email:{required:"Email Address Is Required."}}})}),$(document).ready(function(){function e(){var e=$("#email_login").val(),r=$("#password_login").val(),a={email_login:e,password_login:r,"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"};return $.ajax({type:"POST",url:base_url+"registration/user_check_login",data:a,dataType:"json",beforeSend:function(){$("#error").fadeOut(),$("#btn1").html("Login")},success:function(e){"ok"==e.data?window.location=base_url+"job/profile":1==e.is_artistic?window.location=base_url+"job/profile":"password"==e.data?($("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>'),document.getElementById("password_login").classList.add("error"),document.getElementById("password_login").classList.add("error"),$("#btn1").html("Login")):($("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>'),document.getElementById("email_login").classList.add("error"),document.getElementById("email_login").classList.add("error"),$("#btn1").html("Login"))}}),!1}$("#login_form").validate({rules:{email_login:{required:!0},password_login:{required:!0}},messages:{email_login:{required:"Please enter email address"},password_login:{required:"Please enter password"}},submitHandler:e})}),$("#submit").on("click",function(){$("#experience_error").remove(),$(".experience_month").removeClass("error"),$(".experience_year").removeClass("error");var e=$("#experience_year").val(),r=$("#experience_month").val(),a=$("input[name=fresher]:checked").val();return"Experience"==a?null==e&&null==r?($("#experience_year").addClass("error"),$("#experience_month").addClass("error"),$('<span class="error" id="experience_error" style="float: right;color: red; font-size: 11px;">Experiance is required</span>').insertAfter("#experience_month"),$("#submit").addClass("register_enable-cust"),!1):!0:void 0}),$("#submit").on("click",function(){$("#jobseeker_regform").valid()&&$("#submit").addClass("register_disable")}),$(document).on("change","#industry",function(e){var r=$(this),a=r.val();288==a&&(r.val(""),$(".biderror .mes").html('<h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu" onkeypress="return remove_validation_stream()"><a id="indus" class="btn">OK</a>'),$("#bidmodal").modal("show"),$(".message #indus").on("click",function(){$("#other_indu").removeClass("keyskill_border_active"),$("#field_error").remove();var e=$.trim(document.getElementById("other_indu").value);if(""==e)return $("#other_indu").addClass("keyskill_border_active"),$('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter("#other_indu"),!1;var r=$(".message").find('input[type="text"]'),a=r.val();$.ajax({type:"POST",url:base_url+"job/job_other_industry",data:"other_industry="+a,success:function(e){0==e?($("#other_indu").addClass("keyskill_border_active"),$('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written industry already available in industry Selection</span>').insertAfter("#other_indu")):1==e?($("#other_indu").addClass("keyskill_border_active"),$('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty industry  is not valid</span>').insertAfter("#other_indu")):($("#bidmodal").modal("hide"),$("#industry").html(e))}})}))}),$(document).on("keydown",function(e){27===e.keyCode&&$("#bidmodal").hide()});