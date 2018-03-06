


function checkvalue_search() {

    var searchkeyword = document.getElementById('rec_search_title').value;
    var searchplace = document.getElementById('rec_search_loc').value;

    if (searchkeyword == "" && searchplace == "")
    {
        //  alert('Please enter Keyword');
        return false;
    }
}


//Leave Page on add and edit post page start
function leave_page(clicked_id)
{


    var searchkeyword = document.getElementById('rec_search_title').value;
    var searchplace = document.getElementById('rec_search_loc').value;

    if (clicked_id == 4)
    {
        if (searchkeyword != "" && searchplace != "")
        {
            return checkvalue_search;
        }

    }

    return home(clicked_id, searchkeyword, searchplace);
}


function home(clicked_id, searchkeyword, searchplace)
{


    $('.biderror .mes').html("<div class='pop_content'> Do you want to discard your changes?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='home_profile(" + clicked_id + ',' + '"' + searchkeyword + '"' + ',' + '"' + searchplace + '"' + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');

}

function home_profile(clicked_id, searchkeyword, searchplace) {

    var url, data;


    if (clicked_id == 4) {
        url = base_url + "search/recruiter_search";


        data = 'id=' + clicked_id + '&skills=' + searchkeyword + '&searchplace=' + searchplace;

    }


    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (data) {
            if (clicked_id == 1)
            {

                window.location = base_url + "recruiter/recommen_candidate";
            } else if (clicked_id == 2)
            {
                window.location = base_url + "recruiter/rec_profile";
            } else if (clicked_id == 3)
            {
                window.location = base_url + "recruiter/rec_basic_information";
            } else if (clicked_id == 4)
            {


                if (searchkeyword == "")
                {

                    window.location = base_url + "search/recruiter_search/" + 0 + "/" + searchplace;

                } else if (searchplace == "")
                {

                    window.location = base_url + "search/recruiter_search/" + searchkeyword + "/" + 0;
                } else
                {
                    window.location = base_url + "search/recruiter_search/" + searchkeyword + "/" + searchplace;
                }



            } else if (clicked_id == 5)
            {
                window.location = base_url + "profiles/" + user_slug;
            } else if (clicked_id == 6)
            {
                window.location = base_url + "profile";
            } else if (clicked_id == 7)
            {
                window.location = base_url + "registration/changepassword";
            } else if (clicked_id == 8)
            {
                window.location = base_url + "dashboard/logout";
            } else if (clicked_id == 9)
            {
                location.href = 'javascript:history.back()';
            } else
            {
                alert("edit profilw");
            }

        }
    });


}
function imgval() {


    var minyear = document.getElementById('minyear').value;
    var maxyear = document.getElementById('maxyear').value;

    var min_exper;
    min_exper = (minyear * 12);
    max_exper = (maxyear * 12);
    if (min_exper > max_exper) {
        alert("Minimum experience is not greater than maximum experience");
        return false;

    }

}

$.validator.addMethod("regx", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
    // return regexpr.test(value);
}, "Only space, only number and only special characters are not allow");

jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("reg_candidate", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Float number is not allowed");


$.validator.addMethod("greaterThan",
        function (value, element, param) {
            var $otherElement = $(param);
            if (!value)
            {
                return true;
            } else
            {
                return parseInt(value, 10) > parseInt($otherElement.val(), 10);
            }
        });

$.validator.addMethod("greaterThan1",
        function (value, element, param) {
            //alert(value);alert(element);alert(param);
            var $min = $(param);
            if (this.settings.onfocusout) {
                $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                    $(element).valid();
                });
            }

            if (!value)
            {
                return true;
            } else
            {

                // return parseInt(value) > parseInt($min.val());
                return (value) > ($min.val());
            }
        }, "Max must be greater than min");



$.validator.addMethod("greaterThanmonth",
        function (value, element, param) {
            //alert(value); alert(element); alert(param);alert("#maxyear");
            var $maxyear = $('#maxyear');
            var maxyear = parseInt($maxyear.val());

            var $minyear = $('#minyear');
            var minyear = parseInt($minyear.val());

            var $min = $(param);
            if (this.settings.onfocusout) {
                $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                    $(element).valid();
                });
            }
            if (!value)
            {
                return true;
            } else if ((maxyear == minyear))
            {
                //if((maxyear == minyear) ){// alert("gaai");
                return parseInt(value) >= parseInt($min.val());
            } else
            {
                return true;
            }

        }, "Max month must be greater than min month");


// for date validtaion start

jQuery.validator.addMethod("isValid", function (value, element) {


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

    var todaydate = dd + '/' + mm + '/' + yyyy;
    var regEx = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
    if (!value.match(regEx))
    {

        value = value.split("-");
        var lastDate = value[2] + "/" + value[1] + "/" + value[0];

    } else
    {
        var lastDate = value;
    }


    lastDate = lastDate.split("/");
    var lastdata_new = lastDate[1] + "/" + lastDate[0] + "/" + lastDate[2];
    var lastdata_new_one = new Date(lastdata_new).getTime();

    todaydate = todaydate.split("/");
    var todaydate_new = todaydate[1] + "/" + todaydate[0] + "/" + todaydate[2];
    var todaydate_new_one = new Date(todaydate_new).getTime();


    if (lastdata_new_one >= todaydate_new_one) {
        $('.day').removeClass('error');
        $('.month').removeClass('error');
        $('.year').removeClass('error');
        return true;
    } else {
        $('.day').addClass('error');
        $('.month').addClass('error');
        $('.year').addClass('error');
        return false;
    }
    return lastdata_new_one >= todaydate_new_one;


}, "Last date should be grater than and equal to today date");

