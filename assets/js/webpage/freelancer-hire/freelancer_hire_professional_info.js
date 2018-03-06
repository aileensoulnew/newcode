// CHECK SEARCH KEYWORD AND LOCATION BLANK START                 
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
// CHECK SEARCH KEYWORD AND LOCATION BLANK END


////CODE FOR PRELOADER START
//jQuery(document).ready(function ($) {
//    // site preloader -- also uncomment the div in the header and the css style for #preloader
//    $(window).load(function () {
//        $('#preloader').fadeOut('slow', function () {
//            $(this).remove();
//        });
//    });
//});
////CODE FOR PRELOADER END  

// FORM FILL UP VALIDATION START
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("regx", function (value, element, regexpr) {
    if(!value){
    return true;
}else{
   
     return regexpr.test(value);
}
}, "Only space, only number and only special characters are not allow");
$(document).ready(function () {

     $('.ajax_load').hide();


    $("#professional_info1").validate({
        rules: {
            professional_info: {
               // required: true,
                regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/ 
            },
        },
        messages: {
            professional_info: {
                required: "Professional information is required."
            },
        },

    });
});
//FORM FILL UP VALIDATION END  


function validate(){

     var form = $("#professional_info1");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }
}



// FLASH MASSAGE DISPLAY TIMING START
$(".alert").delay(3200).fadeOut(300);
// FLASH MASSAGE DISPLAY TIMING END

//CODE FOR COPY-PASTE START
var _onPaste_StripFormatting_IEPaste = false;
function OnPaste_StripFormatting(elem, e) {
   
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
//CODE FOR COPY-PASTE END


