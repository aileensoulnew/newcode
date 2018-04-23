$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    /* first box */
    $(".tags").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 1,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "business_profile/ajax_business_skill", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
    /* first box*/
    /* location box*/
    $(".searchplace").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 1,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "business_profile/ajax_location_data", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
    /* location box*/
});

//CODE FOR PROFILE PIC UPLOAD WITH CROP START
$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 157,
        height: 157,
        type: 'square'
    },
    boundary: {
        width: 257,
        height: 257
    }
});

$('#upload-one').on('change', function () {
    document.getElementById('upload-demo-one').style.display = 'block';
//    $('#upload-demo-one').find('.cr-boundary:first').hide();
//    $('#upload-demo-one').find('.cr-slider-wrap:first').hide();
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop1.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });

    }
    reader.readAsDataURL(this.files[0]);
});
$(document).ready(function () {
    $("#userimage").validate({
        rules: {
            profilepic: {
                required: true,
            },
        },
        messages: {
            profilepic: {
                required: "Photo required",
            },
        },
        submitHandler: profile_pic
    });
    function profile_pic() {
//    $('.upload-result-one').on('click', function (ev) {
        $uploadCrop1.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                //url: "/ajaxpro.php", user_image_insert
                // url: "<?php echo base_url(); ?>freelancer/ajaxpro_test",
                url: base_url + "business_profile/user_image_insert_new",
                type: "POST",
                data: {"image": resp},
                beforeSend: function () {
                    // $('.loader').show();
//                    document.getElementById('profile_loader').style.display = 'block';
                    $('#profile_loader').show();
                },
                complete: function () {
                    //   document.getElementById('loader').style.display = 'none';
                },
                success: function (data) {
                    $('#profile_loader').hide();
                    $('#bidmodal-2').modal('hide');
                    $(".user-pic").html(data);
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-demo-one').value = '';
//                    html = '<img src="' + resp + '" />';
//                    $("#upload-demo-i").html(html);
                }
            });
        });
//    });
    }
});


function updateprofilepopup(id) {
    document.getElementById('upload-demo-one').style.display = 'none';
    //document.getElementById('loader').style.display = 'none';
    document.getElementById('upload-one').value = null;
    $('#bidmodal-2').modal('show');
}
//CODE FOR PROFILE PIC UPLOAD WITH CROP END


// script for profile pic strat 
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview').style.display = 'block';
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#profilepic").change(function () {
    profile = this.files;
    if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        //alert('not an image');
        $('#profilepic').val('');
        picpopup();
        return false;
    } else {
        readURL(this);
    }
});
// script for profile pic end 

function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>This is not valid file. Please Uplode valid Image File.");
    $('#bidmodal').modal('show');
}

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal-2').modal('hide');
    }
});




// cover image start 

function myFunction() {
    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
}

function showDiv() {
    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
}

$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 1250,
        height: 350,
        type: 'square'
    },
    boundary: {
        width: 1250,
        height: 350
    }
});
$('.upload-result').on('click', function (ev) {
    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";

    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {

        var aa = resp.length;
        if (aa == 11350) {
            document.getElementById('row2').style.display = "block";
            document.getElementById('row1').style.display = "none";
            document.getElementById('message1').style.display = "none";
            document.getElementById("upload-demo").style.visibility = "visible";
            document.getElementById("upload-demo-i").style.visibility = "visible";
            return false;
        } else {
            $.ajax({
                url: base_url + "business_profile/ajaxpro",
                type: "POST",
                data: {"image": resp},
                success: function (data) {
                    $("#row2").html(data);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";
                }
            });
        }
    });
});
$('.cancel-result').on('click', function (ev) {
    document.getElementById('row2').style.display = "block";
    document.getElementById('row1').style.display = "none";
    document.getElementById('message1').style.display = "none";
});
$('#upload').on('change', function () {
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
$('#upload').on('change', function () {
    var fd = new FormData();
    fd.append("image", $("#upload")[0].files[0]);
    files = this.files;
    size = files[0].size;
    if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        picpopup();
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        $("#upload").val('');
        return false;
    }
    // file type code end
    if (size > 4194304)
    {
        //show an alert to the user
        alert("Allowed file size exceeded. (Max. 4 MB)")
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        //reset file upload control
        return false;
    }
    $.ajax({
        url: base_url + "business_profile/imagedata",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function (response) {
        }
    });
});
// cover image end 