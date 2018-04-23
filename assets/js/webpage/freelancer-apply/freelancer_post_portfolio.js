//FLASH MASSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MASSAGE SCRIPT END
//CODE FOR PREELOADER START
jQuery(document).ready(function ($) {
                    // site preloader -- also uncomment the div in the header and the css style for #preloader
                    $(window).load(function () {
                        $('#preloader').fadeOut('slow', function () {
                            $(this).remove();
                        });
                    });
                });
//CODE FOR PREELOADER END
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
//COPY-PASTE CODE START
  var _onPaste_StripFormatting_IEPaste = false;
                function OnPaste_StripFormatting(elem, e) {
                    //alert(456);
                    if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
                        e.preventDefault();
                        var text = e.originalEvent.clipboardData.getData('text/plain');
                        window.document.execCommand('insertText', false, text);
                    } else if (e.clipboardData && e.clipboardData.getData) {
                        e.preventDefault();
                        var text = e.clipboardData.getData('text/plain');
                        window.document.execCommand('insertText', false, text);
                    } else if (window.clipboardData && window.clipboardData.getData) {
                        // Stop stack overflow
                        if (!_onPaste_StripFormatting_IEPaste) {
                            _onPaste_StripFormatting_IEPaste = true;
                            e.preventDefault();
                            window.document.execCommand('ms-pasteTextOnly', false);
                        }
                        _onPaste_StripFormatting_IEPaste = false;
                    }
                }
//COPY-PASTE CODE END
//DELETE PDF CODE START
 function delpdf() {
                    $.ajax({
                        type: 'POST',
                        url:  base_url + "freelancer/deletepdf",
                        success: function (data) {
                            $("#filename").text('');
                            $("#pdffile").hide();
                            document.getElementById('image_hidden_portfolio').value = '';

                        }
                    });
                }
//DELETE PDF CODE END
 function portfolio_form_submit(event) {
                    var image_hidden_portfolio = document.getElementById("image_hidden_portfolio").value;
                    var portfolio_attachment = document.getElementById("portfolio_attachment").value;
                    var free_post_step = document.getElementById("free_step").value;
                    var portfolio = $('#portfolio123').html();
                    portfolio = portfolio.replace(/&nbsp;/gi, " ");
                    portfolio = portfolio.trim();
                    if (portfolio_attachment != '') {
                        var portfolio_attachment_ext = portfolio_attachment.split('.').pop();
                        var allowespdf = ['pdf'];
                        var foundPresentpdf = $.inArray(portfolio_attachment_ext, allowespdf) > -1
                    }

                    var image_hidden_portfolio_ext = image_hidden_portfolio.split('.').pop();
                    var allowespdf = ['pdf'];
                    var foundPresentportfolio = $.inArray(image_hidden_portfolio_ext, allowespdf) > -1;


                    if (foundPresentpdf == false) {
                        $(".portfolio_image").html("Please select only pdf file.");
                        event.preventDefault();
                        return false;
                    } else
                    {
                        var fd = new FormData();
                        fd.append("image", $("#portfolio_attachment")[0].files[0]);
                        files = this.files;
                        fd.append('portfolio', portfolio);
                        fd.append('image_hidden_portfolio', image_hidden_portfolio);
                        $.ajax({
                            url:  base_url + "freelancer/freelancer_post_portfolio_insert",
                            type: "POST",
                            data: fd,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if (free_post_step == 7) {
                                    window.location =  base_url + "freelancer-work/freelancer-details";
                                } else {
                                    window.location =  base_url + "freelancer-work/home";
                                }
                            }
                        });

                    }

                    event.preventDefault();
                    return false;
                }

