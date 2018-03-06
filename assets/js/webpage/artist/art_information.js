jQuery(document).ready(function ($) {

    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});


jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");


$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space and only number are not allow.");

$(document).ready(function () {

    $("#artinfo").validate({

        ignore: '*:not([name])',
        rules: {

            "skills[]": {

                required: true,

            },
        },

        messages: {

            "skills[]": {

                required: "Skill is required.",

            },
        },

    });
});



// multiple skill start

$(function () {
    $('#skills').multiSelect();
});

// other category input open start

$('#skills').change(function other_category() {
    // var e = document.getElementById("skills");
    // var strUser = e.options[e.selectedIndex].value;
    $("#multidropdown").removeClass("error");
    $("#othercategory").removeClass("error");

    var strUser1 = $('#skills').val();
    var strUser = "'" + strUser1 + "'";
    var n = strUser.includes(26);

    if (n == true) {

        $("span").removeClass("custom-mini-select");
        document.getElementById('other_category').style.display = "block";
    } else if (strUser1 == '') {
        $("span").addClass("custom-mini-select");
        document.getElementById('other_category').style.display = "none";
    } else {
        $("span").removeClass("custom-mini-select");
        document.getElementById('other_category').style.display = "none";
    }
});

function otherchange(cat_id){

        if(cat_id == 26){
        var active = document.querySelector(".multi-select-container");
        active.classList.remove("multi-select-container--open"); 
      }
}
function removevalidation() {

    $("#othercategory").removeClass("othercategory_require");
    $('#othercategory_error').remove();
}

function validation_other(event) {

    $('#othercategory_error').remove();
    event.preventDefault();
    var strUser1 = $('#skills').val();
    var strUser = "'" + strUser1 + "'";

    var length_ele = strUser.split(',');
    var n = strUser.includes(26);
    var other_category = document.getElementById("othercategory").value;
    var category_trim = other_category.trim();

    if (strUser1 != '') {
        if (length_ele.length <= 10) {
            if (n == true) {
                if (category_trim == '') {
                    $("#othercategory").addClass("othercategory_require");
                    $('<span class="error" id="othercategory_error" style="float: right;color: red; font-size: 13px;">Other art category required. </span>').insertAfter('#othercategory');
                    $("#othercategory").addClass("error");
                    return false;
                    event.preventDefault();
                } else {
                    if (category_trim) {
                        $.ajax({
                            type: 'GET',
                            url: base_url + "artist/check_category",
                            data: 'category=' + category_trim,
                            success: function (data) {
                                if (data == 'true') {
                                    $("#othercategory").addClass("othercategory_require");
                                    $('<span class="error" id="othercategory_error" style="float: right;color: red; font-size: 13px;">This category already exists in art category field. </span>').insertAfter('#othercategory');
                                    $("#othercategory").addClass("error");
                                } else {
                                    $("#artinfo")[0].submit();
                                }
                            }
                        });
                    }
                }
            } else if ((n == false && category_trim != '') || n == false && category_trim == '') {
                $("#artinfo")[0].submit();
            }
        } else {
            $("#skills").addClass("othercategory_require");
            $('<span class="error" id="othercategory_error" style="float: right;color: red; font-size: 13px;">You can select at max 10 Art category. </span>').insertAfter('#skills');
            return false;
            event.preventDefault();
        }
    } else {
        return false;
        event.preventDefault();
    }
}

function validate() {

     var form = $("#artinfo");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();

     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }
    
    var strUser1 = $('#skills').val();
    if (strUser1 == '') {
        $("#multidropdown").addClass("error");
    }
}

function checkvalue() {

    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);

    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}

function check() {

    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}


$(document).ready(function () {
    var strUser1 = $('#skills').val();
    if (strUser1 != '') {
        $("span").removeClass("custom-mini-select");
    }
});

// $(".alert").delay(3200).fadeOut(300);


// portfolio start all validation


$("#bestofmine").change(function (event) {

    $(".bestofmine_image").html("");
    var bestofmine = document.getElementById("bestofmine").value;
    var bestmine = document.getElementById("bestmine").value;

    var lastIndex = bestofmine.lastIndexOf("\\");
    if (lastIndex >= 0) {
        bestofmine = bestofmine.substring(lastIndex + 1);

    }
    $("#datav").text(bestofmine);


    if (bestofmine != '') {
        var bestofmine_ext = bestofmine.split('.').pop();
        var allowespdf = ['pdf'];
        var foundPresentpdf = $.inArray(bestofmine_ext, allowespdf) > -1;
    }
    var bestmine_ext = bestmine.split('.').pop();
    var allowespdf = ['pdf'];
    var foundPresentportfolio = $.inArray(bestmine_ext, allowespdf) > -1;
    if (foundPresentpdf == false)
    {
        $(".bestofmine_image").html("Please select only pdf file.");
        return false;
        event.preventDefault();
    }
});

function delpdf() {
    $.ajax({
        type: 'POST',
        url: base_url + "artist/deletepdf",
        //url:'<?php echo base_url() . "artist/deletepdf" ?>',
        success: function (data) {
            $("#filename").text('');
            $("#pdffile").hide();
            document.getElementById('bestmine').value = '';
        }
    });
}


