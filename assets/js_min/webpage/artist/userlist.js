function artistic_userlist(e){isProcessing||(isProcessing=!0,$.ajax({type:"POST",url:base_url+"artist/ajax_userlist/?page="+e,data:{total_record:$("#total_record").val()},dataType:"html",beforeSend:function(){$("#loader").show()},complete:function(){$("#loader").hide()},success:function(e){$(".loader").remove(),$(".job-contact-frnd ").append(e);var t=$(".post-design-box").length;0==t?$("#dropdownclass").addClass("no-post-h2"):$("#dropdownclass").removeClass("no-post-h2"),isProcessing=!1}}))}function divClicked(){var e=$(this).html(),t=$("<textarea />");t.val(e),$(this).replaceWith(t),t.focus(),t.blur(editableTextBlurred)}function editableTextBlurred(){var e=$(this).val(),t=$("<a>");(e.match(/^\s*$/)||""==e)&&(e="Current Work"),t.html(e),$(this).replaceWith(t),t.click(divClicked),$.ajax({url:base_url+"artist/art_designation",type:"POST",data:{designation:e},success:function(e){}})}function checkvalue(){var e=$.trim(document.getElementById("tags").value),t=$.trim(document.getElementById("searchplace").value);return""==e&&""==t?!1:void 0}function check(){var e=$.trim(document.getElementById("tags1").value),t=$.trim(document.getElementById("searchplace1").value);return""==e&&""==t?!1:void 0}function myFunction(){document.getElementById("upload-demo").style.visibility="hidden",document.getElementById("upload-demo-i").style.visibility="hidden",document.getElementById("message1").style.display="block"}function showDiv(){document.getElementById("row1").style.display="block",document.getElementById("row2").style.display="none"}function followuser(e){$.ajax({type:"POST",url:base_url+"artist/follow",dataType:"json",data:"follow_to="+e,success:function(t){if($(".fruser"+e).html(t.follow),$("#countfollow").html(t.count),0!=t.notification.notification_count){var o=t.notification.notification_count,n=t.notification.to_id;show_header_notification(o,n)}}})}function unfollowuser(e){$.ajax({type:"POST",url:base_url+"artist/unfollow",dataType:"json",data:"follow_to="+e,success:function(t){$(".fruser"+e).html(t.follow),$("#countfollow").html(t.count)}})}function updateprofilepopup(e){$("#bidmodal-2").modal("show")}function readURL(e){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(e){document.getElementById("preview").style.display="block",$("#preview").attr("src",e.target.result)},t.readAsDataURL(e.files[0])}}function picpopup(){$(".biderror .mes").html("<div class='pop_content'>Only Image Type Supported"),$("#bidmodal").modal("show")}$(document).ready(function(){artistic_userlist(),$(window).scroll(function(){if($(window).scrollTop()+$(window).height()>=$(document).height()){var e=$(".page_number:last").val(),t=$(".total_record").val(),o=$(".perpage_record").val();if(parseInt(o)<=parseInt(t)){var n=t/o;n=parseInt(n,10);var l=t%o;if(l>0&&(n+=1),parseInt(e)<=parseInt(n)){var a=parseInt($(".page_number:last").val())+1;artistic_userlist(a)}}}})});var isProcessing=!1;$(document).ready(function(){$("a.designation").click(divClicked)});var modal=document.getElementById("myModal"),btn=document.getElementById("myBtn"),span=document.getElementsByClassName("close")[0];btn.onclick=function(){modal.style.display="block"},span.onclick=function(){modal.style.display="none"},window.onclick=function(e){e.target==modal&&(modal.style.display="none")},$uploadCrop=$("#upload-demo").croppie({enableExif:!0,viewport:{width:1250,height:350,type:"square"},boundary:{width:1250,height:350}}),$(".upload-result").on("click",function(e){$uploadCrop.croppie("result",{type:"canvas",size:"viewport"}).then(function(e){$.ajax({url:base_url+"artist/ajaxpro",type:"POST",data:{image:e},success:function(t){html='<img src="'+e+'" />',html&&window.location.reload()}})})}),$(".cancel-result").on("click",function(e){document.getElementById("row2").style.display="block",document.getElementById("row1").style.display="none",document.getElementById("message1").style.display="none"}),$("#upload").on("change",function(){var e=new FileReader;e.onload=function(e){$uploadCrop.croppie("bind",{url:e.target.result}).then(function(){console.log("jQuery bind complete")})},e.readAsDataURL(this.files[0])}),$("#upload").on("change",function(){var e=new FormData;return e.append("image",$("#upload")[0].files[0]),files=this.files,size=files[0].size,files[0].name.match(/.(jpg|jpeg|png|gif)$/i)?size>10485760?(alert("Allowed file size exceeded. (Max. 10 MB)"),document.getElementById("row1").style.display="none",document.getElementById("row2").style.display="block",!1):void $.ajax({url:base_url+"artist/image",type:"POST",data:e,processData:!1,contentType:!1,success:function(e){}}):(picpopup(),document.getElementById("row1").style.display="none",document.getElementById("row2").style.display="block",$("#upload").val(""),!1)}),$("#profilepic").change(function(){return profile=this.files,profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)?void readURL(this):($("#profilepic").val(""),picpopup(),!1)}),$(document).on("keydown",function(e){27===e.keyCode&&$("#bidmodal-2").modal("hide")});