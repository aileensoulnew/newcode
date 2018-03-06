//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {
    freelancerhire_search();

    $(window).scroll(function () {
        
       // if ($(window).scrollTop() == $(document).height() - $(window).height()) {
    //  if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
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
                    
                    freelancerhire_search(pagenum);
                }
            }
        }
    });
    
});
var isProcessing = false;
function freelancerhire_search(pagenum)
{
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    // url = '<?php echo base_url() . "freelance-hire/search?page=" ?>'+clicked_id+"&skill="  + encodeURIComponent(searchkeyword) + "&place=" + searchplace;
    isProcessing = true;
    
    $.ajax({
        type: 'POST',
        url: base_url + "search/ajax_freelancer_hire_search?page=" + pagenum + "&skill="  + encodeURIComponent(skill) + "&place=" + place,
        data: {total_record:$("#total_record").val()},
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

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

//FUNCTION FOR CHECK VALUE OF SEARCH KEYWORD AND PLACE ARE BLANK START
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
//FUNCTION FOR CHECK VALUE OF SEARCH KEYWORD AND PLACE ARE BLANK END
//CODE FOR SAVE USER START
function savepopup(id) {
    save_user(id);

    $('.biderror .mes').html("<div class='pop_content'>Your Freelancer is successfully saved.");
    $('#bidmodal').modal('show');
}
function save_user(abc)
{
    var saveid = document.getElementById("hideenuser" + abc);
    $.ajax({
        type: 'POST',
        url:  base_url + "freelancer_hire/save_user1",
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function (data) {
            $('.' + 'saveduser' + abc).html(data).addClass('saved');
        }
    });
}
//CODE FOR SAVE USER END
//ALL POPUP CLOSE USING ESC START
 $(document).on('keydown', function (e) {
                if (e.keyCode === 27) {
                    $('#bidmodal').modal('hide');
                }
            });
//ALL POPUP CLOSE USING ESC END