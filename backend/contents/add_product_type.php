<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
$id = isset($id) ? $id : '';
if ($id != ""){
    $web_product_type_info = $obj->Details_By_Cond("web_product_type", "id='$id'");
    $name = $web_product_type_info['product_type_title'];
    $short_description = $web_product_type_info['product_type_short_desc'];
    $long_description = $web_product_type_info['product_type_long_desc'];
    $logo = $web_product_type_info['product_type_icon'];
    $status = $web_product_type_info['active_flag'];
}
?>
<script src="functions/js/product_type.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Product Type</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Product Type</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white"
                            onclick="window.location.href='?page=manage_products_type'">
                        <i class="fas fa-binoculars"></i> View All Product Type
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product Type Panel</h4>
                        <h6 class="card-subtitle">Add here product types / category</h6>
                        <form id="productTypeForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" id="product_type_wrapper">
                                        <label>Product Type</label>
                                        <input type="text" class="form-control" id="product_type" name="product_type" placeholder="Enter product type" value="<?php echo $name; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="short_desc_wrapper">
                                        <label>Product Type Short Description</label>
                                        <textarea class="form-control" id="product_type_short_desc" name="product_type_short_desc" rows="3"><?php echo $short_description?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="full_desc_wrapper">
                                        <label>Product Type Full Description</label>
                                        <textarea class="form-control" id="product_type_full_desc" name="product_type_full_desc" rows="3"><?php echo $long_description?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="icon_wrapper">
                                        <label>Product Type Icon Upload</label>
                                        <input type="file" class="form-control" id="product_type_icon" name="product_type_icon" onchange="product_type_icon_upload()">
                                        <input type="hidden" id="hidden_icon" name="product_type_icon" value="<?php echo $logo; ?>">
                                        <div id="uploaded_icon" style="margin-top:10px;">
                                            <?php if ($logo != ""){ ?>
                                                <img src="../resources/product_type/icon/<?php echo $logo;?>" width="100px">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" id="status_wrapper">
                                        <label>Status</label>
                                        <select class="form-control" id="publish_status" name="active_flag">
                                            <option <?php if($status==1){ echo "selected='selected'";}?> value="1">Publish</option>
                                            <option value="2" <?php if($status==2){ echo "selected='selected'";} ?>>Unpublish</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <?php if ($id != ""){ ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="button" onclick="update_product_type(<?php echo $id;?>)" class="btn btn-primary mt-3">Update Product Type</button>
                            <?php } else { ?>
                                <button type="button" onclick="save_product_type()" class="btn btn-primary mt-3">Save Product Type</button>
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

        // 1️⃣ Auto focus first field
        document.getElementById("product_type")?.focus();

        const form = document.getElementById("productTypeForm");

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

            if (!active.closest("#productTypeForm")) return;

            // ✅ Allow Shift+Enter for textarea newline
            if (active.tagName === "TEXTAREA") {
                if (e.shiftKey) return;
                e.preventDefault();
            } else {
                e.preventDefault();
            }

            // Collect focusable elements, skip readonly/hidden/disabled
            const focusable = Array.from(
                document.querySelectorAll(
                    "#productTypeForm input:not([type=hidden]):not([readonly]):not([disabled]), " +
                    "#productTypeForm select:not([disabled]), " +
                    "#productTypeForm textarea:not([readonly]):not([disabled])"
                )
            ).filter(el => el.offsetParent !== null);

            const index = focusable.indexOf(active);

            // File input → open dialog and move next after choosing file
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
                submitProductTypeForm();
            }
        });
    });

    // 4️⃣ Auto Save / Update
    function submitProductTypeForm() {
        const productTypeId = document.querySelector('input[name="id"]');
        if (productTypeId) {
            update_product_type(productTypeId.value);
        } else {
            save_product_type();
        }
    }
</script>
