function checkvalue(){var t=$.trim(document.getElementById("tags").value),e=$.trim(document.getElementById("searchplace").value);return""==t&&""==e?!1:void 0}function check(){var t=$.trim(document.getElementById("tags1").value),e=$.trim(document.getElementById("searchplace1").value);return""==t&&""==e?!1:void 0}$(document).ready(function(){$("#country").on("change",function(){var t=$(this).val();t?$.ajax({type:"POST",url:base_url+"artist/ajax_data",data:"country_id="+t,success:function(t){$("#state").html(t),$("#city").html('<option value="">Select state first</option>')}}):($("#state").html('<option value="">Select country first</option>'),$("#city").html('<option value="">Select state first</option>'))}),$("#state").on("change",function(){var t=$(this).val();t?$.ajax({type:"POST",url:base_url+"artist/ajax_data",data:"state_id="+t,success:function(t){$("#city").html(t)}}):$("#city").html('<option value="">Select state first</option>')})}),$(document).ready(function(){$("#address").validate({rules:{country:{required:!0},state:{required:!0},city:{required:!0}},messages:{country:{required:"Country is required."},state:{required:"State is required."},city:{required:"City is required."}}})}),jQuery(document).ready(function(t){t(window).load(function(){t("#preloader").fadeOut("slow",function(){t(this).remove()})})}),$(document).ready(function(){var t=$("#pincode"),e=t.val().length;t[0].focus(),t[0].setSelectionRange(e,e)});