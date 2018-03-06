$(document).ready(function () { 
   // $('#register').modal('show');
    artistic_search_user();

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {

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
                    artistic_search_user(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function artistic_search_user(pagenum) { //alert(keyword);
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
        url: base_url + "artist/ajax_user_search?page=" + pagenum + "&skills=" + keyword + "&searchplace=" + keyword1,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () { //alert(2);
            //if (pagenum == 'undefined') {
                // $(".business-all-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            //} else {
                $('#loader').show();
            //}
        },
        complete: function () { //alert(4);
            $('#loader').hide();
        },
        success: function (data) { //alert(3); alert(data);
            $('.loader').remove();
            $('.job-contact-frnd').append(data);
             $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '0px');
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