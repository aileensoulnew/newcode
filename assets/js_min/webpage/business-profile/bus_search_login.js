function business_search_post(e){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"search/ajax_business_user_login_search?page="+e+"&skills="+keyword+"&searchplace="+keyword1,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){"undefined"==e||$("#loader").show()},complete:function(){$("#loader").hide()},success:function(e){$(".loader").remove(),$(".job-contact-frnd").append(e);var r=$(".post-design-box").length;0==r?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function login(){document.getElementById("error1").style.display="none"}function login_profile(){$("#login").modal("show")}function register_profile(){$("#login").modal("hide"),$("#register").modal("show")}function forgot_profile(){$("#forgotPassword").modal("show")}$(document).ready(function(){business_search_post(),$(window).scroll(function(){if($(window).scrollTop()>=.7*($(document).height()-$(window).height())){var e=$(".page_number:last").val(),r=$(".total_record").val(),a=$(".perpage_record").val();if(parseInt(a)<=parseInt(r)){var s=r/a;s=parseInt(s,10);var t=r%a;if(t>0&&(s+=1),parseInt(e)<=parseInt(s)){var o=parseInt($(".page_number:last").val())+1;business_search_post(o)}}}})});var isProcessing=!1;$(document).ready(function(){function e(){var e=$("#email_login").val(),r=$("#password_login").val(),a={email_login:e,password_login:r,csrf_token_name:csrf_hash};return $.ajax({type:"POST",url:base_url+"registration/user_check_login",data:a,dataType:"json",beforeSend:function(){$("#error").fadeOut(),$("#btn1").html("Login")},success:function(e){"ok"==e.data?($("#btn1").html('<img src="'+base_url+'assets/images/btn-ajax-loader.gif" /> &nbsp; Login'),"1"==e.is_bussiness?window.location=base_url+"search/ajax_business_user_login_search?page="+pagenum+"&skills="+keyword+"&searchplace="+keyword1:window.location=base_url+"business-profile"):"password"==e.data?($("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>'),document.getElementById("password_login").classList.add("error"),document.getElementById("password_login").classList.add("error"),$("#btn1").html("Login")):($("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>'),document.getElementById("email_login").classList.add("error"),document.getElementById("email_login").classList.add("error"),$("#btn1").html("Login"))}}),!1}$("#login_form").validate({rules:{email_login:{required:!0},password_login:{required:!0}},messages:{email_login:{required:"Please enter email address"},password_login:{required:"Please enter password"}},submitHandler:e})}),$(document).ready(function(){function e(){var e=$("#first_name").val(),r=$("#last_name").val(),a=$("#email_reg").val(),s=$("#password_reg").val(),t=$("#selday").val(),o=$("#selmonth").val(),l=$("#selyear").val(),n=$("#selgen").val(),i={first_name:e,last_name:r,email_reg:a,password_reg:s,selday:t,selmonth:o,selyear:l,selgen:n,"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"},d=new Date,u=d.getDate(),c=d.getMonth()+1,m=d.getFullYear();10>u&&(u="0"+u),10>c&&(c="0"+c);var d=m+"/"+c+"/"+u,g=l+"/"+o+"/"+t,_=Date.parse(d),h=Date.parse(g);if(h>_)return $(".dateerror").html("Date of birth always less than to today's date."),!1;if(0==l%4&&0!=l%100||0==l%400){if(4==o||6==o||9==o||11==o){if(31==t)return $(".dateerror").html("This month has only 30 days."),!1}else if(2==o&&(31==t||30==t))return $(".dateerror").html("This month has only 29 days."),!1}else if(4==o||6==o||9==o||11==o){if(31==t)return $(".dateerror").html("This month has only 30 days."),!1}else if(2==o&&(31==t||30==t||29==t))return $(".dateerror").html("This month has only 28 days."),!1;return $.ajax({type:"POST",url:"<?php echo base_url() ?>registration/reg_insert",data:i,beforeSend:function(){$("#register_error").fadeOut(),$("#btn1").html("Create an account")},success:function(e){"ok"==e?($("#btn-register").html('<img src="'+base_url+'assets/images/btn-ajax-loader.gif" /> &nbsp; Sign Up ...'),window.location="<?php echo base_url() ?>business-profile/"):$("#register_error").fadeIn(1e3,function(){$("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; '+e+" !</div>"),$("#btn1").html("Create an account")})}}),!1}$.validator.addMethod("lowercase",function(e,r,a){return a.test(e)},"Email Should be in Small Character"),$("#register_form").validate({rules:{first_name:{required:!0},last_name:{required:!0},email_reg:{required:!0,email:!0,lowercase:/^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,remote:{url:base_url+"registration/check_email",type:"post",data:{email_reg:function(){return $("#email_reg").val()},csrf_token_name:csrf_hash}}},password_reg:{required:!0},selday:{required:!0},selmonth:{required:!0},selyear:{required:!0},selgen:{required:!0}},groups:{selyear:"selyear selmonth selday"},messages:{first_name:{required:"Please enter first name"},last_name:{required:"Please enter last name"},email_reg:{required:"Please enter email address",remote:"Email address already exists"},password_reg:{required:"Please enter password"},selday:{required:"Please enter your birthdate"},selmonth:{required:"Please enter your birthdate"},selyear:{required:"Please enter your birthdate"},selgen:{required:"Please enter your gender"}},submitHandler:e})}),$(document).ready(function(){$("#forgot_password").validate({rules:{forgot_email:{required:!0,email:!0}},messages:{forgot_email:{required:"Email Address Is Required."}}})}),$(document).on("click","[data-toggle*=modal]",function(){$("[role*=dialog]").each(function(){switch($(this).css("display")){case"block":$("#"+$(this).attr("id")).modal("hide")}})});