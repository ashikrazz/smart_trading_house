function show_product_type_datatable(){
    $("#contentWrapper").load("contents/product_type_datatable.php");
}

function product_type_icon_upload() {
    var file = $("#product_type_icon").prop("files")[0];
    if (!file) return;
    var fd = new FormData();
    fd.append("file", file);
    fd.append("path", "../../../resources/product_type/icon/");

    var allowed = /(\.jpg|\.jpeg|\.png|\.svg)$/i;
    if (!allowed.exec(file.name)) { alert("Upload jpg/jpeg/png/svg only"); return; }

    $.ajax({
        url: "functions/lib/web_upload_file.php",
        type: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function(res) {
            $("#hidden_icon").val(res);
            $("#uploaded_icon").html('<img src="../resources/product_type/icon/' + res + '" style="width:100px;">');
        }
    });
}

async function save_product_type() {
    $(".error-msg").remove();
    $(".form-group").css('border','');

    let type = $("#product_type").val().trim();
    let short_desc = $("#product_type_short_desc").val().trim();
    let full_desc = $("#product_type_full_desc").val().trim();
    let icon = $("#hidden_icon").val();
    let status = $("#publish_status").val();

    let hasError = false;

    function showError(id,msg){
        let $wrapper = $("#" + id + "_wrapper");
        $wrapper.append('<small class="error-msg" style="color:red;display:block;margin-top:3px;">'+msg+'</small>');
        hasError = true;
    }

    if(type=="") showError("product_type","Product Type Required");
    if(short_desc=="") showError("short_desc","Short Description Required");
    if(full_desc=="") showError("full_desc","Full Description Required");
    if(icon=="") showError("icon","Icon Required");

    if(hasError) return false;

    let dataStr = $("#productTypeForm").serialize() + "&operation=save";

    $.ajax({
        url:"functions/product_type.php",
        type:"POST",
        data:dataStr,
        dataType:"text",
        success:function(res){
            if(res.trim()=="Success"){
                toastr.success("Product Type Added Successfully");
                $("#productTypeForm")[0].reset();
                $("#uploaded_icon").html("");
                setTimeout(()=>{ window.location.href="?page=manage_products_type"; },1000);
            } else {
                toastr.error("Failed to Add Product Type");
            }
        },
        error:function(){ toastr.error("AJAX Error Occurred"); }
    });
}


function update_product_type(id){
    var dataStr = $("#productTypeForm").serialize() + "&id=" + id + "&operation=update";
    //alert(dataStr);
    $.post("functions/product_type.php", dataStr, function(res){
        res = res.trim();
        //alert(res);
        if(res=="Success"){
            toastr.success("Product Type Updated Successfully");
            setTimeout(()=>{ window.location.href="?page=manage_products_type"; },1000);
        } else {
            toastr.error("Update Failed");
        }
    });
}

function publish(id){ $.post("functions/product_type.php",{id,operation:"publish"},function(res){ res=res.trim(); if(res=="Success"){ toastr.success("Published"); show_product_type_datatable(); } else toastr.error("Failed"); }); }
function unpublish(id){ $.post("functions/product_type.php",{id,operation:"unpublish"},function(res){ res=res.trim(); if(res=="Success"){ toastr.success("Unpublished"); show_product_type_datatable(); } else toastr.error("Failed"); }); }
function removed(id){ $.post("functions/product_type.php",{id,operation:"remove"},function(res){ res=res.trim(); if(res=="Success"){ toastr.success("Removed"); show_product_type_datatable(); } else toastr.error("Failed"); }); }

// --------------- LIVE ERROR REMOVAL ----------------
$(document).ready(function(){
    $("#product_type,#product_type_short_desc,#product_type_full_desc,#product_type_icon,#publish_status")
        .on("input change", function(){
            let id = this.id;
            $("#" + id + "_wrapper").css('border','');
            $(this).siblings(".error-msg").remove();
        });
});
