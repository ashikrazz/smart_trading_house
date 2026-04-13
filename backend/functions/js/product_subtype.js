function show_subtype_datatable(){
    $("#contentWrapper").load("contents/product_subtype_datatable.php");
}

/* ---------- SAVE ---------- */
function save_product_subtype(){
    $(".error-msg").remove();

    let hasError = false;

    function err(id,msg){
        $("#" + id + "_wrapper")
            .append('<small class="error-msg" style="color:red">'+msg+'</small>');
        hasError = true;
    }

    if($("#product_type_id").val()=="") err("type","Select product type");
    if($("#product_subtype").val()=="") err("subtype","Enter subtype name");
    if($("#short_desc").val()=="") err("short_desc","Short description required");
    if($("#full_desc").val()=="") err("full_desc","Full description required");

    if(hasError) return;

    let dataStr = $("#productSubtypeForm").serialize()+"&operation=save";

    $.post("functions/product_subtype.php", dataStr, function(res){
        res = res.trim();
        if(res==="Success"){
            toastr.success("Product Sub-Type Saved");
            setTimeout(()=>location.href='?page=manage_products_subtype',800);
        } else {
            toastr.error("Save Failed");
        }
    });
}

/* ---------- UPDATE ---------- */
function update_product_subtype(id){
    //alert(id);
    let dataStr = $("#productSubtypeForm").serialize()+"&id="+id+"&operation=update";
    //alert(dataStr);
    $.post("functions/product_subtype.php", dataStr, function(res){
        //alert(res);
        if(res.trim()=="Success"){
            toastr.success("Updated Successfully");
            setTimeout(()=>location.href='?page=manage_products_subtype',800);
        } else toastr.error("Update Failed");
    });
}

/* ---------- STATUS ---------- */
function publish(id){
    $.post("functions/product_subtype.php",{id,operation:"publish"},res=>{
        res=res.trim();
        if(res=="Success"){ toastr.success("Published"); show_subtype_datatable(); }
        else toastr.error("Failed");
    });
}

function unpublish(id){
    $.post("functions/product_subtype.php",{id,operation:"unpublish"},res=>{
        res=res.trim();
        if(res=="Success"){ toastr.success("Unpublished"); show_subtype_datatable(); }
        else toastr.error("Failed");
    });
}

function removed(id){
    $.post("functions/product_subtype.php",{id,operation:"remove"},res=>{
        res=res.trim();
        if(res=="Success"){ toastr.success("Deleted"); show_subtype_datatable(); }
        else toastr.error("Failed");
    });
}

/* ---------- LIVE ERROR REMOVAL ---------- */
$(document).on("input change",
    "#product_type_id,#product_subtype,#short_desc,#full_desc,#active_flag",
    function(){
        $(this).closest(".form-group").find(".error-msg").remove();
    });