$.validator.addMethod("required1", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
   
    if (!value)
    {
        $('.day').addClass('error');
        $('.month').addClass('error');
        $('.year').addClass('error');
        return false;
    } else
    {
        $('.day').removeClass('error');
        $('.month').removeClass('error');
        $('.year').removeClass('error');
        return true;
    }

    // return regexpr.test(value);
}, "Last date of apply is required.");


//date validation end

//jQuery.noConflict();
//
//(function ($) {
//    $(document).ready(function () {

        $("#basicinfo").validate({
            //ignore: [],

            ignore: '*:not([name])',
            rules: {

                post_name: {

                    required: true,
                    regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                    minlength: 10,
                    maxlength: 100

                },
                skills: {

                    required: true,
                    //required:true 
                },

                position: {
                    required: true,
                    number: true,
                    min: 1,
                    reg_candidate: /^-?(([0-9]{0,1000}))$/,
                    maxlength: 4,
                    range: [1, 1000]
                },

                minyear: {

                    required: true
                },

                emp_type: {

                    required: true
                },

                industry: {

                    required: true
                },

                post_desc: {

                    required: true,
                    regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/

                },
                country: {

                    required: true

                },
                state: {

                    required: true

                },
                maxyear: {

                    required: true,
                    greaterThan1: "#minyear"
                            //required:true 
                },

                last_date: {

                    required1: "Last date of apply is required.",
                    isValid: 'Last date should be grater than and equal to today date.'

                },
                minsal: {
                    number: true,
                    maxlength: 11

                            // le:"#maxsal"
                },
                maxsal: {
                    // required: function(element){
                    // return $("#minsal").val().length > 0;
                    // },
                    number: true,
                    min: 0,
                    greaterThan: "#minsal",
                    maxlength: 11

                },
                position_no: {
                    required: true
                },

            },

            messages: {

                post_name: {

                    required: "Jobtitle  is required."
                },
                skills: {

                    required: "Skill  is required."
                },

                position: {
                    required: "You have to select minimum 1 position."
                },
                minyear: {

                    required: "Minimum experience is required."
                },
                emp_type: {

                    required: "Employment type is required."
                },
                industry: {

                    required: "Industry is required."
                },

                post_desc: {

                    required: "Post description is required."

                },
                country: {

                    required: "Country is required."

                },
                state: {

                    required: "State is required."

                },
                maxyear: {

                    required: "Maximum experience is required."
                            // greaterThan1:"Maximum Year Experience should be grater than Minimum Year"

                },

                last_date: {

                    // required: "Last date  Is Required."
                },
                // minsal:{
                //     le:"Minimum salary should be less than Maximum salary"
                // },
                maxsal: {
                    greaterThan: "Maximum salary should be grater than minimum salary."
                },
                position_no: {
                    required: "Number of position required."
                },

            }

        });


//    });
//})(jQuery);




// EDUCATION AUTOCOMPLETE DATA START

    
        function split(val) {
            return val.split(/,\s*/);
        }
        function extractLast(term) {
            return split(term).pop();
        }

        $("#education").bind("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                    $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
                .autocomplete({
                    minLength: 0,
                    source: function (request, response) {
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url + "general/get_degree", {term: extractLast(request.term)}, response);
                    },
                    focus: function () {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function (event, ui) {

                        var terms = split(this.value);
                        if (terms.length <= 20) {
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(", ");
                            return false;
                        } else {
                            var last = terms.pop();
                            $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                            $(this).effect("highlight", {}, 1000);
                            $(this).attr("style", "border: solid 1px red;");
                            return false;
                        }
                    }



                });
    

// EDUCATION AUTOCOMPLETE DATA END


//jQuery.noConflict();
//
//(function ($) {
//
//// alert(data);
//
//
//    $(function () {
//        // alert('hi');
//        $("#searchplace").autocomplete({
//            source: function (request, response) {
//                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//                response($.grep(data1, function (item) {
//                    return matcher.test(item.label);
//                }));
//            },
//            minLength: 1,
//            select: function (event, ui) {
//                event.preventDefault();
//                $("#searchplace").val(ui.item.label);
//                $("#selected-tag").val(ui.item.label);
//                // window.location.href = ui.item.value;
//            }
//            ,
//            focus: function (event, ui) {
//                event.preventDefault();
//                $("#searchplace").val(ui.item.label);
//            }
//        });
//    });
//})(jQuery);

//jQuery.noConflict();
//
//(function ($) {
//
//// alert(data);
//
//
//    $(function () {
//        // alert('hi');
//        $("#tags1").autocomplete({
//            source: function (request, response) {
//                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//                response($.grep(data, function (item) {
//                    return matcher.test(item.label);
//                }));
//            },
//            minLength: 1,
//            select: function (event, ui) {
//                event.preventDefault();
//                $("#tags1").val(ui.item.label);
//                $("#selected-tag").val(ui.item.label);
//                // window.location.href = ui.item.value;
//            }
//            ,
//            focus: function (event, ui) {
//                event.preventDefault();
//                $("#tags1").val(ui.item.label);
//            }
//        });
//    });
//})(jQuery);
//
//
//jQuery.noConflict();
//
//(function ($) {
//
//    $(function () {
//        // alert('hi');
//        $("#searchplace1").autocomplete({
//            source: function (request, response) {
//                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//                response($.grep(data1, function (item) {
//                    return matcher.test(item.label);
//                }));
//            },
//            minLength: 1,
//            select: function (event, ui) {
//                event.preventDefault();
//                $("#searchplace1").val(ui.item.label);
//                $("#selected-tag").val(ui.item.label);
//                // window.location.href = ui.item.value;
//            }
//            ,
//            focus: function (event, ui) {
//                event.preventDefault();
//                $("#searchplace1").val(ui.item.label);
//            }
//        });
//    });
//})(jQuery);


$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#skills2").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_skill", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 20) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join(", ");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }



            });
});

