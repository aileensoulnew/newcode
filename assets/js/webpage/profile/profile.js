$(document).ready(function () {
    $("#basicinfo").validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            email_profile: {
                required: true,
                remote: {
                    url: base_url + "profile/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email_profile").val();
                        },
                        //get_csrf_token_name: get_csrf_hash,
                    },async: false
                },
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
            gen: {
                required: true,
            }
        },
        messages: {
            first_name: {
                required: "First Name Is Required.",
            },
            last_name: {
                required: "Last Name Is Required."
            },
            email_profile: {
                required: "Email Address Is Required.",
                remote: "Email already exists"
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
            gen: {
                required: "Gender Is Required."
            }
        },
        //  submitHandler: submitRegisterForm
    });
});

$("#submit").click(function () {
    var selday = $("#selday").val();
    var selmonth = $("#selmonth").val();
    var selyear = $("#selyear").val();
    var post_data = {
        'selday': selday,
        'selmonth': selmonth,
        'selyear': selyear,
        get_csrf_token_name: get_csrf_hash,
    }

    var todaydate = new Date();
    var dd = todaydate.getDate();
    var mm = todaydate.getMonth() + 1;
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
            } else if (selmonth == 2) { 
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
});
//script for click on - change to + Start
$(document).ready(function () {
    $('#toggle').on('click', function () {
        if ($('#panel-heading').hasClass('active')) {
            $('#panel-heading').removeClass('active');
        } else {
            $('#panel-heading').addClass('active');
            $('#panel-heading1').removeClass('active');
        }
    });
});
//script for click on - change to + End
