$(document).ready(function(){
    $('#country').on('change',function(){ 
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url: base_url + "artistic/ajax_data",
                //url:'<?php echo base_url() . "artistic/ajax_data"; ?>',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select State First</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select Country First</option>');
            $('#city').html('<option value="">Select State First</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url: base_url + "artistic/ajax_data",
                //url:'<?php echo base_url() . "artistic/ajax_data"; ?>',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select State First</option>'); 
        }
    });
});




$(document).ready(function () { 

                $("#address").validate({

                    rules: {

                        country: {

                            required: true,
                         
                        },

                         state: {

                            required: true,
                            
                          
                        },
                      
                        
                    },

                    messages: {

                        country: {

                            required: "Country is required.",
                            
                        },

                        state: {

                            required: "State is required.",
                            
                        },
                       
                        
                },

                });
                   });


 $(".alert").delay(3200).fadeOut(300);


 jQuery(document).ready(function($) {  
$(window).load(function(){
  $('#preloader').fadeOut('slow',function(){$(this).remove();});
});
});


 
  function checkvalue() {
                           
    var searchkeyword =$.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
                            
    if (searchkeyword == "" && searchplace == "") {
            return false;
             }
}


function check() {
        var keyword = $.trim(document.getElementById('tags1').value);
        var place = $.trim(document.getElementById('searchplace1').value);
        if (keyword == "" && place == "") {
            return false;
        }
}


$(document).ready(function () {
var input = $("#pincode");
var len = input.val().length;
input[0].focus();
input[0].setSelectionRange(len, len);
 });