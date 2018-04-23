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
//CODE FOR DEGREE DATA START
$(document).ready(function () {
    $('#degree').on('change', function () {
        var degreeID = $(this).val();
        if (degreeID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_data",
                data: 'degree_id=' + degreeID,
                success: function (html) {
                    $('#stream').html(html);

                }
            });
        } else {
            $('#stream').html('<option value="">Select Degree first</option>');
        }
    });
});
//CODE FOR DEGREE DATA END
//FOR PREELOADER START
jQuery(document).ready(function ($) {
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});
//FOR PREELOADER END
//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END
//OTHER UNIVERSITY ADD START
$(document).on('change', '.university_1', function (event) {
    var item = $(this);
    var uni = (item.val());
    if (uni == 463)
    {
        item.val('');
        $.fancybox.open('<div class="message" style="width:300px;" onkeypress="return remove_validation()"><h2>Add University</h2><input type="text" name="other_uni" id="other_uni"><div class="fw"><a id="univer" class="btn">OK</a></div></div>');

        $('.message #univer').on('click', function () {
          
            $("#other_uni").removeClass("keyskill_border_active");
            $('#uni_error').remove();
            var x = $.trim(document.getElementById("other_uni").value);
            if (x == '') {
               
                $("#other_uni").addClass("keyskill_border_active");
                $('<span class="error" id="uni_error" style="float: right;color: red; font-size: 11px;">Empty University is not valid</span>').insertAfter('#other_uni');
                return false;
            } else {
                var $textbox = $('.message').find('input[type="text"]'),
                        textVal = $textbox.val();
                $.ajax({
                    type: 'POST',
                    url: base_url + "freelancer/freelancer_other_university",
                    dataType: 'json',
                    data: 'other_university=' + textVal,
                    success: function (response) {

                        if (response.select == 0)
                        {
//                        $.fancybox.open('<div class="message"><h2>Written University already available in University Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                            $("#other_uni").addClass("keyskill_border_active");
                            $('<span class="error" id="uni_error" style="float: right;color: red; font-size: 11px;">Written University already available in University Selection</span>').insertAfter('#other_uni');
                        } else if (response.select == 1)
                        {
                            $("#other_uni").addClass("keyskill_border_active");
                            $('<span class="error" id="uni_error" style="float: right;color: red; font-size: 11px;">Empty University is not valid</span>').insertAfter('#other_uni');
//                        $.fancybox.open('<div class="message"><h2>Empty University is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else
                        {
                            $.fancybox.close();

                            $('.university_1').html(response.select);
                        }
                    }
                });
            }

        });
    }

});
function remove_validation() {

    $("#other_uni").removeClass("keyskill_border_active");
    $('#uni_error').remove();

}
//OTHER UNIVERSITY ADD END
//FORM FILL UP VALIDATION START
//pattern validation at percentage start//
$.validator.addMethod("percen", function (value, element, param) {
    if (this.optional(element)) {
        return true;
    }
    if (typeof param === "string") {
        param = new RegExp("^(?:" + param + ")$");
    }
    return param.test(value);
}, "Please enter percentage like 89.96.");

//pattern validation at percentage end//
$(document).ready(function () {

    $("#freelancer_post_education").validate({

        rules: {
            percentage: {
                number: true,
                percen: /^([0-9]{1,2}){1}(\.[0-9]{1,2})?$/

            },
        },

        messages: {
        },

    });
});
//FORM FILL UP VALIDATION END

$(document).on('change', '#degree', function (event) {

    var item = $(this);
    var degree = (item.val());

    if (degree == 54)
    {
        item.val('');
        $.fancybox.open(html);
        $('.message #univer').on('click', function () {
            var degree = document.querySelector(".message #other_degree").value;
            var stream = document.querySelector(".message #other_stream").value;
            if (stream == '' || degree == '')
            {
                if (degree == '' && stream != '')
                {
                    $.fancybox.open('<div class="message"><h2>Empty Degree is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                }
                if (stream == '' && degree != '')
                {
                    $.fancybox.open('<div class="message"><h2>Empty Stream is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                }
                if (stream == '' && degree == '')
                {
                    $.fancybox.open('<div class="message"><h2>Empty Degree and Empty Stream are not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                }
                return false;
            } else
            {
                var $textbox = $('.message').find('input[type="text"]'),
                        textVal = $textbox.val();
                var selectbox_stream = $('.message').find(":selected").text()

                $.ajax({
                    type: 'POST',
                    url: base_url + 'freelancer/freelancer_other_degree',
                    dataType: 'json',
                    data: 'other_degree=' + textVal + '&other_stream=' + selectbox_stream,
                    success: function (response) {

                        if (response.select == 0)
                        {
                            $.fancybox.open('<div class="message"><h2>Written Degree already available in Degree Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else if (response.select == 1)
                        {
                            $.fancybox.open('<div class="message"><h2>Empty Degree is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else
                        {
                            $.fancybox.close();
                            $('#degree').html(response.select);
                            $('#stream').html(response.select2);
                        }
                    }
                });
            }
        });
    }
});
$(document).on('change', '.message #other_stream', function (event) {
    var item1 = $(this);
    var other_stream = (item1.val());

    if (other_stream == 61)
    {
        $.fancybox.open('<div class="message1"><h2>Add Stream</h2><input type="text" name="other_degree1" id="other_degree1"><a id="univer1" class="btn">OK</a></div>');

        $('.message1 #univer1').on('click', function () {
            var $textbox1 = $('.message1').find('input[type="text"]'),
                    textVal1 = $textbox1.val();

            $.ajax({
                type: 'POST',
                url: base_url + 'freelancer/freelancer_other_stream',
                data: 'other_stream=' + textVal1,
                success: function (response) {

                    if (response == 0)
                    {
                        $.fancybox.open('<div class="message"><h2>Written Stream already available in  Stream Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                    } else if (response == 1)
                    {
                        $.fancybox.open('<div class="message"><h2>Empty Stream is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                    } else
                    {
                        $.fancybox.close();
                        $('.message #other_stream').html(response);
                    }
                }
            });

        });
    }

});
//Click on Degree other option process End


