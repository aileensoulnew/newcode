function removepopup(e){$(".biderror .mes").html("<div class='pop_content'>Do you want to remove this candidate?<div class='model_ok_cancel'><a class='okbtn' id="+e+" onClick='remove_user("+e+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")}function updateprofilepopup(e){$("#bidmodal-2").modal("show")}function myFunction(){document.getElementById("upload-demo").style.visibility="hidden",document.getElementById("upload-demo-i").style.visibility="hidden",document.getElementById("message1").style.display="block"}function showDiv(){document.getElementById("row1").style.display="block",document.getElementById("row2").style.display="none",$(".cr-image").attr("src",""),$("#upload").val("")}function remove_user(e){$.ajax({type:"POST",url:base_url+"recruiter/remove_candidate",data:"save_id="+e,success:function(t){$("#removeuser"+e).html(t),$("#removeuser"+e).removeClass();var o=$(".contact-frnd-post .job-contact-frnd .profile-job-post-detail").length;if("0"==o){var n="<div class='art-img-nn'><div class='art_no_post_img'><img src='"+base_url+"assets/img/job-no1.png'/></div><div class='art_no_post_text'>No Saved Candidate  Available.</div></div>";$(".contact-frnd-post").html(n)}}})}function divClicked(){var e=$(this).html(),t=$("<textarea/>");t.val(e),$(this).replaceWith(t),t.focus(),t.blur(editableTextBlurred)}function editableTextBlurred(){var e=$(this).val(),t=$("<a>");(e.match(/^\s*$/)||""==e)&&(e="Designation"),t.html(e),$(this).replaceWith(t),t.click(divClicked),$.ajax({url:base_url+"recruiter/ajax_designation",type:"POST",data:{designation:e},success:function(e){}})}function readURL(e){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(e){document.getElementById("preview").style.display="block",$("#preview").attr("src",e.target.result)},t.readAsDataURL(e.files[0])}}function picpopup(){$(".biderror .mes").html("<div class='pop_content'>Only image Type is Supported"),$("#bidmodal").modal("show")}function save_candidate(e){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"recruiter/ajax_saved_candidate?page="+e,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){"undefined"==e?$(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="'+base_url+'images/loading.gif"/></p>'):$("#loader").show()},complete:function(){$("#loader").hide()},success:function(e){$(".loader").remove(),$(".job-contact-frnd").append(e);var t=$(".post-design-box").length;0==t?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function checkvalue(){var e=$.trim(document.getElementById("rec_search_title").value),t=$.trim(document.getElementById("rec_search_loc").value);return""==e&&""==t?!1:void 0}function check(){var e=$.trim(document.getElementById("tags1").value),t=$.trim(document.getElementById("searchplace1").value);return""==e&&""==t?!1:void 0}function updateprofilepopup(e){document.getElementById("upload-demo-one").style.display="none",document.getElementById("profi_loader").style.display="none",document.getElementById("upload-one").value=null,$("#bidmodal-2").modal("show")}var modal=document.getElementById("myModal"),btn=document.getElementById("myBtn"),span=document.getElementsByClassName("close")[0];span.onclick=function(){modal.style.display="none"},window.onclick=function(e){e.target==modal&&(modal.style.display="none")},$uploadCrop=$("#upload-demo").croppie({enableExif:!0,viewport:{width:1250,height:350,type:"square"},boundary:{width:1250,height:350}}),$(".upload-result").on("click",function(e){$uploadCrop.croppie("result",{type:"canvas",size:"viewport"}).then(function(e){$.ajax({url:base_url+"recruiter/ajaxpro",type:"POST",data:{image:e},success:function(e){e&&($("#row2").html(e),document.getElementById("row2").style.display="block",document.getElementById("row1").style.display="none",document.getElementById("message1").style.display="none",document.getElementById("upload-demo").style.visibility="visible",document.getElementById("upload-demo-i").style.visibility="visible")}})})}),$(".cancel-result").on("click",function(e){document.getElementById("row2").style.display="block",document.getElementById("row1").style.display="none",document.getElementById("message1").style.display="none",$(".cr-image").attr("src","")}),$("#upload").on("change",function(){var e=new FileReader;e.onload=function(e){$uploadCrop.croppie("bind",{url:e.target.result}).then(function(){console.log("jQuery bind complete")})},e.readAsDataURL(this.files[0])}),$("#upload").on("change",function(){var e=new FormData;return e.append("image",$("#upload")[0].files[0]),files=this.files,size=files[0].size,files[0].name.match(/.(jpg|jpeg|png|gif)$/i)?size>26214400?(alert("Allowed file size exceeded. (Max. 25 MB)"),document.getElementById("row1").style.display="none",document.getElementById("row2").style.display="block",!1):void $.ajax({url:base_url+"recruiter/image",type:"POST",data:e,processData:!1,contentType:!1,success:function(e){}}):(picpopup(),document.getElementById("row1").style.display="none",document.getElementById("row2").style.display="block",!1)}),$(document).ready(function(){$("a.designation").click(divClicked)}),$(document).on("keydown",function(e){27===e.keyCode&&$("#bidmodal").modal("hide")}),$(document).on("keydown",function(e){27===e.keyCode&&$("#bidmodal-2").modal("hide")}),$(document).ready(function(){$("html,body").animate({scrollTop:265},100)}),$(document).ready(function(){save_candidate(),$(window).scroll(function(){if($(window).scrollTop()>=.7*($(document).height()-$(window).height())){var e=$(".page_number:last").val(),t=$(".total_record").val(),o=$(".perpage_record").val();if(parseInt(o)<=parseInt(t)){var n=t/o;n=parseInt(n,10);var a=t%o;if(a>0&&(n+=1),parseInt(e)<=parseInt(n)){var d=parseInt($(".page_number:last").val())+1;save_candidate(d)}}}})});var isProcessing=!1;$uploadCrop1=$("#upload-demo-one").croppie({enableExif:!0,viewport:{width:200,height:200,type:"square"},boundary:{width:300,height:300}}),$("#upload-one").on("change",function(){document.getElementById("upload-demo-one").style.display="block";var e=new FileReader;e.onload=function(e){$uploadCrop1.croppie("bind",{url:e.target.result}).then(function(){console.log("jQuery bind complete")})},e.readAsDataURL(this.files[0])}),$(document).ready(function(){function e(){$uploadCrop1.croppie("result",{type:"canvas",size:"viewport"}).then(function(e){$.ajax({url:base_url+"recruiter/user_image_insert1",type:"POST",data:{image:e},beforeSend:function(){$("#profi_loader").show()},complete:function(){},success:function(e){$("#profi_loader").hide(),$("#bidmodal-2").modal("hide"),$(".user-pic").html(e),document.getElementById("upload-one").value=null,document.getElementById("upload-demo-one").value=""}})})}$("#userimage").validate({rules:{profilepic:{required:!0}},messages:{profilepic:{required:"Photo Required"}},submitHandler:e})});