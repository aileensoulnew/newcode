$(document).ready(function(){ 

  if(profile_login == 'live'){

        $('#register').modal('show');
  }
    $('#country').on('change',function(){ 
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url: base_url + "artist/ajax_data",
                //url:'<?php echo base_url() . "artist/ajax_data"; ?>',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url: base_url + "artist/ajax_data",
                //url:'<?php echo base_url() . "artist/ajax_data"; ?>',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
});


function login_data() { 
                $('#login').modal('show');
                $('#register').modal('hide');

}

function forgot_profile() {
                $('#forgotPassword').modal('show');
                 $('#login').modal('hide');
                $('#register').modal('hide');
}
 function register_profile() {
                $('#login').modal('hide');
                $('#register').modal('show');
}
// multiple skill start

function forgot_close() {
                $('#login').modal('show');
}

// $( document ).on( 'keydown', function ( e ) {
//     if ( e.keyCode === 27 ) {  
//         $('#forgotPassword').modal('hide');
//         $('#login').modal('show');
//     }
// });



$(function(){
        $('#skills').multiSelect();
    });
    
// other category input open start
$(document).ready(function () {
 var strUser1 = $('#skills').val();
 if(strUser1 != ''){
  $("span").removeClass("custom-mini-select");
 }
 });

function validate(){

     var form = $("#artinfo");
      var other_category = document.getElementById("othercategory").value;

    if(form.valid() == true && other_category != ''){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
    }

  var strUser1 = $('#skills').val();
   if(strUser1 == ''){
  $("#multidropdown").addClass("error");
  }
  if(user_id == ''){
    event.preventDefault();
     $('#register').modal('show');
  }
}

$('#skills').change(function other_category(){
      
       $("#multidropdown").removeClass("error");
       $("#othercategory").removeClass("error");

       var strUser1 = $('#skills').val();
       var strUser =  "'" + strUser1 + "'";
       var n = strUser.includes(26);
      
        if(n == true){ 

            $("span").removeClass("custom-mini-select");
            document.getElementById('other_category').style.display = "block";
        }else if(strUser1 == ''){
          $("span").addClass("custom-mini-select");
        }

        else{ 
            $("span").removeClass("custom-mini-select");
            document.getElementById('other_category').style.display = "none"; 
        }
    });


function otherchange(cat_id){
    if(cat_id == 26){
        var active = document.querySelector(".multi-select-container");
        active.classList.remove("multi-select-container--open"); 
    }
}


function removevalidation(){

   $("#othercategory").removeClass("othercategory_require");
   $('#othercategory_error').remove();    
}

function validation_other(event){ 
  
  $('#othercategory_error').remove(); 
       event.preventDefault();
       var strUser1 = $('#skills').val();
       var strUser =  "'" + strUser1 + "'";

       var length_ele = strUser.split(',');
       var n = strUser.includes(26);
        var other_category = document.getElementById("othercategory").value;
       var category_trim = other_category.trim();

    if(strUser1 != ''){ 
      if(length_ele.length <= 10){
          if(n == true){     
        if(category_trim == ''){
       $("#othercategory").addClass("othercategory_require");
       $('<label class="error" id="othercategory_error">Other art category required. </label>').insertAfter('#othercategory');
        $("#othercategory").addClass("error");
        return false;
        event.preventDefault();
         } 
         else{ 
          if(category_trim){
                $.ajax({                
                   type: 'GET',
                   url: base_url + "artist/check_category",
                   data: 'category=' + category_trim,
                   success: function (data) { 
                    if(data == 'true'){ 
                    $("#othercategory").addClass("othercategory_require");
                   $('<label class="error" id="othercategory_error">This category already exists in art category field. </label>').insertAfter('#othercategory');
                   $("#othercategory").addClass("error");

                   } else{ 
                     $("#artinfo")[0].submit();                  
                   }                 
                   }
               });
           }
         }
       }else if((n == false && category_trim != '') || n == false && category_trim == ''){ 
         $("#artinfo")[0].submit();     
       }
   }else{
       $("#skills").addClass("othercategory_require");
       $('<label class="error" id="othercategory_error">You can select at max 10 Art category. </label>').insertAfter('#skills');
        return false;
        event.preventDefault();
   }
 }else{ 
      return false;
        event.preventDefault();
   }
}

jQuery.validator.addMethod("noSpace", function(value, element) { 
      return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");

$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space and only number are not allow.");


            $(document).ready(function () { 

                $("#artinfo").validate({

                   ignore: '*:not([name])',
                    rules: {

                        firstname: {

                            required: true,
                            regx: /^[a-zA-Z\s]*[a-zA-Z]/,
                            noSpace: true
                        },


                        lastname: {

                            required: true,
                            regx: /^[a-zA-Z\s]*[a-zA-Z]/,
                            noSpace: true
                        },


                        email: {
                            required: true,
                            email: true,
                        },

                        phoneno: {

                            number: true,
                             minlength: 8,
                           maxlength:15
                           
                            
                        },

                        country: {

                            required: true,
                         
                        },

                         state: {

                            required: true,
                            
                          
                        },
                        city: {

                            required: true,
                            
                          
                        },

                        "skills[]": {

                    required: true,

                },          

                    },

                    messages: {

                        firstname: {

                            required: "First name is required.",
                            
                        },

                        lastname: {

                            required: "Last name is required.",
                            
                        },

                        email: {
                            required: "Email id is required",
                            email: "Please enter valid email id",
                            remote: "Email already exists"
                        },

                         country: {

                            required: "Country is required.",
                            
                        },

                        state: {

                            required: "State is required.",
                            
                        },
                        city: {

                            required: "City is required.",
                            
                        },

                         "skills[]": {

                        required: "Skill is required.",
                   
                    },
                        
                    },

                });
                   });


$(document).ready(function () {

                $.validator.addMethod("lowercase", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Email Should be in Small Character");

                $("#register_form").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        email_reg: {
                            required: true,
                            email: true,
//                            lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                            remote: {
                                //url: "<?php echo site_url() . 'registration/check_email' ?>",
                                url: base_url + "registration/check_email",
                                type: "post",
                                data: {
                                    email_reg: function () {
                                        // alert("hi");
                                        return $("#email_reg").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },
                        },
                        password_reg: {
                            required: true,
                        },
                        selday: {
                            required: true,
                        },
                        selmonth: {
                            required: true,
                        },
                        selyear: {
                            required: true,
                        },
                        selgen: {
                            required: true,
                        }
                    },

                    groups: {
                        selyear: "selyear selmonth selday"
                    },
                    messages:
                            {
                                first_name: {
                                    required: "Please enter first name",
                                },
                                last_name: {
                                    required: "Please enter last name",
                                },
                                email_reg: {
                                    required: "Please enter email address",
                                    remote: "Email address already exists",
                                },
                                password_reg: {
                                    required: "Please enter password",
                                },

                                selday: {
                                    required: "Please enter your birthdate",
                                },
                                selmonth: {
                                    required: "Please enter your birthdate",
                                },
                                selyear: {
                                    required: "Please enter your birthdate",
                                },
                                selgen: {
                                    required: "Please enter your gender",
                                }

                            },
                    submitHandler: submitRegisterForm
                });
                /* register submit */
                function submitRegisterForm()
                {
                    var first_name = $("#first_name").val();
                    var last_name = $("#last_name").val();
                    var email_reg = $("#email_reg").val();
                    var password_reg = $("#password_reg").val();
                    var selday = $("#selday").val();
                    var selmonth = $("#selmonth").val();
                    var selyear = $("#selyear").val();
                    var selgen = $("#selgen").val();

                    var post_data = {
                        'first_name': first_name,
                        'last_name': last_name,
                        'email_reg': email_reg,
                        'password_reg': password_reg,
                        'selday': selday,
                        'selmonth': selmonth,
                        'selyear': selyear,
                        'selgen': selgen,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }


                    var todaydate = new Date();
                    var dd = todaydate.getDate();
                    var mm = todaydate.getMonth() + 1; //January is 0!
                    var yyyy = todaydate.getFullYear();

                    if (dd < 10) {
                        dd = '0' + dd
                    }

                    if (mm < 10) {
                        mm = '0' + mm
                    }

                    var todaydate = yyyy + '/' + mm + '/' + dd;
                    var value = selyear + '/' + selmonth + '/' + selday;


                    var d1 = Date.parse(todaydate);
                    var d2 = Date.parse(value);
                    if (d1 < d2) {
                        $(".dateerror").html("Date of birth always less than to today's date.");
                        return false;
                    } else {
                        if ((0 == selyear % 4) && (0 != selyear % 100) || (0 == selyear % 400))
                        {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) { //alert("hii");
                                if (selday == 31 || selday == 30) {
                                    $(".dateerror").html("This month has only 29 days.");
                                    return false;
                                }
                            }
                        } else {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) {
                                if (selday == 31 || selday == 30 || selday == 29) {
                                    $(".dateerror").html("This month has only 28 days.");
                                    return false;
                                }
                            }
                        }
                    }
                    $.ajax({
                        type: 'POST',
                       // url: '<?php echo base_url() ?>registration/reg_insert',
                        url: base_url + "registration/reg_insert",
                        dataType: 'json',
                        data: post_data,
                        beforeSend: function ()
                        {
                            $("#register_error").fadeOut();
                            $("#btn1").html('Create an account ...');
                        },
                        success: function (response)
                        {
                            if (response.okmsg == "ok") {  
                               //  $('#register').modal('hide');
                              //  window.location = "<?php echo base_url()?>artist/registration";
                               window.location = base_url + "artist/registration";

                            } else {
                                $("#register_error").fadeIn(1000, function () {
                                    $("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                                    $("#btn1").html('Create an account');
                                });
                            }
                        }
                    });
                    return false;
                }
            });


function submit_forgot(){
   
   var x = document.getElementById("forgot_email").value;
   if(x != ''){
    $('#forgotPassword').modal('hide');
    event.preventDefault();
  }
}

$(document).ready(function () { //aletr("hii");
                /* validation */
                $("#forgot_password").validate({
                    rules: {
                        forgot_email: {
                            required: true,
                            email: true,
                        }

                    },
                    messages: {
                        forgot_email: {
                            required: "Email Address Is Required.",
                        }
                    },
                     submitHandler: submitforgotForm
                });
                /* validation */

function submitforgotForm()
 {

    var email_login = $("#forgot_email").val();

    var post_data = {
        'forgot_email': email_login,
//            csrf_token_name: csrf_hash
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'profile/forgot_live',
        data: post_data,
        dataType: "json",
        beforeSend: function ()
        {
            $("#error").fadeOut();
//            $("#forgotbuton").html('Your credential has been send in your register email id');
        },
        success: function (response)
        {
            if (response.data == "success") {
                //  alert("login");
                $("#forgotbuton").html(response.message);
                setTimeout(function () {
                    $('#forgotPassword').modal('hide');
                    $('#login').modal('show');
                    $("#forgotbuton").html('');
                    document.getElementById("forgot_email").value = "";
                }, 5000); // milliseconds
                //window.location = base_url + "job/home/live-post";
            } else {
                $("#forgotbuton").html(response.message);

            }
        }
    });
    return false;
}            /* validation */

            });



function login()
            {
                document.getElementById('error1').style.display = 'none';
            }
            //validation for edit email formate form
            $(document).ready(function () {
                /* validation */
                $("#login_form").validate({
                    rules: {
                        email_login: {
                            required: true,
                        },
                        password_login: {
                            required: true,
                        }
                    },
                    messages:
                            {
                                email_login: {
                                    required: "Please enter email address",
                                },
                                password_login: {
                                    required: "Please enter password",
                                }
                            },
                    submitHandler: submitForm
                });
                /* validation */
                /* login submit */
                function submitForm()
                {

                    var email_login = $("#email_login").val();
                    var password_login = $("#password_login").val();
                    var post_data = {
                        'email_login': email_login,
                        'password_login': password_login,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    $.ajax({
                        type: 'POST',
                        //url: '<?php echo base_url() ?>registration/user_check_login',
                        url: base_url + "login/artistic_check_login",
                        data: post_data,
                        dataType: "json",
                        beforeSend: function ()
                        {
                            $("#error").fadeOut();
                            $("#btn1").html('Login');
                        },
                        success: function (response)
                        { 
                            if (response.data == "ok") {                              
                                window.location = base_url + "artist/registration";                              
                            }else if (response.is_artistic == 1) {
                                window.location = base_url + "artist/registration";
                               // window.location = "<?php echo base_url() ?>artist/registration";
                            } else if (response.data == "password") {
                                $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                                document.getElementById("password_login").classList.add('error');
                                document.getElementById("password_login").classList.add('error');
                                $("#btn1").html('Login');
                            } else {
                                $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                                document.getElementById("email_login").classList.add('error');
                                document.getElementById("email_login").classList.add('error');
                                $("#btn1").html('Login');
                            }
                        }
                    });
                    return false;
                }
                /* login submit */
            });
