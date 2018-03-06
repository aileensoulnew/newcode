function updateprofilepopup(e) {
    document.getElementById("upload-demo-one").style.display = "none", document.getElementById("upload-one").value = null, $("#bidmodal-2").modal("show")
}

function readURL(e) {
    if (e.files && e.files[0]) {
        var t = new FileReader;
        t.onload = function(e) {
            document.getElementById("preview").style.display = "block", $("#preview").attr("src", e.target.result)
        }, t.readAsDataURL(e.files[0])
    }
}

function picpopup() {
    $(".biderror .mes").html("<div class='pop_content'>This is not valid file. Please Uplode valid Image File."), $("#bidmodal").modal("show")
}

function myFunction() {
    document.getElementById("upload-demo").style.visibility = "hidden", document.getElementById("upload-demo-i").style.visibility = "hidden", document.getElementById("message1").style.display = "block"
}

function showDiv() {
    document.getElementById("row1").style.display = "block", document.getElementById("row2").style.display = "none"
}
$(function() {
    function e(e) {
        return e.split(/,\s*/)
    }

    function t(t) {
        return e(t).pop()
    }
    $(".tags").bind("keydown", function(e) {
        e.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active && e.preventDefault()
    }).autocomplete({
        minLength: 1,
        source: function(e, o) {
            $.getJSON(base_url + "business_profile/ajax_business_skill", {
                term: t(e.term)
            }, o)
        },
        focus: function() {
            return !1
        },
        select: function(t, o) {
            var i = e(this.value);
            if (i.length <= 1) return i.pop(), i.push(o.item.value), i.push(""), this.value = i.join(""), !1;
            var n = i.pop();
            return $(this).val(this.value.substr(0, this.value.length - n.length - 2)), $(this).effect("highlight", {}, 1e3), $(this).attr("style", "border: solid 1px red;"), !1
        }
    }), $(".searchplace").bind("keydown", function(e) {
        e.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active && e.preventDefault()
    }).autocomplete({
        minLength: 1,
        source: function(e, o) {
            $.getJSON(base_url + "business_profile/ajax_location_data", {
                term: t(e.term)
            }, o)
        },
        focus: function() {
            return !1
        },
        select: function(t, o) {
            var i = e(this.value);
            if (i.length <= 1) return i.pop(), i.push(o.item.value), i.push(""), this.value = i.join(""), !1;
            var n = i.pop();
            return $(this).val(this.value.substr(0, this.value.length - n.length - 2)), $(this).effect("highlight", {}, 1e3), $(this).attr("style", "border: solid 1px red;"), !1
        }
    })
}), $uploadCrop1 = $("#upload-demo-one").croppie({
    enableExif: !0,
    viewport: {
        width: 157,
        height: 157,
        type: "square"
    },
    boundary: {
        width: 257,
        height: 257
    }
}), $("#upload-one").on("change", function() {
    document.getElementById("upload-demo-one").style.display = "block";
    var e = new FileReader;
    e.onload = function(e) {
        $uploadCrop1.croppie("bind", {
            url: e.target.result
        }).then(function() {
            console.log("jQuery bind complete")
        })
    }, e.readAsDataURL(this.files[0])
}), $(document).ready(function() {
    function e() {
        $uploadCrop1.croppie("result", {
            type: "canvas",
            size: "viewport"
        }).then(function(e) {
            $.ajax({
                url: base_url + "business_profile/user_image_insert_new",
                type: "POST",
                data: {
                    image: e
                },
                beforeSend: function() {
                    $("#profile_loader").show()
                },
                complete: function() {},
                success: function(e) {
                    $("#profile_loader").hide(), $("#bidmodal-2").modal("hide"), $(".user-pic").html(e), document.getElementById("upload-one").value = null, document.getElementById("upload-demo-one").value = ""
                }
            })
        })
    }
    $("#userimage").validate({
        rules: {
            profilepic: {
                required: !0
            }
        },
        messages: {
            profilepic: {
                required: "Photo required"
            }
        },
        submitHandler: e
    })
}), $("#profilepic").change(function() {
    return profile = this.files, profile[0].name.match(/.(jpg|jpeg|png|gif)$/i) ? void readURL(this) : ($("#profilepic").val(""), picpopup(), !1)
}), $(document).on("keydown", function(e) {
    27 === e.keyCode && $("#bidmodal-2").modal("hide")
}), $uploadCrop = $("#upload-demo").croppie({
    enableExif: !0,
    viewport: {
        width: 1250,
        height: 350,
        type: "square"
    },
    boundary: {
        width: 1250,
        height: 350
    }
}), $(".upload-result").on("click", function(e) {
    document.getElementById("upload-demo").style.visibility = "hidden", document.getElementById("upload-demo-i").style.visibility = "hidden", document.getElementById("message1").style.display = "block", $uploadCrop.croppie("result", {
        type: "canvas",
        size: "viewport"
    }).then(function(e) {
        var t = e.length;
        return 11350 == t ? (document.getElementById("row2").style.display = "block", document.getElementById("row1").style.display = "none", document.getElementById("message1").style.display = "none", document.getElementById("upload-demo").style.visibility = "visible", document.getElementById("upload-demo-i").style.visibility = "visible", !1) : void $.ajax({
            url: base_url + "business_profile/ajaxpro",
            type: "POST",
            data: {
                image: e
            },
            success: function(e) {
                $("#row2").html(e), document.getElementById("row2").style.display = "block", document.getElementById("row1").style.display = "none", document.getElementById("message1").style.display = "none", document.getElementById("upload-demo").style.visibility = "visible", document.getElementById("upload-demo-i").style.visibility = "visible"
            }
        })
    })
}), $(".cancel-result").on("click", function(e) {
    document.getElementById("row2").style.display = "block", document.getElementById("row1").style.display = "none", document.getElementById("message1").style.display = "none"
}), $("#upload").on("change", function() {
    var e = new FileReader;
    e.onload = function(e) {
        $uploadCrop.croppie("bind", {
            url: e.target.result
        }).then(function() {
            console.log("jQuery bind complete")
        })
    }, e.readAsDataURL(this.files[0])
}), $("#upload").on("change", function() {
    var e = new FormData;
    return e.append("image", $("#upload")[0].files[0]), files = this.files, size = files[0].size, files[0].name.match(/.(jpg|jpeg|png|gif)$/i) ? size > 4194304 ? (alert("Allowed file size exceeded. (Max. 4 MB)"), document.getElementById("row1").style.display = "none", document.getElementById("row2").style.display = "block", !1) : void $.ajax({
        url: base_url + "business_profile/imagedata",
        type: "POST",
        data: e,
        processData: !1,
        contentType: !1,
        success: function(e) {}
    }) : (picpopup(), document.getElementById("row1").style.display = "none", document.getElementById("row2").style.display = "block", $("#upload").val(""), !1)
});