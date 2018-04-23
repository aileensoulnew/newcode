$('.modal-close').on('click', function () {
   document.getElementById('upload-demo-one').style.display = 'none';
    document.getElementById('upload-one').value = null;
   $('.cr-image').attr('src', '#');
    });


$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $( "#bidmodal-2" ).hide();
        document.getElementById('upload-demo-one').style.display = 'none';
        document.getElementById('upload-one').value = null;
    }
});

// script for profile pic strat 

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview').style.display = 'block';
            $('#preview').attr('src', e.target.result);
            $('.popup_previred').show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#profilepic").change(function () {
    // pallavi code for not supported file type 15/06/2017
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

function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Only Image Type Supported");
    $('#bidmodal').modal('show');
}
//validation for edit email formate form
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

function profile_pic(event){

  $uploadCrop1.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                //url: "/ajaxpro.php", user_image_insert
               // url: "<?php echo base_url(); ?>freelancer/ajaxpro_test",
               url: base_url + "dashboard/profilepic",
                type: "POST",
                dataType: 'json',
                data: {"image": resp},


                 beforeSend: function () {
                        //$(".art_photos").html('<p style="text-align:center;"><img src = "<?php echo base_url('images/loading.gif?ver='.time()) ?>" class = "loader" /></p>');
                        $(".user_profile").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                success: function (data) { 
                  $('#bidmodal-2').modal('hide');
                    $(".profile-photo").html(data.uimage);
                    $("#profile-photohead").html(data.uimagehead);
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-demo-one').style.display = 'none';
                     $('.loader').remove();
                   //$('.cr-image').attr('src', '#');
                   
                }
            });
        });

}
});







// cover image start 

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

           $.ajax({
                            url: base_url + "dashboard/ajaxpro",
                            //url: "<?php echo base_url() ?>artistic/ajaxpro",
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


    $("#upload").change(function () { 
        var fd = new FormData();
        fd.append("image", $("#upload")[0].files[0]);
        files = this.files;
        size = files[0].size;
if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)){ 
    picpopup();
    document.getElementById('row1').style.display = "none";
    document.getElementById('row2').style.display = "block";
   $("#upload").val('');
    return false;
  }

  if (size > 10485760)
        {
            alert("Allowed file size exceeded. (Max. 10 MB)")
            document.getElementById('row1').style.display = "none";
            document.getElementById('row2').style.display = "block"; 
            return false;
        }
        $.ajax({

            url: base_url + "dashboard/image",
            //url: "<?php echo base_url(); ?>artistic/image",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
            }
        });
    });

// cover image end 




//$(window).load(function () {
//    $('#onload-Modal').modal('show').fadeIn("slow");
//});
$(document).ready(function () {
    $("body").click(function (event) {
    });
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $("#jop-popup").fadeOut(200);
        $("#jop-popup").removeClass("in");
        $("#jop-popup").attr("aria-hidden", "true");
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $("#rec-popup").fadeOut(200);
        $("#rec-popup").removeClass("in");
        $("#rec-popup").attr("aria-hidden", "true");
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $("#fre-popup").fadeOut(200);
        $("#fre-popup").removeClass("in");
        $("#fre-popup").attr("aria-hidden", "true");
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bus-popup').fadeOut(200);
        $("#bus-popup").removeClass("in");
        $("#bus-popup").attr("aria-hidden", "true");
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#art-popup').fadeOut(200);
        $("#art-popup").removeClass("in");
        $("#art-popup").attr("aria-hidden", "true");
    }
});
//THIS SCRIPT IS USED FOR CHANGE SLIDE WHILE CLICK ON IMAGE BUTTON START
$(document).ready(function () {
    var slides = document.querySelectorAll('.main_box #inner .item');
    var slides1 = document.querySelectorAll('.main_box #temp_btn #temp_btn1 .ld_sl');

    var currentSlide = 0;
    var currentSlide_width = 0;

    $('#left_img').click(function (event)
    {

      //  event.preventDefault();
        //set time out is used for disable and enable arrow for some time
        setTimeout(function () {
            $('#left_img').addClass('custom-disabled');
            //....and whatever else you need to do
        }, 30);
        setTimeout(function () {
            $('#left_img').removeClass('custom-disabled');
            //....and whatever else you need to do
        }, 3000);
        setTimeout(function () {
            $('#right_img').addClass('custom-disabled');
            //....and whatever else you need to do
        }, 30);

        setTimeout(function () {
            $('#right_img').removeClass('custom-disabled');
            //....and whatever else you need to do
        }, 3000);


        $('#right_img').removeClass('abc_left');
        $('#right_img').addClass('abc_show');

        /*slides[currentSlide].className = 'item';*/
        currentSlide = (currentSlide + 1) % slides.length;

        /*slides[currentSlide].className = 'item active';*/
        slides1[currentSlide_width].className = 'ld_sl';
        currentSlide_width = (currentSlide_width + 1) % slides1.length;
        slides1[currentSlide_width].className = 'ld_sl sld-width-' + (currentSlide + 1);
  
  //alert()
        if ((currentSlide + 1) == slides.length)
        {
            $('#left_img').addClass('abc');
        }

    });

    $('#right_img').click(function (event)
    {
       // event.preventDefault();

        setTimeout(function () {
            $('#left_img').addClass('custom-disabled');
            //....and whatever else you need to do
        }, 30);

        setTimeout(function () {
            $('#left_img').removeClass('custom-disabled');
            //....and whatever else you need to do
        }, 2500);

        setTimeout(function () {
            $('#right_img').addClass('custom-disabled');
            //....and whatever else you need to do
        }, 30);

        setTimeout(function () {
            $('#right_img').removeClass('custom-disabled');
            //....and whatever else you need to do
        }, 2500);

        /*slides[currentSlide].className = 'item';*/
        currentSlide = (currentSlide - 1) % slides.length;
        /*slides[currentSlide].className = 'item active';*/
        if (currentSlide == 0)
        {
            $('#right_img').removeClass('abc_show');
            $('#right_img').addClass('abc_left');

        }

        if (currentSlide == 14 || currentSlide < 14)
        {
          
            $('#left_img').removeClass('abc');
           // $('#left_img').removeClass('abc');
        }

        slides1[currentSlide_width].className = 'ld_sl';
        currentSlide_width = (currentSlide_width - 1) % slides1.length;
        slides1[currentSlide_width].className = 'ld_sl sld-width-' + (currentSlide + 1);


    });

});
//THIS SCRIPT IS USED FOR CHANGE SLIDE WHILE CLICK ON IMAGE BUTTON END

