$(document).ready(function () {
    // text animation effect 
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

$(document).ready(function () {
    $("#feedback_form").validate({
        rules: {
            feedback_firstname: {
                required: true,
            },
            feedback_lastname: {
                required: true,
            },
            feedback_email: {
                required: true,
            },
            feedback_subject: {
                required: true,
            },
            feedback_message: {
                required: true,
            }

        },

        messages:
                {
                    feedback_firstname: {
                        required: "Please enter first name",
                    },
                    feedback_lastname: {
                        required: "Please enter last name",
                    },
                    feedback_email: {
                        required: "Please enter email address",

                    },
                    feedback_subject: {
                        required: "Please enter subject",
                    },

                    feedback_message: {
                        required: "Please enter your feedback",
                    }

                },
        submitHandler: submitRegisterForm
    });
    /* register submit */
    function submitRegisterForm()
    {
        var feedback_firstname = $("#feedback_firstname").val();
        var feedback_lastname = $("#feedback_lastname").val();
        var feedback_email = $("#feedback_email").val();
        var feedback_subject = $("#feedback_subject").val();
        var feedback_message = $("#feedback_message").val();

        var post_data = {
            'feedback_firstname': feedback_firstname,
            'feedback_lastname': feedback_lastname,
            'feedback_email': feedback_email,
            'feedback_subject': feedback_subject,
            'feedback_message': feedback_message,
            //get_csrf_token_name : get_csrf_hash,
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'feedback/feedback_insert',
            data: post_data,
            // beforeSend: function ()
            // {
            //     $("#register_error").fadeOut();
            //     $("#btn-register").html('Sign Up ...');
            // },
            success: function (response)
            {
                if (response == "ok") {

                    $("#feedback_firstname").val('');
                    $("#feedback_lastname").val('');
                    $("#feedback_email").val('');
                    $("#feedback_subject").val('');
                    $("#feedback_message").val('');

                    $('.biderror .mes').html("<div class='pop_content'>Dear Valuable User , You recently gave us some really helpful <br> comments about our service.we hope that this will help us<br> better. We really appreciate the time you took to <br> help us.thanks for being awesome User..!!</div>");
                     $('#bidmodal').modal('show');

                } else {

                     $('.biderror .mes').html("<div class='pop_content'>Your feedback not send successfully.</div>");
                     $('#bidmodal').modal('show');
                }
            }
        });
        return false;
    }
});


$( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   $('#bidmodal').modal('hide');
                  }
               });  
