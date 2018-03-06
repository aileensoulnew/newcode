$(document).ready(function () {
    $("#advertise").validate({
        rules: {
            firstname: {
                required: true,
            },
            lastname: {
                required: true,
            },
            email: {
                required: true,
            },
            message: {
                required: true,
            }

        },

        messages:
                {
                    firstname: {
                        required: "Please enter first name",
                    },
                    lastname: {
                        required: "Please enter last name",
                    },
                    email: {
                        required: "Please enter email address",

                    },
                    message: {
                        required: "Please enter your requirement",
                    },

                },
        submitHandler: submitRegisterForm
    });
    /* register submit */
    function submitRegisterForm()
    {
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var email = $("#email").val();
        var message = $("#message").val();

        var post_data = {
            'firstname': firstname,
            'lastname': lastname,
            'email': email,
            'message': message,
            //get_csrf_token_name : get_csrf_hash,
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'advertise_with_us/advertise_insert',
            data: post_data,
            success: function (response)
            {
                if (response == "ok") {

                    $("#firstname").val('');
                    $("#lastname").val('');
                    $("#email").val('');
                    $("#message").val('');

                    $('.biderror .mes').html("<div class='pop_content'>Thank you for send advertise enquiry. Our executive contact to you soon!!!</div>");
                    $('#bidmodal').modal('show');

                } else {

                    $('.biderror .mes').html("<div class='pop_content'>Your advertise enquiry not send successfully.</div>");
                    $('#bidmodal').modal('show');
                }
            }
        });
        return false;
    }
});


$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal').modal('hide');
    }
});
