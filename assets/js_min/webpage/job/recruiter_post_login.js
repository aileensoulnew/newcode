function rec_post(e){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"job/ajax_rec_post?page="+e+"&id="+id+"&postid="+postid,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){"undefined"==e?$(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="'+base_url+'images/loading.gif"/></p>'):$("#loader").show()},complete:function(){$("#loader").hide()},success:function(e){$(".loader").remove(),$(".job-contact-frnd").append(e);var a=$(".post-design-box").length;0==a?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function login(){document.getElementById("error1").style.display="none"}function login_profile(){$(".password_login").val(""),$(".email_login").val(""),$("#login").modal("show")}function login_profile_save(){$(".password_login").val(""),$(".email_login").val(""),$("#login_save").modal("show")}function login_profile_apply(){$(".password_login").val(""),$(".email_login").val(""),$("#login_apply").modal("show")}function register_profile(){$("#login").modal("hide"),$("#register").modal("show")}function forgot_profile(){$("#forgotPassword").modal("show")}$(document).ready(function(){rec_post(),$(window).scroll(function(){if($(window).scrollTop()>=.7*($(document).height()-$(window).height())){var e=$(".page_number:last").val(),a=$(".total_record").val(),r=$(".perpage_record").val();if(parseInt(r)<=parseInt(a)){var s=a/r;s=parseInt(s,10);var l=a%r;if(l>0&&(s+=1),parseInt(e)<=parseInt(s)){var o=parseInt($(".page_number:last").val())+1;rec_post(o)}}}})});var isProcessing=!1;$(document).ready(function(){function e(){var e=$("#email_login").val(),a=$("#password_login").val(),r={email_login:e,password_login:a,csrf_token_name:csrf_hash};return $.ajax({type:"POST",url:base_url+"registration/check_login",data:r,dataType:"json",beforeSend:function(){$("#error").fadeOut(),$("#btn1").html("Login ...")},success:function(e){"ok"==e.data?($("#btn1").html('<img src="'+base_url+'images/btn-ajax-loader.gif" /> &nbsp; Login ...'),1==e.jobuser?window.location=base_url+"job/post-"+postid+"/"+text+"-vacancy-in-"+cityname:window.location=base_url+"job/"):"password"==e.data?($("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>'),document.getElementById("password_login").classList.add("error"),document.getElementById("password_login").classList.add("error"),$("#btn1").html("Login")):($("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>'),document.getElementById("email_login").classList.add("error"),document.getElementById("email_login").classList.add("error"),$("#btn1").html("Login"))}}),!1}$("#login_form").validate({rules:{email_login:{required:!0},password_login:{required:!0}},messages:{email_login:{required:"Please enter email address"},password_login:{required:"Please enter password"}},submitHandler:e})}),$(document).ready(function(){function e(){var e=$("#first_name").val(),a=$("#last_name").val(),r=$("#email_reg").val(),s=$("#password_reg").val(),l=$("#selday").val(),o=$("#selmonth").val(),t=$("#selyear").val(),n=$("#selgen").val(),i={first_name:e,last_name:a,email_reg:r,password_reg:s,selday:l,selmonth:o,selyear:t,selgen:n,csrf_token_name:csrf_hash},d=new Date,m=d.getDate(),_=d.getMonth()+1,c=d.getFullYear();10>m&&(m="0"+m),10>_&&(_="0"+_);var d=c+"/"+_+"/"+m,g=t+"/"+o+"/"+l,u=Date.parse(d),p=Date.parse(g);if(p>u)return $(".dateerror").html("Date of birth always less than to today's date."),!1;if(0==t%4&&0!=t%100||0==t%400){if(4==o||6==o||9==o||11==o){if(31==l)return $(".dateerror").html("This month has only 30 days."),!1}else if(2==o&&(31==l||30==l))return $(".dateerror").html("This month has only 29 days."),!1}else if(4==o||6==o||9==o||11==o){if(31==l)return $(".dateerror").html("This month has only 30 days."),!1}else if(2==o&&(31==l||30==l||29==l))return $(".dateerror").html("This month has only 28 days."),!1;return $.ajax({type:"POST",url:base_url+"registration/reg_insert",data:i,beforeSend:function(){$("#register_error").fadeOut(),$("#btn1").html("Create an account ...")},success:function(e){"ok"==e?($("#btn-register").html("<img src="+base_url+'"images/btn-ajax-loader.gif"/> &nbsp; Sign Up ...'),1==e.jobuser?window.location=base_url+"job/post-"+postid+"/"+text+"-vacancy-in-"+cityname:window.location=base_url+"job/"):$("#register_error").fadeIn(1e3,function(){$("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; '+e+" !</div>"),$("#btn1").html("Create an account")})}}),!1}$("#register_form").validate({rules:{first_name:{required:!0},last_name:{required:!0},email_reg:{required:!0,email:!0,remote:{url:base_url+"registration/check_email",type:"post",data:{email_reg:function(){return $("#email_reg").val()},csrf_token_name:csrf_hash}}},password_reg:{required:!0},selday:{required:!0},selmonth:{required:!0},selyear:{required:!0},selgen:{required:!0}},groups:{selyear:"selyear selmonth selday"},messages:{first_name:{required:"Please enter first name"},last_name:{required:"Please enter last name"},email_reg:{required:"Please enter email address",remote:"Email address already exists"},password_reg:{required:"Please enter password"},selday:{required:"Please enter your birthdate"},selmonth:{required:"Please enter your birthdate"},selyear:{required:"Please enter your birthdate"},selgen:{required:"Please enter your gender"}},submitHandler:e})}),$(document).ready(function(){$("#forgot_password").validate({rules:{forgot_email:{required:!0,email:!0}},messages:{forgot_email:{required:"Email address is required."}}})}),$(document).ready(function(){function e(){var e=$("#email_login_save").val(),a=$("#password_login_save").val(),r={email_login:e,password_login:a,csrf_token_name:csrf_hash};return $.ajax({type:"POST",url:base_url+"registration/check_login",data:r,dataType:"json",beforeSend:function(){$("#error").fadeOut(),$("#btn1").html("Login ...")},success:function(e){"ok"==e.data?($("#btn1").html('<img src="'+base_url+'images/btn-ajax-loader.gif" /> &nbsp; Login ...'),1==e.jobuser?$.ajax({type:"POST",url:base_url+"job/job_save",data:"post_id="+postid,success:function(e){window.location=base_url+"job/post-"+postid+"/"+text+"-vacancy-in-"+cityname}}):window.location=base_url+"job/"):"password"==e.data?($("#errorpass_save").html('<label for="email_login_save" class="error">Please enter a valid password.</label>'),document.getElementById("password_login_save").classList.add("error"),document.getElementById("password_login_save").classList.add("error"),$("#btn1").html("Login")):($("#errorlogin_save").html('<label for="email_login_save" class="error">Please enter a valid email.</label>'),document.getElementById("email_login_save").classList.add("error"),document.getElementById("email_login_save").classList.add("error"),$("#btn1").html("Login"))}}),!1}$("#login_form_save").validate({rules:{email_login_save:{required:!0},password_login_save:{required:!0}},messages:{email_login_save:{required:"Please enter email address"},password_login_save:{required:"Please enter password"}},submitHandler:e})}),$(document).ready(function(){function e(){var e=$("#email_login_apply").val(),a=$("#password_login_apply").val(),r={email_login:e,password_login:a,csrf_token_name:csrf_hash};return $.ajax({type:"POST",url:base_url+"registration/check_login",data:r,dataType:"json",beforeSend:function(){$("#error").fadeOut(),$("#btn1").html("Login ...")},success:function(e){if("ok"==e.data)if($("#btn1").html('<img src="'+base_url+'images/btn-ajax-loader.gif" /> &nbsp; Login ...'),1==e.jobuser){var a="all",r=e.id;$.ajax({type:"POST",url:base_url+"job/job_apply_post",data:"post_id="+postid+"&allpost="+a+"&userid="+r,success:function(e){window.location=base_url+"job/post-"+postid+"/"+text+"-vacancy-in-"+cityname}})}else window.location=base_url+"job/";else"password"==e.data?(alert("hi"),$("#errorpass_apply").html('<label for="email_login_apply" class="error">Please enter a valid password.</label>'),document.getElementById("password_login_apply").classList.add("error"),document.getElementById("password_login_apply").classList.add("error"),$("#btn1").html("Login")):($("#errorlogin_apply").html('<label for="email_login_apply" class="error">Please enter a valid email.</label>'),document.getElementById("email_login_apply").classList.add("error"),document.getElementById("email_login_apply").classList.add("error"),$("#btn1").html("Login"))}}),!1}$("#login_form_apply").validate({rules:{email_login_apply:{required:!0},password_login_apply:{required:!0}},messages:{email_login_apply:{required:"Please enter email address"},password_login_apply:{required:"Please enter password"}},submitHandler:e})}),$(document).on("click","[data-toggle*=modal]",function(){$("[role*=dialog]").each(function(){switch($(this).css("display")){case"block":$("#"+$(this).attr("id")).modal("hide")}})});