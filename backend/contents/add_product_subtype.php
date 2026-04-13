<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
$id = isset($id) ? $id : '';
if ($id != ""){
    $web_product_subtype_info = $obj->Details_By_Cond("web_product_subtype", "id='$id'");
    $name = $web_product_subtype_info['name'];
    $short_description = $web_product_subtype_info['short_desc'];
    $long_description = $web_product_subtype_info['long_desc'];
    $status = $web_product_subtype_info['active_flag'];
    $product_type_ref = $web_product_subtype_info['product_type_ref'];
}
?>
<script src="functions/js/product_subtype.js"></script>

<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Product Sub-Type</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Product Sub-Type</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white"
                            onclick="window.location.href='?page=manage_products_subtype'">
                        <i class="fas fa-binoculars"></i> View All
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="productSubtypeForm">

                            <div class="row">

                                <div class="col-md-4" id="type_wrapper">
                                    <div class="form-group">
                                        <label>Product Type</label>
                                        <select class="form-control" id="product_type_id" name="product_type_id">
                                            <option value="">-- Select Product Type --</option>
                                            <?php
                                            foreach ($obj->View_All_By_Cond("web_product_type","active_flag=1") as $row) {

                                                $selected = (!empty($product_type_ref) && $product_type_ref == $row['id'])
                                                        ? "selected='selected'"
                                                        : "";

                                                echo "<option value='{$row['id']}' $selected>
                                                        {$row['product_type_title']}
                                                      </option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id="subtype_wrapper">
                                    <div class="form-group">
                                        <label>Product Sub-Type</label>
                                        <input type="text" class="form-control" id="product_subtype" name="product_subtype" value="<?php echo $name?>">
                                    </div>
                                </div>

                                <div class="col-md-4" id="short_desc_wrapper">
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea class="form-control" id="short_desc" name="short_desc"><?php echo $short_description?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4" id="full_desc_wrapper">
                                    <div class="form-group">
                                        <label>Full Description</label>
                                        <textarea class="form-control" id="full_desc" name="full_desc"><?php echo $long_description?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="active_flag" name="active_flag">
                                            <option <?php if($status==1){ echo "selected='selected'";}?> value="1">Publish</option>
                                            <option value="2" <?php if($status==2){ echo "selected='selected'";} ?>>Unpublish</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <?php if ($id != ""){ ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="button" onclick="update_product_subtype(<?php echo $id?>)" class="btn btn-primary mt-3">Update Product Sub-Type</button>
                            <?php } else { ?>
                                <button type="button" onclick="save_product_subtype()" class="btn btn-primary mt-3">Save Product Sub-Type</button>
                            <?php } ?>


                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {

        const form = document.getElementById("productSubtypeForm");

        // 1️⃣ Focus first field → Product Type select
        const firstField = document.getElementById("product_type_id");
        if (firstField) {
            firstField.focus();

            // Auto open dropdown
            setTimeout(() => {
                firstField.size = firstField.options.length;
            }, 50);
        }

        // 2️⃣ Auto-open select on focus
        form.addEventListener("focusin", function (e) {
            if (e.target.tagName === "SELECT") {
                setTimeout(() => {
                    e.target.size = e.target.options.length;
                }, 50);
            }
        });

        form.addEventListener("change", function (e) {
            if (e.target.tagName === "SELECT") {
                e.target.size = 0;
            }
        });

        form.addEventListener("focusout", function (e) {
            if (e.target.tagName === "SELECT") {
                e.target.size = 0;
            }
        });

        // 3️⃣ ENTER KEY FULL NAVIGATION
        document.addEventListener("keydown", function (e) {

            if (e.key !== "Enter") return;

            const active = document.activeElement;

            if (!active.closest("#productSubtypeForm")) return;

            // Allow Shift+Enter for textarea newline
            if (active.tagName === "TEXTAREA") {
                if (e.shiftKey) return;
                e.preventDefault();
            } else {
                e.preventDefault();
            }

            const focusable = Array.from(
                form.querySelectorAll(
                    "input:not([type=hidden]):not([readonly]):not([disabled]), " +
                    "select:not([disabled]), " +
                    "textarea:not([readonly]):not([disabled])"
                )
            ).filter(el => el.offsetParent !== null);

            const index = focusable.indexOf(active);

            // File input → open dialog and move next
            if (active.type === "file") {
                active.click();
                setTimeout(() => {
                    if (index > -1 && index < focusable.length - 1) {
                        focusable[index + 1].focus();
                    }
                }, 100);
                return;
            }

            // Move to next field
            if (index > -1 && index < focusable.length - 1) {
                focusable[index + 1].focus();
            }
            // Last field → submit
            else {
                submitProductSubtypeForm();
            }
        });
    });

    // 4️⃣ Auto Save / Update
    function submitProductSubtypeForm() {
        const subtypeId = document.querySelector('input[name="id"]');
        if (subtypeId) {
            update_product_subtype(subtypeId.value);
        } else {
            save_product_subtype();
        }
    }
</script>



