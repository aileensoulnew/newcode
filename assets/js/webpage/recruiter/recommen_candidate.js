
$(function () {
    $("#tags").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(data, function (item) {
                return matcher.test(item.label);
            }));
        },
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#tags").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#tags").val(ui.item.label);
        }
    });
});


$(function () {
// alert('hi');
    $("#searchplace").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(data1, function (item) {
                return matcher.test(item.label);
            }));
        },
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#searchplace").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#searchplace").val(ui.item.label);
        }
    });
});

$(function () {

    $("#tags1").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(data, function (item) {
                return matcher.test(item.label);
            }));
        },
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#tags1").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#tags1").val(ui.item.label);
        }
    });
});

$(function () {

    $("#searchplace1").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(data1, function (item) {
                return matcher.test(item.label);
            }));
        },
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#searchplace1").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#searchplace1").val(ui.item.label);
        }
    });
});


function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('rec_search_title').value);
    var searchplace = $.trim(document.getElementById('rec_search_loc').value);
    // alert(searchkeyword);
    // alert(searchplace);
    if (searchkeyword == "" && searchplace == "") {
        //    alert('Please enter Keyword');
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

//select2 autocomplete start for skill
//$('#searchskills').select2({
//    placeholder: 'Find Your Skills',
//    ajax: {
//        url: "<?php echo base_url(); ?>recruiter/keyskill",
//        dataType: 'json',
//        delay: 250,
//        processResults: function (data) {
//            return {
//                //alert(data);
//                results: data
//            };
//        },
//        cache: true
//    }
//});
//select2 autocomplete End for skill
//select2 autocomplete start for Location
//$('#searchplace').select2({
//    placeholder: 'Find Your Location',
//    maximumSelectionLength: 1,
//    ajax: {
//        url: "<?php echo base_url(); ?>recruiter/location",
//        dataType: 'json',
//        delay: 250,
//        processResults: function (data) { //alert(data);
//            return {
//
//                results: data
//            };
//        },
//        cache: true
//    }
//});
//select2 autocomplete End for Location
// Get the modal
//var modal = document.getElementById('myModal');
// Get the button that opens the modal
//var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
//btn.onclick = function () {
//   modal.style.display = "block";
//}
// When the user clicks on <span> (x), close the modal
//span.onclick = function () {
//    modal.style.display = "none";
//}
// When the user clicks anywhere outside of the modal, close it
// window.onclick = function (event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }


$(document).ready(function ()
{
    /* Uploading Profile BackGround Image */
    $('body').on('change', '#bgphotoimg', function ()
    {
        $("#bgimageform").ajaxForm({target: '#timelineBackground',
            beforeSubmit: function () {},
            success: function () {
                $("#timelineShade").hide();
                $("#bgimageform").hide();
            },
            error: function () {
            }}).submit();
    });
    /* Banner position drag */
    $("body").on('mouseover', '.headerimage', function ()
    {
        var y1 = $('#timelineBackground').height();
        var y2 = $('.headerimage').height();
        $(this).draggable({
            scroll: false,
            axis: "y",
            drag: function (event, ui) {
                if (ui.position.top >= 0)
                {
                    ui.position.top = 0;
                } else if (ui.position.top <= y1 - y2)
                {
                    ui.position.top = y1 - y2;
                }
            },
            stop: function (event, ui)
            {
            }
        });
    });
    /* Bannert Position Save*/
    $("body").on('click', '.bgSave', function ()
    {
        var id = $(this).attr("id");
        var p = $("#timelineBGload").attr("style");
        var Y = p.split("top:");
        var Z = Y[1].split(";");
        var dataString = 'position=' + Z[0];
        $.ajax({
            type: "POST",
            url: base_url +"recruiter/image_saveBG_ajax",
            data: dataString,
            cache: false,
            beforeSend: function () { },
            success: function (html)
            {
                if (html)
                {
                    window.location.reload();
                    $(".bgImage").fadeOut('slow');
                    $(".bgSave").fadeOut('slow');
                    $("#timelineShade").fadeIn("slow");
                    $("#timelineBGload").removeClass("headerimage");
                    $("#timelineBGload").css({'margin-top': html});
                    return false;
                }
            }
        });
        return false;
    });
});


function savepopup(abc)
{

    var saveid = document.getElementById("hideenuser" + abc);

    $.ajax({
        type: 'POST',
        url: base_url +'recruiter/save_search_user',
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function (data) {
            $('.' + 'saveduser' + abc).html(data).addClass('saved');
            $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
            $('#bidmodal').modal('show');
        }
    });
}


// function savepopup(id) {

//     save_user(id);

    
// }

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});


$(document).ready(function () {

    var nb = $('div.profile-job-post-title').length;

    //alert(nb);
    if (nb == 0) {
        $("#dropdownclass").addClass("no-post-h2");

    }

});
//AJAX DATA LOAD BY LAZZY LOADER START
$(document).ready(function () {
    recommen_candidate_post();
    
    $(window).scroll(function () {
        
      if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                //if ($(".page_number:last").val() <= $(".total_record").val()) {
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    recommen_candidate_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function recommen_candidate_post(pagenum) {
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "recruiter/recommen_candidate_post?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                 $(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
           }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.job-contact-frnd').append(data);

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
        }
    });
}
//AJAX DATA LOAD BY LAZZY LOADER END

                    