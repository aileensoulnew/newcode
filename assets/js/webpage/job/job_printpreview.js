//validation start
$(document).ready(function () {

        $("#jobdesignation").validate({

            rules: {

                designation: {

                    required: true,

                },

            },

            messages: {

                designation: {

                    required: "Designation is required.",

                },

            },

        });
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
    });
//validation End

//Save Post Start
function savepopup(id) {
        save_user(id);
        $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
        $('#bidmodal').modal('show');
    }

function save_user(abc)
    {
        $.ajax({
            type: 'POST',
            url: base_url +'recruiter/save_search_user',
            data: 'user_id=' + abc,
            success: function (data) {
                $('.' + 'saveduser' + abc).html(data).addClass('butt_rec');
            }
        });
    }
//Save Post End


//Tabing In Education And Graduation Start
$( document ).ready(function() {
  $('div[onload]').trigger('onload');
});
 function openCity(evt, cityName) {
  
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

  function opengrad(evt, cityName) {
    
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent1");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks1");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
//Tabing In Education And Graduation End


   $(".alert").delay(3200).fadeOut(300);