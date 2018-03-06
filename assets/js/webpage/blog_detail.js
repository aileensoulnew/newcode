$(document).ready(function () {
    $("#comment").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            message: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter a name",
            },
            email: {
                required: "Please enter a email",
            },
            message: {
                required: "Please enter a message",
            },
        },
    });
    //It prevent page automatically refresh
    $("#comment").submit(function (e) {
        e.preventDefault();
        if ($(this).valid())
        {
            var blog_id = document.getElementById("blog_id").value;
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var message = document.getElementById("message").value;
            $.ajax({
                type: 'POST',
                url: base_url + "blog/comment_insert",
                data: 'blog_id=' + blog_id + '&name=' + name + '&email=' + email + '&message=' + message,
                success: function (data) {
                    if (data == 1)
                    {
                        $.fancybox.open('<div class="message"><h2>Thank you for your valuable feedback</h2></div>');
                        $('#name').val('');
                        $('#email').val('');
                        $('#message').val('');
                    }
                }
            });
        }
    });
});
// THIS SCRIPT IS USED FOR SCRAP IMAGE FOR FACEBOOK POST TO GET REAL IMAGE START
var url = window.location.href;
$.ajax({
    type: 'POST',
    url: 'https://graph.facebook.com?id=' + url + '&scrape=true',
    success: function (data) {
        console.log(data);
    }
});
// THIS SCRIPT IS USED FOR SCRAP IMAGE FOR FACEBOOK POST TO GET REAL IMAGE END