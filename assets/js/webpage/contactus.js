$(document).ready(function () {
    //  login form css
    // button ripple effect from @ShawnSauce 's pen http://codepen.io/ShawnSauce/full/huLEH

    $(function () {

        var animationLibrary = 'animate';

        $.easing.easeOutQuart = function (x, t, b, c, d) {
            return -c * ((t = t / d - 1) * t * t * t - 1) + b;
        };
        $('[ripple]:not([disabled],.disabled)')
                .on('mousedown', function (e) {

                    var button = $(this);
                    var touch = $('<touch><touch/>');
                    var size = button.outerWidth() * 1.8;
                    var complete = false;

                    $(document)
                            .on('mouseup', function () {
                                var a = {
                                    'opacity': '0'
                                };
                                if (complete === true) {
                                    size = size * 1.33;
                                    $.extend(a, {
                                        'height': size + 'px',
                                        'width': size + 'px',
                                        'margin-top': -(size) / 2 + 'px',
                                        'margin-left': -(size) / 2 + 'px'
                                    });
                                }

                                touch
                                [animationLibrary](a, {
                                    duration: 500,
                                    complete: function () {
                                        touch.remove();
                                    },
                                    easing: 'swing'
                                });
                            });

                    touch
                            .addClass('touch')
                            .css({
                                'position': 'absolute',
                                'top': e.pageY - button.offset().top + 'px',
                                'left': e.pageX - button.offset().left + 'px',
                                'width': '0',
                                'height': '0'
                            });

                    /* IE8 will not appendChild */
                    button.get(0).appendChild(touch.get(0));

                    touch
                    [animationLibrary]({
                        'height': size + 'px',
                        'width': size + 'px',
                        'margin-top': -(size) / 2 + 'px',
                        'margin-left': -(size) / 2 + 'px'
                    }, {
                        queue: false,
                        duration: 500,
                        'easing': 'easeOutQuart',
                        'complete': function () {
                            complete = true
                        }
                    });
                });
    });

    var username = $('#username'),
            password = $('#password'),
            erroru = $('erroru'),
            errorp = $('errorp'),
            submit = $('#submit'),
            udiv = $('#u'),
            pdiv = $('#p');

    username.blur(function () {
        if (username.val() == '') {
            udiv.attr('errr', '');
        } else {
            udiv.removeAttr('errr');
        }
    });

    password.blur(function () {
        if (password.val() == '') {
            pdiv.attr('errr', '');
        } else {
            pdiv.removeAttr('errr');
        }
    });

    submit.on('click', function (event) {
        event.preventDefault();
        if (username.val() == '') {
            udiv.attr('errr', '');
        } else {
            udiv.removeAttr('errr');
        }
        if (password.val() == '') {
            pdiv.attr('errr', '');
        } else {
            pdiv.removeAttr('errr');
        }
    });
});

// validation for edit email formate form strat 

$(document).ready(function () {
    $("#contact_form").validate({
        rules: {
            contact_name: {
                required: true,
            },
            contactlast_name: {
                required: true,
            },
            contact_email: {
                required: true,
            },
            contact_subject: {
                required: true,
            },
            contact_message: {
                required: true,
            }
        },
        messages:
                {
                    contact_name: {
                        required: "Please enter first name",
                    },
                    contactlast_name: {
                        required: "Please enter last name",
                    },
                    contact_email: {
                        required: "Please enter email address",

                    },
                    contact_subject: {
                        required: "Please enter subject",
                    },

                    contact_message: {
                        required: "Please enter your message",
                    }

                },
        submitHandler: submitRegisterForm
    });
    /* register submit */
    function submitRegisterForm()
    {
        var contact_name = $("#contact_name").val();
        var contactlast_name = $("#contactlast_name").val();
        var contact_email = $("#contact_email").val();
        var contact_subject = $("#contact_subject").val();
        var contact_message = $("#contact_message").val();

        var post_data = {
            'contact_name': contact_name,
            'contactlast_name': contactlast_name,
            'contact_email': contact_email,
            'contact_subject': contact_subject,
            'contact_message': contact_message,
            get_csrf_token_name: get_csrf_hash,
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'contact_us/contact_us_insert',
            data: post_data,
            beforeSend: function ()
            {
                $("#register_error").fadeOut();
                $("#btn-register").html('Sign Up ...');
            },
            success: function (response)
            {
                if (response == "ok") { 

                    $('.biderror .mes').html("<div class='pop_content'>Thank you for being awesome user. We really appreciate the time you took to help us.</div>");
                     $('#bidmodal').modal('show');

                    $("#contact_name").val('');
                    $("#contactlast_name").val('');
                    $("#contact_email").val('');
                    $("#contact_subject").val('');
                    $("#contact_message").val('');
                    
                } else {

                    $('.biderror .mes').html("<div class='pop_content'>Your contact not send successfully.</div>");
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

