function checkvalue(){var e=$.trim(document.getElementById("tags").value),t=$.trim(document.getElementById("searchplace").value);return""==e&&""==t?!1:void 0}function busSelectCheck(e){var t=document.getElementById("industriyal").value,n=document.getElementById("business_type").value;if(e){var i=document.getElementById("busOption").value;i==e.value?(document.getElementById("busDivCheck").style.display="block",document.getElementById("bustype").style.display="block",document.getElementById("other-business").style.display="block",$("#busDivCheck .half-width label").html('Other Business Type:<span style="color:red;" >*</span>')):(document.getElementById("busDivCheck").style.display="none",0==t&&0==n&&($("#busDivCheck .half-width label").text(""),$("#bustype-error").remove()),0==t&&0!=n&&($("#busDivCheck .half-width label").text(""),$("#bustype-error").remove()))}else document.getElementById("bustype").style.display="none",$("#busDivCheck .half-width label").text("")}function indSelectCheck(e){e?(indOptionValue=document.getElementById("indOption").value,indOptionValue==e.value?(document.getElementById("indDivCheck").style.display="block",document.getElementById("indtype").style.display="block",document.getElementById("other-category").style.display="block"):document.getElementById("indDivCheck").style.display="none"):document.getElementById("indDivCheck").style.display="none"}function check(){var e=$.trim(document.getElementById("tags1").value),t=$.trim(document.getElementById("searchplace1").value);return""==e&&""==t?!1:void 0}$(document).ready(function(){$("#industriyal").on("change",function(){var e=$(this).val();e?$.ajax({type:"POST",url:base_url+"business_profile/ajax_data",data:"industry_id="+e,success:function(e){$("#subindustriyal").html(e)}}):$("#subindustriyal").html('<option value="">Select industriyal first</option>')})}),jQuery.validator.addMethod("noSpace",function(e,t){return""==e||0!=e.trim().length},"No space please and don't leave it empty"),$.validator.addMethod("regx",function(e,t,n){return e?n.test(e):!0},"Only space, only number and only special characters are not allow"),$(document).ready(function(){$("#businessdis").validate({rules:{business_type:{required:!0},industriyal:{required:!0},subindustriyal:{required:!0},business_details:{required:!0,regx:/^[-@.\/#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/}},messages:{business_type:{required:"Business type is required."},industriyal:{required:"Industrial is required."},subindustriyal:{required:"Subindustrial is required."},business_details:{required:"Business details is required."}}})}),$(".alert").delay(3200).fadeOut(300),$(document).ready(function(){var e=$("#business_details"),t=e.val().length;e[0].focus(),e[0].setSelectionRange(t,t)});