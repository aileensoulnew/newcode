// curreent work upload div script

function divClicked() {
                var divHtml = $(this).html();
                 divHtml = divHtml.trim();
                var editableText = $("<textarea />");
                editableText.val(divHtml);
                $(this).replaceWith(editableText);
                editableText.focus();
                // setup the blur event for this new textarea
                editableText.blur(editableTextBlurred);
            }

            function editableTextBlurred() {
                var html = $(this).val();
                 html = html.trim();
                var viewableText = $("<a>");
                if (html.match(/^\s*$/) || html == '') {
                    html = "Current Work";
                }
                viewableText.html(html);
                $(this).replaceWith(viewableText);
                // setup the click event for this new div
                viewableText.click(divClicked);

                $.ajax({
                    url: base_url + "artistic/art_designation",
                    //url: "<?php echo base_url(); ?>artistic/art_designation",
                    type: "POST",
                    data: {"designation": html},
                    success: function (response) {
                        
                    }
                });
            }

            $(document).ready(function () {
                // alert("hi");
                $("a.designation").click(divClicked);
            });



//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START
    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        $( "#tags" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
           
            minLength: 2,
            source: function( request, response ) { 
                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "artistic/artistic_search_keyword", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                var terms = split( this.value );
                if(terms.length <= 1) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "" );
                    return false;
                }else{
                   
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
            }
        });
    });

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END


//SCRIPT FOR CITY AUTOFILL OF SEARCH START

    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        $( "#searchplace" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 2,
            source: function( request, response ) { 
                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "artistic/artistic_search_city", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                var terms = split( this.value );
                if(terms.length <= 1) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "" );
                    return false;
                }else{
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
            }
        });
    });

//SCRIPT FOR CITY AUTOFILL OF SEARCH END


//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START

    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        $( "#tags1" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
           
            minLength: 2,
            source: function( request, response ) { 
                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "artistic/artistic_search_keyword", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                var terms = split( this.value );
                if(terms.length <= 1) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "" );
                    return false;
                }else{
                   
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
            }
        });
    });

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END

//SCRIPT FOR CITY AUTOFILL OF SEARCH START

    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) { 
            return split( term ).pop();
        }
        $( "#searchplace1" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 2,
            source: function( request, response ) { 
                // delegate back to autocomplete, but extract the last term
                $.getJSON(base_url + "artistic/artistic_search_city", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
               
                var terms = split( this.value );
                if(terms.length <= 1) {
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( "" );
                    return false;
                }else{
                    var last = terms.pop();
                    $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                    $(this).effect("highlight", {}, 1000);
                    $(this).attr("style","border: solid 1px red;");
                    return false;
                }
            }
        });
    });

//SCRIPT FOR CITY AUTOFILL OF SEARCH END

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

jQuery(document).ready(function($) {  
// site preloader -- also uncomment the div in the header and the css style for #preloader
 $(window).on('load', function(){
  $('#preloader').fadeOut('slow',function(){$(this).remove();});
});
});

// profile iamge uplaod START

// validation for profile pic upload

$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 157,
        height: 157,
        type: 'square'
    },
    boundary: {
        width: 257,
        height: 257,
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

                            required: "Image Required",

                        },

                    },

                     submitHandler: profile_pic

                });

 function profile_pic(){

    $uploadCrop1.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                //url: "/ajaxpro.php", user_image_insert
               // url: "<?php echo base_url(); ?>freelancer/ajaxpro_test",
               url: base_url + "artistic/profilepic",
                type: "POST",
                data: {"image": resp},

                 beforeSend: function () {
                        //$(".art_photos").html('<p style="text-align:center;"><img src = "<?php echo base_url('images/loading.gif?ver='.time()) ?>" class = "loader" /></p>');
                        $(".user_profile").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                success: function (data) {
                  $('#bidmodal-2').modal('hide');
                    $(".user-pic").html(data);
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-demo-one').style.display = 'none';
                     $('.loader').remove();
                   //$('.cr-image').attr('src', '#');
                   
                }
            });
        });

    }

            });


    // script for profile pic strat

            $("#profilepic").change(function () {
                profile = this.files;
                   //alert(profile);
                      if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)){
                       //alert('not an image');
                  $('#profilepic').val('');
                   picpopup();
                     return false;
                   }else{
                      readURL(this);}
            });




function showDiv() {
        document.getElementById('row1').style.display = "block";
        document.getElementById('row2').style.display = "none";
        $(".cr-image").attr("src","");
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
                            url: base_url + "artistic/ajaxpro",
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
        $(".cr-image").attr("src","");

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

            url: base_url + "artistic/image",
            //url: "<?php echo base_url(); ?>artistic/image",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
            }
        });
    });

$('#upload').click(function(){
   var input = document.getElementsByTagName('#upload')[0];
    this.value = null;
});
    


    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});

 
