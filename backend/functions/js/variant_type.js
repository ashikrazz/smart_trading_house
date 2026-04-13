function show_datatable(){
    $("#contentWrapper").load("contents/variant_type_datatable.php");
}

/* SAVE */
function save_variant_type() {

    var name = $("#variant_type_name").val().trim();
    if (name === "") {
        toastr.error("Please Enter Variant Type Name");
        $("#name").focus();
        return false;
    }

    var dataStr = $("#variantTypeForm").serialize();
    dataStr += "&operation=save";

    $.ajax({
        url: "functions/variant_type.php",
        type: "POST",
        data: dataStr,
        dataType: "text",
        success: function (res) {
            //alert(res);
            if (res.trim()=="Success") {
                toastr.success("variant Type Added Successfully");
                $("#variantTypeForm")[0].reset();
                setTimeout(function () {
                    window.location.href = "?page=manage_variant_type";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Variant Type Add Failed");
                alert(res);
            }
        }
    });
}


/* UPDATE */
function update_variant_type(id) {

    var name = $("#variant_type_name").val().trim();
    if (name === "") {
        toastr.error("Please Enter Variant Type Name");
        return false;
    }

    var dataStr = $("#variantTypeForm").serialize();
    dataStr += "&id=" + id + "&operation=update";

    $.ajax({
        url: "functions/variant_type.php",
        type: "POST",
        data: dataStr,
        success: function (res) {
            if (res.trim() === "Success") {
                toastr.success("Variant Type Updated Successfully");
                setTimeout(function () {
                    window.location.href = "?page=manage_variant_type";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Variant Type Update Failed");
            }
        }
    });
}


/* PUBLISH */
function publish_variant_type(id) {
    $.post("functions/variant_type.php", { id, operation: "publish" }, function (res) {
        if (res.trim() === "Success") {
            toastr.success("Variant Type Published Successfully");
            $("#contentWrapper").load("contents/variant_type_datatable.php");
        } else {
            toastr.error("Publish Failed");
        }
    });
}


/* UNPUBLISH */
function unpublish_variant_type(id) {
    $.post("functions/variant_type.php", { id, operation: "unpublish" }, function (res) {
        if (res.trim() === "Success") {
            toastr.success("Variant Type Unpublished Successfully");
            $("#contentWrapper").load("contents/variant_type_datatable.php");
        } else {
            toastr.error("Unpublish Failed");
        }
    });
}


/* REMOVE */
function removed_variant_type(id) {
    $.post("functions/variant_type.php", { id, operation: "remove" }, function (res) {
        if (res.trim() === "Success") {
            toastr.success("Variant Type Removed Successfully");
            $("#contentWrapper").load("contents/variant_type_datatable.php");
        } else {
            toastr.error("Variant Type Removed Failed");
        }
    });
}