// scroll top
$(document).ready(function () {
    // Add smooth scrolling to all links
    $(".right-profile ul li a").on('click', function (event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
});

function updateprofilepopup(id) {
    $('#bidmodal-2').modal('show');
}

// all popup close close using esc start
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});
//all popup close close using esc end




function tabindexjob() {


    $("#job-scroll").addClass("tabindex");


    $("#rec-scroll").removeClass("tabindex");
    $("#free-scroll").removeClass("tabindex");
    $("#bus-scroll").removeClass("tabindex");
    $("#art-scroll").removeClass("tabindex");

}
function tabindexrec() {


    $("#rec-scroll").addClass("tabindex");


    $("#job-scroll").removeClass("tabindex");
    $("#free-scroll").removeClass("tabindex");
    $("#bus-scroll").removeClass("tabindex");
    $("#art-scroll").removeClass("tabindex");

}
function tabindexfree() {


    $("#free-scroll").addClass("tabindex");


    $("#rec-scroll").removeClass("tabindex");
    $("#job-scroll").removeClass("tabindex");
    $("#bus-scroll").removeClass("tabindex");
    $("#art-scroll").removeClass("tabindex");

}
function tabindexbus() {


    $("#bus-scroll").addClass("tabindex");


    $("#rec-scroll").removeClass("tabindex");
    $("#free-scroll").removeClass("tabindex");
    $("#job-scroll").removeClass("tabindex");
    $("#art-scroll").removeClass("tabindex");

}
function tabindexart() {
    $("#art-scroll").addClass("tabindex");

    $("#rec-scroll").removeClass("tabindex");
    $("#free-scroll").removeClass("tabindex");
    $("#bus-scroll").removeClass("tabindex");
    $("#job-scroll").removeClass("tabindex");

}
function sendmail(abc) {

    //alert(abc);
document.getElementById("verifydiv").style.display = "none";

    $.ajax({

        url: base_url + "registration/res_mail",
        type: "POST",
        data: 'user_email=' + abc,
        success: function (response) {
            $('.biderror .mes').html("<div class='pop_content'>Email sent Successfully.");
            $('#bidmodal').modal('show');
            window.open(response);
        }
    });
}

function closever() {

    $.ajax({
        type: 'POST',
        url: base_url + 'dashboard/closever',
        success: function (response) {

            $('#verifydiv').hide();
        }
    })
}

//on hover click class add and class remove start
$(".odd").hover(function () {
    $('.even').addClass("even-custom");
}, function () {
    $('.even').removeClass("even-custom");
});
//on hover click class add and class remove End


//Function to animate slider captions 
function doAnimations(elems) {
    //Cache the animationend event in a variable
    var animEndEv = 'webkitAnimationEnd animationend';

    elems.each(function () {
        var $this = $(this),
                $animationType = $this.data('animation');
        $this.addClass($animationType).one(animEndEv, function () {
            $this.removeClass($animationType);
        });
    });
}

//Variables on page load 
var $myCarousel = $('#carousel-example-generic'),
        $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");

//Initialize carousel 
$myCarousel.carousel();

//Animate captions in first slide on page load 
doAnimations($firstAnimatingElems);

//Pause carousel  
$myCarousel.carousel('pause');

//Other slides to be animated on carousel slide event 
$myCarousel.on('slide.bs.carousel', function (e) {
    var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
    doAnimations($animatingElems);
});
$('#carousel-example-generic').carousel({
    interval: 3000,
    pause: "false"
});