// job title script start


$(function () {

    $("#post_name").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(jobdata, function (item) {
                return matcher.test(item.label);
            }));
        },
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#post_name").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#post_name").val(ui.item.label);
        }
    });
});


$(document).ready(function () {
    $('#country').on('change', function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "recruiter/ajax_data",
                data: 'country_id=' + countryID,
                success: function (html) {
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>');
                }
            });
        } else {
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>');
        }
    });

    $('#state').on('change', function () {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: 'POST',
                url: base_url + "recruiter/ajax_data",
                data: 'state_id=' + stateID,
                success: function (html) {
                    $('#city').html(html);
                }
            });
        } else {
            $('#city').html('<option value="">Select state first</option>');
        }
    });
});





// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//btn.onclick = function() {
//    modal.style.display = "block";
//}

// When the user clicks on <span> (x), close the modal
//span.onclick = function() {
//    modal.style.display = "none";
//}

// When the user clicks anywhere outside of the modal, close it
//window.onclick = function(event) {
//    if (event.target == modal) {
//        modal.style.display = "none";
//    }
//}

var $ = jQuery.noConflict();
//OTHER INDUSTRY INSERT START
$(document).on('change', '#industry', function (event) {
   // alert(industry);
   
      var item=$(this);
      var industry=(item.val());
     
      if(industry == 288)
      {
       
            item.val('');

            $('.biderror .mes').html('<div class="message"><h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu"><a id="indus" class="btn">OK</a></div>');
            $('#bidmodal').modal('show');
            //$.fancybox.open('<div class="message" style="width:300px;"><h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu"><a id="indus" class="btn">OK</a></div>');
   
             $('.message #indus').on('click', function () {

                $("#other_indu").removeClass("keyskill_border_active");
                $('#field_error').remove();
var x = $.trim(document.getElementById("other_indu").value);
            if (x == '') {
                $("#other_indu").addClass("keyskill_border_active");
                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_indu');
                return false;
            } else {
      var $textbox = $('.message').find('input[type="text"]'),
      textVal  = $textbox.val();
      $.ajax({
                          type: 'POST',
                          url: base_url + 'recruiter/recruiter_other_industry',
                          data: 'other_industry=' + textVal,
                          success: function (response) {
                      
                               if(response == 0)
                              {
                                $("#other_indu").addClass("keyskill_border_active");
                                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written industry already available in industry Selection</span>').insertAfter('#other_indu');
                              }
                              else if(response == 1)
                              {
                               
                                $("#other_indu").addClass("keyskill_border_active");
                                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty industry  is not valid</span>').insertAfter('#other_indu');
                              }  
                              else
                              {
                                   //$.fancybox.close();
                                   $('#bidmodal').modal('hide');
                                   $('#industry').html(response);
                              }
                          }
                      });
                  }
                  });
      }
     
   });
//OTHER INDUSTRY INSERT END



$(function () {


    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    var today = yyyy;



    $("#example2").dateDropdowns({
        submitFieldName: 'last_date',
        submitFormat: "dd/mm/yyyy",
        minYear: today,
        maxYear: today + 1,
        defaultDate: date_picker,
        daySuffixes: false,
        monthFormat: "short",
        dayLabel: 'DD',
        monthLabel: 'MM',
        yearLabel: 'YYYY',
        //startDate: today,

    });
 $(".day").attr('tabindex', 11);
    $(".month").attr('tabindex', 12);
    $(".year").attr('tabindex', 13);
});


//all popup close close using esc start 
$(document).ready(function () {
 $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $('#bidmodal').modal('hide');
       // $.fancybox.close();
        $( "#dropdown-content_hover" ).hide();
    }
   });  
});
//all popup close close using esc end 
