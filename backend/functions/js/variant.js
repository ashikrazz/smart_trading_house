function show_variant_datatable(){
    $("#contentWrapper").load("contents/variant_datatable.php");
}

/* ---------- SAVE ---------- */
function save_variant(){
    $(".error-msg").remove();

    let hasError = false;

    function err(id,msg){
        $("#" + id + "_wrapper")
            .append('<small class="error-msg" style="color:red">'+msg+'</small>');
        hasError = true;
    }

    if($("#product_id").val()=="") err("product_id","Select product");
    if($("#variant_type_id").val()=="") err("variant_type_id","Enter variant type");
    if($("#variant").val()=="") err("variant","variant required");

    if(hasError) return;

    let dataStr = $("#variantForm").serialize()+"&operation=save";

    $.post("functions/variant.php", dataStr, function(res){
        res = res.trim();
        if(res==="Success"){
            toastr.success("Variant Saved");
            setTimeout(()=>location.href='?page=manage_variant',800);
        } else {
            toastr.error("Variant Save Failed");
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
    "#product_id,#variant_type_id,#variant,#active_flag",
    function(){
        $(this).closest(".form-group").find(".error-msg").remove();
    });
