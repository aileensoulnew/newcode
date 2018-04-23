
//CHECK SEARCH KEYWORD AND LOCATION BLANK START
function checkvalue() {
                    var searchkeyword = $.trim(document.getElementById('tags').value);
                    var searchplace = $.trim(document.getElementById('searchplace').value);
                    if (searchkeyword == "" && searchplace == "") {
                        return  false;
                    }
                }
                function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
//CHECK SEARCH KEYWORD AND LOCATION BLANK END
//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END

//FORM FILL UP VALIDATION START
 $.validator.addMethod("regx1", function (value, element, regexpr) {
                    //return value == '' || value.trim().length != 0; 
                    if (!value)
                    {
                        return true;
                    } else
                    {
                        return regexpr.test(value);
                    }
                }, "Upto 8 digit number allow");

                $(document).ready(function () {
                    $("#freelancer_post_rate").validate({
                        rules: {
                            hourly: {
                                number: true,
                                regx1: /^.{0,8}$/
                            },
                        },

                        messages: {
                        },
                    });
                });
//FORM FILL UP VALIDATION END

