//CODE FOR PROFILE PIC UPLOAD WITH CROP START
$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload-one').on('change', function () {
    document.getElementById('upload-demo-one').style.display = 'block';
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
                required: "Photo Required",
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
                url: base_url + "recruiter/user_image_insert1",
                type: "POST",
                data: {"image": resp},
                beforeSend: function () {
                    $('#profi_loader').show();
                  //  document.getElementById('loader').style.display = 'block';
                },
                complete: function () {
                    //$document.getElementById('loader').style.display = 'none';
                },
                success: function (data) {
                    $('#profi_loader').hide();
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
    document.getElementById('profi_loader').style.display = 'none';
    document.getElementById('upload-one').value = null;
    $('#bidmodal-2').modal('show');
}

//CODE FOR PROFILE PIC UPLOAD WITH CROP END

function checkvalue() {

    var searchkeyword = $.trim(document.getElementById('rec_search_title').value);
    var searchplace = $.trim(document.getElementById('rec_search_loc').value);

    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}

function check()
{
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "")
    {
        return false;

    }
}

function removepopup(id) {
    $('.biderror .mes').html("<div class='pop_content'>Are you sure want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}


// cover image start 

function myFunction()
{
    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
}



function showDiv() {

    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
    $(".cr-image").attr("src", "");
    $("#upload").val('');
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
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {

        $.ajax({
            url: base_url + "recruiter/ajaxpro",
            type: "POST",
            data: {"image": resp},
            success: function (data) {
                if (data)
                {
                    $("#row2").html(data);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";

                }
            }
        });

    });
});

$('.cancel-result').on('click', function (ev) {

    document.getElementById('row2').style.display = "block";
    document.getElementById('row1').style.display = "none";
    document.getElementById('message1').style.display = "none";
    $(".cr-image").attr("src", "");
});

//aarati code start
$('#upload').on('change', function () {
    //alert("hello");


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

    // pallavi code start for file type support
    if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        //alert('not an image');
        picpopup();

        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    // file type code end

    if (size > 26214400)
    {
        //show an alert to the user
        alert("Allowed file size exceeded. (Max. 25 MB)")

        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";

        return false;
    }


    $.ajax({

        url: base_url + "recruiter/image",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function (response) {

        }
    });
});

//aarati code end

// cover image end

function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea/>");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    // setup the blur event for this new textarea
    editableText.blur(editableTextBlurred);
}

function editableTextBlurred() {
    var html = $(this).val();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Designation";
    }
    viewableText.html(html);
    $(this).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(divClicked);

    $.ajax({
        url: base_url + "recruiter/ajax_designation",
        type: "POST",
        data: {"designation": html},
        success: function (response) {

        }
    });
}

$(document).ready(function () {
    $("a.designation").click(divClicked);
});



//script for profile pic strat

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
    // pallavi code for not supported file type 10/06/2017
    profile = this.files;
    //alert(profile);
    if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        //alert('not an image');
        $('#profilepic').val('');
        picpopup();
        return false;
    } else {
        readURL(this);
    }

    // end supported code 
});

// script for profile pic end  


//validation for edit email formate form

$(document).ready(function () {

    $("#userimage").validate({

        rules: {

            profilepic: {

                required: true,

            },

        },

        messages: {

            profilepic: {

                required: "Photo Required",

            },

        },
        submitHandler: profile_pic
    });
});

function picpopup() {

    $('.biderror .mes').html("<div class='pop_content'>Only image Type is Supported");
    $('#bidmodal').modal('show');
}


$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});


//For Scroll page at perticular position js Start
$(document).ready(function () {

//  $(document).load().scrollTop(1000);

    $('html,body').animate({scrollTop: 265}, 100);

});
//For Scroll page at perticular position js End

// recruiter search header 2  start
//UPLOAD PROFILE PIC START
function profile_pic() {
    if (typeof FormData !== 'undefined') {

        var formData = new FormData($("#userimage")[0]);
        $.ajax({

            url: base_url + "recruiter/user_image_insert",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                $('#bidmodal-2').modal('hide');
                $(".user-pic").html(data);
                document.getElementById('profilepic').value = null;
                $('#preview').prop('src', '#');
                $('#preview').hide();
                $('.popup_previred').hide();
            },
        });
        return false;
    }
}
//UPLOAD PROFILE PIC END

