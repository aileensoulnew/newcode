
//CODE FOR DEGREE DATA START
function validate() {

    var form = $("#freelancer_post_education");
    if (form.valid() == true) {
        //$('#profilereg_ajax_load').show();
        document.getElementById('profilereg_ajax_load').style.display = 'inline-block';

    }
}


$(document).ready(function () {

    $('.ajax_load').hide();
    $("#freelancer_post_education").find("select").each(function (i) {
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });
    $('#degree').on('change', function () {
        var degreeID = $(this).val();
        if (degreeID != 54) {
            if (degreeID) {
                $.ajax({
                    type: 'POST',
                    url: base_url + "freelancer/ajax_data",
                    data: 'degree_id=' + degreeID,
                    success: function (html) {
                        $('#stream').html(html);
                        $('#stream').removeClass("color-black-custom");
                    }
                });
            } else {
                $('#stream').html('<option value="">Select Degree first</option>');
            }
        } else {

            var item = $(this);
            var degree = (item.val());

            if (degree == 54)
            {
                $("#other_degree").removeClass("keyskill_border_active");
                $("#other_stream").removeClass("keyskill_border_active");
                $('#degree_error').remove();
                $('#stream_error').remove();
                item.val('');
                $('#bidmodal_degree').modal('show');
                //  $.fancybox.open(html);
                $('.message2 #univer2').off('click').on('click', function () {
                    $("#other_degree").removeClass("keyskill_border_active");
                    $("#other_stream").removeClass("keyskill_border_active");
                    $('#degree_error').remove();
                    $('#stream_error').remove();
                    var degree = document.querySelector(".message2 #other_degree").value;
                    var stream = document.querySelector(".message2 #other_stream").value;
                    if (stream == '' || degree == '')
                    {
                        if (degree == '' && stream != '')
                        {
                            $("#other_degree").addClass("keyskill_border_active");
                            $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Empty Degree is not valid</span>').insertAfter('#other_degree');
                            //$.fancybox.open('<div class="message"><h2>Empty Degree is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        }
                        if (stream == '' && degree != '')
                        {
                            $("#other_stream").addClass("keyskill_border_active");
                            $('<span class="error" id="stream_error" style="float: right;color: red; font-size: 11px;">Empty Stream is not valid</span>').insertAfter('#other_stream');
                            //  $.fancybox.open('<div class="message"><h2>Empty Stream is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        }
                        if (stream == '' && degree == '')
                        {
                            $("#other_degree").addClass("keyskill_border_active");
                            $("#other_stream").addClass("keyskill_border_active");
                            $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Empty Degree is not valid</span>').insertAfter('#other_degree');
                            $('<span class="error" id="stream_error" style="float: right;color: red; font-size: 11px;">Empty Stream is not valid</span>').insertAfter('#other_stream');
                            //  $.fancybox.open('<div class="message"><h2>Empty Degree and Empty Stream are not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        }
                        return false;
                    } else
                    {
                        var $textbox = $('.message2').find('input[type="text"]'),
                                textVal = $textbox.val();
                        var selectbox_stream = $('.message2').find(":selected").text()

                        $.ajax({
                            type: 'POST',
                            url: base_url + 'freelancer/freelancer_other_degree',
                            dataType: 'json',
                            data: 'other_degree=' + textVal + '&other_stream=' + selectbox_stream,
                            success: function (response) {

                                if (response.select == 0)
                                {
                                    $("#other_degree").addClass("keyskill_border_active");
                                    $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Written Degree already available in Degree Selection</span>').insertAfter('#other_degree');
                                    // $.fancybox.open('<div class="message"><h2>Written Degree already available in Degree Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                                } else if (response.select == 1)
                                {
                                    $("#other_degree").addClass("keyskill_border_active");
                                    $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Empty Degree is not valid</span>').insertAfter('#other_degree');
                                    //$.fancybox.open('<div class="message"><h2>Empty Degree is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                                } else
                                {
                                    // $.fancybox.close();
                                    $('#bidmodal_degree').modal('hide');
                                    $('#other_degree').val('');
                                    $('#other_stream').val('');
                                    $("#other_degree").removeClass("keyskill_border_active");
                                    $("#other_stream").removeClass("keyskill_border_active");
                                    $("#degree_error").removeClass("error");
                                    $("#stream_error").removeClass("error");
                                    $('#degree').html(response.select);
                                    $('#stream').html(response.select2);
                                }
                            }
                        });
                    }
                });
            }

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
    $("#other_uni").removeClass("keyskill_border_active");
    $('#uni_error').remove();
    var item = $(this);
    var uni = (item.val());
    if (uni == 463)
    {
        item.val('');
        $('#bidmodal2').modal('show');
        // $.fancybox.open('<div class="message" style="width:300px;" onkeypress="return remove_validation()"><h2>Add University</h2><input type="text" name="other_uni" id="other_uni"><div class="fw"><a id="univer" class="btn">OK</a></div></div>');

        $('.message #univer').off('click').on('click', function () {

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
                            // $.fancybox.close();
                            $('#bidmodal2').modal('hide');
                            $('#other_uni').val('');
                            $("#other_uni").removeClass("keyskill_border_active");
                            $("#field_error").removeClass("error");
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

//$(document).on('change', '#degree', function (event) {
//
//    $("#other_degree").removeClass("keyskill_border_active");
//    $("#other_stream").removeClass("keyskill_border_active");
//    $('#degree_error').remove();
//    $('#stream_error').remove();
//    var item = $(this);
//    var degree = (item.val());
//
//    if (degree == 54)
//    {
//        item.val('');
//        $('#bidmodal_degree').modal('show');
//        //  $.fancybox.open(html);
//        $('.message2 #univer2').off('click').on('click', function () {
//            $("#other_degree").removeClass("keyskill_border_active");
//            $("#other_stream").removeClass("keyskill_border_active");
//            $('#degree_error').remove();
//            $('#stream_error').remove();
//            var degree = document.querySelector(".message2 #other_degree").value;
//            var stream = document.querySelector(".message2 #other_stream").value;
//            if (stream == '' || degree == '')
//            {
//                if (degree == '' && stream != '')
//                {
//                    $("#other_degree").addClass("keyskill_border_active");
//                    $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Empty Degree is not valid</span>').insertAfter('#other_degree');
//                    //$.fancybox.open('<div class="message"><h2>Empty Degree is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                }
//                if (stream == '' && degree != '')
//                {
//                    $("#other_stream").addClass("keyskill_border_active");
//                    $('<span class="error" id="stream_error" style="float: right;color: red; font-size: 11px;">Empty Stream is not valid</span>').insertAfter('#other_stream');
//                    //  $.fancybox.open('<div class="message"><h2>Empty Stream is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                }
//                if (stream == '' && degree == '')
//                {
//                    $("#other_degree").addClass("keyskill_border_active");
//                    $("#other_stream").addClass("keyskill_border_active");
//                    $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Empty Degree is not valid</span>').insertAfter('#other_degree');
//                    $('<span class="error" id="stream_error" style="float: right;color: red; font-size: 11px;">Empty Stream is not valid</span>').insertAfter('#other_stream');
//                    //  $.fancybox.open('<div class="message"><h2>Empty Degree and Empty Stream are not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                }
//                return false;
//            } else
//            {
//                var $textbox = $('.message2').find('input[type="text"]'),
//                        textVal = $textbox.val();
//                var selectbox_stream = $('.message2').find(":selected").text()
//
//                $.ajax({
//                    type: 'POST',
//                    url: base_url + 'freelancer/freelancer_other_degree',
//                    dataType: 'json',
//                    data: 'other_degree=' + textVal + '&other_stream=' + selectbox_stream,
//                    success: function (response) {
//
//                        if (response.select == 0)
//                        {
//                            $("#other_degree").addClass("keyskill_border_active");
//                            $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Written Degree already available in Degree Selection</span>').insertAfter('#other_degree');
//                            // $.fancybox.open('<div class="message"><h2>Written Degree already available in Degree Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                        } else if (response.select == 1)
//                        {
//                            $("#other_degree").addClass("keyskill_border_active");
//                            $('<span class="error" id="degree_error" style="float: right;color: red; font-size: 11px;">Empty Degree is not valid</span>').insertAfter('#other_degree');
//                            //$.fancybox.open('<div class="message"><h2>Empty Degree is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                        } else
//                        {
//                            // $.fancybox.close();
//                            $('#bidmodal_degree').modal('hide');
//                            $('#other_degree').val('');
//                            $('#other_stream').val('');
//                            $("#other_degree").removeClass("keyskill_border_active");
//                            $("#other_stream").removeClass("keyskill_border_active");
//                            $("#degree_error").removeClass("error");
//                            $("#stream_error").removeClass("error");
//                            $('#degree').html(response.select);
//                            $('#stream').html(response.select2);
//                        }
//                    }
//                });
//            }
//        });
//    }
//});
$(document).on('change', '#other_stream', function (event) {
    $("#other_degree1").removeClass("keyskill_border_active");
    $('#field_error').remove();
    var item1 = $(this);
    var other_stream = (item1.val());

    if (other_stream == 61)
    {
        // $.fancybox.open('<div class="message1"><h2>Add Stream</h2><input type="text" name="other_degree1" id="other_degree1"><a id="univer1" class="btn">OK</a></div>');
        $('#bidmodal_stream').modal('show');
        $('.message1 #univer1').off('click').on('click', function () {
            $("#other_degree1").removeClass("keyskill_border_active");
            $('#field_error').remove();
            var x = $.trim(document.getElementById("other_degree1").value);
            if (x == '') {
                $("#other_degree1").addClass("keyskill_border_active");
                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Stream is not valid</span>').insertAfter('#other_degree1');
            } else {
                var $textbox1 = $('.message1').find('input[type="text"]'),
                        textVal1 = $textbox1.val();

                $.ajax({
                    type: 'POST',
                    url: base_url + 'freelancer/freelancer_other_stream',
                    data: 'other_stream=' + textVal1,
                    success: function (response) {

                        if (response == 0)
                        {
                            $("#other_degree1").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written Stream already available in  Stream Selection</span>').insertAfter('#other_degree1');
                            //    $.fancybox.open('<div class="message"><h2>Written Stream already available in  Stream Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else if (response == 1)
                        {
                            $("#other_degree1").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Stream is not valid</span>').insertAfter('#other_degree1');
                            //  $.fancybox.open('<div class="message"><h2>Empty Stream is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else
                        {
                            // $.fancybox.close();
                            $('#bidmodal_stream').modal('hide');
                            $('#other_degree1').val('');
                            $("#other_degree1").removeClass("keyskill_border_active");
                            $("#field_error").removeClass("error");
                            $('.message2 #other_stream').html(response);
                        }
                    }
                });
            }
        });
    }

});
function remove_validation() {
    $("#other_degree").removeClass("keyskill_border_active");
    $('#degree_error').remove();

}
function remove_validation1() {

    $("#other_stream").removeClass("keyskill_border_active");
    $('#stream_error').remove();

}
function remove_validation_stream() {

    $("#other_degree1").removeClass("keyskill_border_active");
    $('#field_error').remove();

}
//Click on Degree other option process End

//ALL POPUP CLOSE USING ESC START
//$(document).on('keydown', function (e) {
//                if (e.keyCode === 27) {
//                    $('#bidmodal2').modal('hide');
//                    if($('#bidmodal_stream').modal('show')){
//                         $('#bidmodal_stream').modal('hide');
//                          $('#bidmodal_degree').modal('show');
//                     document.getElementById('bidmodal_degree').style.display === "block"     
//                    }else if(document.getElementById('bidmodal_degree').style.display === "block"){
//                        $('#bidmodal_degree').modal('hide');
//                    }else{
//                        
//                    }
//                    
//                    
//            }
//            });

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal2').modal('hide');
        $('#bidmodal_stream').modal('hide');
        $('#bidmodal_degree').modal('hide');

    }
});

//ALL POPUP CLOSE USING ESC END
