function show_datatable(){
    $("#contentWrapper").load("contents/measurement_unit_datatable.php");
}

/* SAVE */
function save_unit() {

    var name = $("#name").val().trim();
    if (name === "") {
        toastr.error("Please Enter Measurement Unit Name");
        $("#name").focus();
        return false;
    }

    var dataStr = $("#unitForm").serialize();
    dataStr += "&operation=save";

    $.ajax({
        url: "functions/measurement_unit.php",
        type: "POST",
        data: dataStr,
        dataType: "text",
        success: function (res) {
            //alert(res);
            if (res.trim()=="Success") {
                toastr.success("Measurement Unit Added Successfully");
                $("#unitForm")[0].reset();
                setTimeout(function () {
                    window.location.href = "?page=manage_measurement_unit";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Measurement Unit Add Failed");
                alert(res);
            }
        }
    });
}


/* UPDATE */
function update_unit(id) {

    var name = $("#name").val().trim();
    if (name === "") {
        toastr.error("Please Enter Measurement Unit Name");
        return false;
    }

    var dataStr = $("#unitForm").serialize();
    dataStr += "&id=" + id + "&operation=update";

    $.ajax({
        url: "functions/measurement_unit.php",
        type: "POST",
        data: dataStr,
        success: function (res) {
            if (res.trim() === "Success") {
                toastr.success("Measurement Unit Updated Successfully");
                setTimeout(function () {
                    window.location.href = "?page=manage_measurement_unit";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Measurement Unit Update Failed");
            }
        }
    });
}


/* PUBLISH */
function publish_unit(id) {
    $.post("functions/measurement_unit.php", { id, operation: "publish" }, function (res) {
        if (res.trim() === "Success") {
            toastr.success("Measurement Unit Published Successfully");
            $("#contentWrapper").load("contents/measurement_unit_datatable.php");
        } else {
            toastr.error("Publish Failed");
        }
    });
}


/* UNPUBLISH */
function unpublish_unit(id) {
    $.post("functions/measurement_unit.php", { id, operation: "unpublish" }, function (res) {
        if (res.trim() === "Success") {
            toastr.success("Measurement Unit Unpublished Successfully");
            $("#contentWrapper").load("contents/measurement_unit_datatable.php");
        } else {
            toastr.error("Unpublish Failed");
        }
    });
}


/* REMOVE */
function removed_unit(id) {
    $.post("functions/measurement_unit.php", { id, operation: "remove" }, function (res) {
        if (res.trim() === "Success") {
            toastr.success("Measurement Unit Removed Successfully");
            $("#contentWrapper").load("contents/measurement_unit_datatable.php");
        } else {
            toastr.error("Measurement Unit Removed Failed");
        }
    });
}
