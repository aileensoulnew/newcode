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
            get_csrf_token_name: get_csrf_hash,
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'registration/check_login',
            data: post_data,
            dataType: "json",
            beforeSend: function ()
            {
                $("#error").fadeOut();
                $(".btn1").html('Login ...');
            },
            success: function (response)
            {
                if (response.data == "ok") {
                    $(".btn1").html('<img src= ' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login');
                    window.location = base_url + "dashboard";
                } else if (response.data == "password") {
                    $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                    document.getElementById("password_login").classList.add('error');
                    document.getElementById("password_login").classList.add('error');
                    $(".btn1").html('Login');
                } else {
                    $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                    document.getElementById("email_login").classList.add('error');
                    document.getElementById("email_login").classList.add('error');
                    $(".btn1").html('Login');
                }
            }
        });
        return false;
    }
    /* login submit */
});




$(document).ready(function () {
    var $lines = $('.top-middle h3.text-effect');
    $lines.hide();
    var lineContents = new Array();
    var terminal = function () {

        var skip = 0;
        typeLine = function (idx) {
            idx == null && (idx = 0);
            var element = $lines.eq(idx);
            var content = lineContents[idx];
            if (typeof content == "undefined") {
                $('.skip').hide();
                return;
            }
            var charIdx = 0;

            var typeChar = function () {
                var rand = Math.round(Math.random() * 150) + 25;
                setTimeout(function () {
                    var char = content[charIdx++];
                    element.append(char);
                    if (typeof char !== "undefined")
                        typeChar();
                    else {
                        element.append('<br/><span class="output">' + element.text().slice(9, -1) + '</span>');
                        element.removeClass('active');
                        typeLine(++idx);
                    }
                }, skip ? 0 : rand);
            }
            content = '' + content + '';
            element.append(' ').addClass('active');
            typeChar();
        }

        $lines.each(function (i) {
            lineContents[i] = $(this).text();
            $(this).text('').show();
        });

        typeLine();
    }

    terminal();
});
function login()
{
    document.getElementById('error1').style.display = 'none';
}

// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function () {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
// forgot password script end 

$(document).ready(function () { 
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
    });
    /* validation */
});

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $("#myModal").hide();
    }
});


$(".alert").delay(3200).fadeOut(300);