function show_datatable(){
    $("#contentWrapper").load("contents/brand_datatable.php");
}

function brand_logo_upload() {

    var file_data = $('#profile_pic').prop('files')[0];
    var fd = new FormData();
    fd.append('file', file_data);
    fd.append('path', "../../../resources/brand/brand_logo/");

    var filePath = $('#profile_pic').val();
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        toastr.error("Only jpg, jpeg, png allowed");
        return false;
    }

    $.ajax({
        url: 'functions/lib/web_upload_file.php',
        type: 'POST',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            $("#hidden_profile_pic").val(res);
            $("#uploaded_profile_pic").html(
                "<img src='../resources/brand/brand_logo/" + res + "' style='width:100px'>"
            );
        }
    });
}


/* SAVE */
function save() {

    var name = $("#name").val().trim();
    if (name === "") {
        toastr.error("Please Enter Brand Name");
        $("#name").focus();
        return false;
    }

    var dataStr = $("#userForm").serialize();
    dataStr += "&operation=save";

    $.ajax({
        url: "functions/brand.php",
        type: "POST",
        data: dataStr,
        dataType: "text",
        success: function (res) {
            if (res === "Success") {
                toastr.success("Brand Added Successfully");
                $("#userForm")[0].reset();
                $("#uploaded_profile_pic").html("");
                setTimeout(function () {
                    window.location.href = "?page=manage_brand";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Brand Add Failed");
                alert(res);
            }
        }
    });
}


/* UPDATE */
function update(id) {

    var name = $("#name").val().trim();
    if (name === "") {
        toastr.error("Please Enter Brand Name");
        return false;
    }

    var dataStr = $("#userForm").serialize();
    dataStr += "&id=" + id + "&operation=update";

    $.ajax({
        url: "functions/brand.php",
        type: "POST",
        data: dataStr,
        success: function (res) {
            if (res === "Success") {
                toastr.success("Brand Updated Successfully");
                setTimeout(function () {
                    window.location.href = "?page=manage_brand";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Update Failed");
            }
        }
    });
}


/* PUBLISH */
function publish(id) {
    $.post("functions/brand.php", { id, operation: "publish" }, function (res) {
        if (res === "Success") {
            toastr.success("Brand Published Successfully");
            $("#contentWrapper").load("contents/brand_datatable.php");
        } else {
            toastr.error("Publish Failed");
        }
    });
}


/* UNPUBLISH */
function unpublish(id) {
    $.post("functions/brand.php", { id, operation: "unpublish" }, function (res) {
        if (res === "Success") {
            toastr.success("Brand Unpublished Successfully");
            $("#contentWrapper").load("contents/brand_datatable.php");
        } else {
            toastr.error("Unpublish Failed");
        }
    });
}


/* REMOVE */
function removed(id) {
    $.post("functions/brand.php", { id, operation: "remove" }, function (res) {
        if (res === "Success") {
            toastr.success("Brand Removed Successfully");
            $("#contentWrapper").load("contents/brand_datatable.php");
        } else {
            toastr.error("Brand Removed Failed");
        }
    });
}
