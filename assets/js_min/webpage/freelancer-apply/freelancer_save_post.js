function freelancerwork_save(e){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"freelancer/ajax_freelancer_save_post?page="+e,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){document.getElementById("loader").style.display="block"},complete:function(){document.getElementById("loader").style.display="none"},success:function(e){$(".job-contact-frnd1").append(e);var a=$(".job-contact-frnd1 .all-job-box").length;0==a&&$(".job-contact-frnd1").addClass("cust-border");var o=$(".post-design-box").length;0==o?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function divClicked(){var e=$(this).html(),a=$("<textarea/>");a.val(e),$(this).replaceWith(a),a.focus(),a.blur(editableTextBlurred)}function capitalize(e){return e[0].toUpperCase()+e.slice(1)}function editableTextBlurred(){var e=$(this).val(),a=$("<a>");(e.match(/^\s*$/)||""==e)&&(e="Designation"),a.html(capitalize(e)),$(this).replaceWith(a),a.click(divClicked),$.ajax({url:base_url+"freelancer/designation",type:"POST",data:{designation:e},success:function(e){}})}function remove_post(e){var a="save";$.ajax({type:"POST",url:base_url+"freelancer/freelancer_delete_apply",data:"app_id="+e+"&para="+a,success:function(a){$("#postdata"+e).html(a),$("#postdata"+e).remove();var o=$(".job-contact-frnd1 .all-job-box").length;if("0"==o){var t='<div class="art-img-nn"><div class="art_no_post_img"><img src="../assets/img/free-no1.png"></div><div class="art_no_post_text"> No Saved Projects Found.</div></div>';$(".job-contact-frnd1").html(t),$(".job-contact-frnd1").addClass("cust-border")}}})}function removepopup(e){$(".biderror .mes").html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id="+e+" onClick='remove_post("+e+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")}function picpopup(){$(".biderror .mes").html("<div class='pop_content'>Please select only Image type File.(jpeg,jpg,png,gif)"),$("#bidmodal").modal("show")}$(document).ready(function(){freelancerwork_save(),$(window).scroll(function(){if($(window).scrollTop()>=.7*($(document).height()-$(window).height())){var e=$(".page_number:last").val(),a=$(".total_record").val(),o=$(".perpage_record").val();if(parseInt(o)<=parseInt(a)){var t=a/o;t=parseInt(t,10);var n=a%o;if(n>0&&(t+=1),parseInt(e)<=parseInt(t)){var s=parseInt($(".page_number:last").val())+1;freelancerwork_save(s)}}}})});var isProcessing=!1;$(document).ready(function(){$("a.designation").click(divClicked)}),$(document).on("keydown",function(e){27===e.keyCode&&$("#bidmodal").modal("hide")}),$(document).on("keydown",function(e){27===e.keyCode&&$("#bidmodal-2").modal("hide")}),$(document).ready(function(){$("html,body").animate({scrollTop:265},100)});