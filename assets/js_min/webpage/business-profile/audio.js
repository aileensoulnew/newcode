function checkvalue(){var o=$.trim(document.getElementById("tags").value),t=$.trim(document.getElementById("searchplace").value);return""==o&&""==t?!1:void 0}function check(){var o=$.trim(document.getElementById("tags1").value),t=$.trim(document.getElementById("searchplace1").value);return""==o&&""==t?!1:void 0}function followuser_two(o){$.ajax({type:"POST",url:base_url+"business_profile/follow_two",data:"follow_to="+o,success:function(t){if($(".fr"+o).html(t),0!=t.notification.notification_count){var n=t.notification.notification_count,i=t.notification.to_id;show_header_notification(n,i)}}})}function unfollowuser_two(o){$.ajax({type:"POST",url:base_url+"business_profile/unfollow_two",data:"follow_to="+o,success:function(t){$(".fr"+o).html(t)}})}function contact_person_query(o,t){$.ajax({type:"POST",url:base_url+"business_profile/contact_person_query",data:"toid="+o+"&status="+t,success:function(n){contact_person_model(o,t,n)}})}function contact_person_model(o,t,n){1==n?"pending"==t?($(".biderror .mes").html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id="+o+" onClick='contact_person("+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")):"confirm"==t?($(".biderror .mes").html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id="+o+" onClick='contact_person("+o+")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>"),$("#bidmodal").modal("show")):contact_person(o):($("#query .mes").html("<div class='pop_content'>Sorry, we can't process this request at this time."),$("#query").modal("show"))}function contact_person(o){$.ajax({type:"POST",url:base_url+"business_profile/contact_person",data:"toid="+o,dataType:"json",success:function(o){if($("#contact_per").html(o),0!=o.co_notification.co_notification_count){var t=o.co_notification.co_notification_count,n=o.co_notification.co_to_id;show_contact_notification(t,n)}}})}$(document).on("keydown",function(o){27===o.keyCode&&$("#query").modal("hide")}),$(document).ready(function(){$(".blocks").jMosaic({items_type:"li",margin:0}),$(".pictures").jMosaic({min_row_height:150,margin:3,is_first_big:!0})}),$(window).load(function(){}),$(window).resize(function(){}),$(document).ready(function(){$("html,body").animate({scrollTop:330},500)});