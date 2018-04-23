
function checkvalue() {

    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}
// end of business search auto fill 
$(".alert").delay(3200).fadeOut(300);
function delete_job_exp(grade_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/bus_img_delete",
        data: 'grade_id=' + grade_id,
        success: function (data) {
            if (data) {

                $('.job_work_edit_' + grade_id).remove();
            }
        }
    });
}

// footer end 
$("#image1").change(function () {
    readURL(this);
});
// only iamge upload validation strat


function validate(event) {


    var fileInput = document.getElementById("image1").files;
    if (fileInput != '')
    {
        for (var i = 0; i < fileInput.length; i++)
        {

            var vname = fileInput[i].name;
            var ext = vname.split('.').pop();
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'PNG'];
            var foundPresent = $.inArray(ext, allowedExtensions) > -1;
            // alert(foundPresent);

            if (foundPresent == true)
            {
            } else {
                $(".bus_image").html("Please select only Image File.");
                event.preventDefault();
                //return false; 
            }
        }
    }
}
function removemsg() {
    $(".bus_image").html(" ");
    document.getElementById("image1").value = null;
}

function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
