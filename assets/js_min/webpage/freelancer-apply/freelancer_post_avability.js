jQuery(document).ready(function(e){e(window).load(function(){e("#preloader").fadeOut("slow",function(){e(this).remove()})})}),$.validator.addMethod("regx",function(e,r,a){return e?a.test(e):!0},"Please enter valid number"),$(document).ready(function(){$("#freelancer_post_avability").validate({rules:{work_hour:{required:!1,number:!0,max:168,regx:/^[0-9]*$/}},messages:{work_hour:{max:"Number should be between 0-168"}}})}),$(".alert").delay(3200).fadeOut(300);