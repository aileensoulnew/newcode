

function checkvalue() {
                            //alert("hi");
                            var searchkeyword =$.trim(document.getElementById('tags').value);
                            var searchplace =$.trim(document.getElementById('searchplace').value);
                            // alert(searchkeyword);
                            // alert(searchplace);
                            if (searchkeyword == "" && searchplace == "") {
                                //alert('Please enter Keyword');
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

$(document).ready(function() {
      $('.blocks').jMosaic({items_type: "li", margin: 0});
      $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
    });


function updateprofilepopup(id) {
                                $('#bidmodal-2').modal('show');
}



function followuser(clicked_id)
    { //alert(clicked_id);

        $.ajax({
            type: 'POST',
            url: base_url + "artistic/follow_two",
            //url: '<?php echo base_url() . "artistic/follow_two" ?>',
            data: 'follow_to=' + clicked_id,
            success: function (data) {

                $('.' + 'fruser' + clicked_id).html(data);

            }
        });
    }

 

 $(document).ready(function() {
  $("html,body").animate({scrollTop: 350}, 100); //100ms for example
});

  function picpopup() {

            $('.biderror .mes').html("<div class='pop_content'>Only Image Type Supported");
            $('#bidmodal').modal('show');
}


 $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $('#bidmodal-2').modal('hide');
    }
});  


$(document).ready(function(){   
    $('html,body').animate({scrollTop:265}, 100);
});

