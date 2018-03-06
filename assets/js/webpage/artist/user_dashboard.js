 $(document).ready(function () {
            artistic_dashboard_post(slug);
                GetArtPhotos();
                GetArtVideos();
                GetArtAudios();
                GetArtPdf();

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
                    artistic_dashboard_post(slug, pagenum);
                }
            }
        }
    });
});
         
var isProcessing = false;
function artistic_dashboard_post(slug, pagenum) { //alert("hii"); alert(slug);
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
       // return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "artist_userprofile/artistic_user_dashboard_post/"+ slug + "?page=" + pagenum,
        //url: base_url + "artist/artistic_dashboard_post/" + slug + "?page=" + pagenum,
       // data: 'slug=' + slug,
       data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            //if (pagenum == 'undefined') {
                //  $(".business-all-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            //} else {
                $('#loader').show();
            //}
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.fw').hide();
            $('.art-all-post').append(data);

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
             $('video, audio').mediaelementplayer();

             $('.all-comment-comment-box').css('border-bottom','0px');

        }
    });
}



    function GetArtPhotos() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist_userprofile/artistic_user_photos",
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                         $('#loader').show();   
                    },
                    success: function (data) {
                      $('#loader').hide();
                        $('.art_photos').html(data);
                    }
                });

            }

            function GetArtVideos() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist_userprofile/artistic_user_videos",
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                         $('#loader').show();                         
                    },
                    success: function (data) {
                       $('#loader').hide();
                        $('.art_videos').html(data);
                        $('video, audio').mediaelementplayer();
                    }
                });
            }

            function GetArtAudios() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist_userprofile/artistic_user_audio",
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                         $('#loader').show();   
                    },
                    success: function (data) {
                        $('#loader').hide();
                        $('.art_audios').html(data);

                    }
                });

            }

            function GetArtPdf() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist_userprofile/artistic_user_pdf",
                    //url: '<?php echo base_url() . "artist/artistic_pdf" ?>',
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                         $('#loader').show();   
                       // $(".art_pdf").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) {
                       $('#loader').hide();
                        $('.art_pdf').html(data);

                    }
                });

            }
