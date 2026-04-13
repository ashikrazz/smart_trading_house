<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
$id = isset($id) ? $id : '';
if ($id != ""){
    $variant_type_info = $obj->Details_By_Cond("variant_type", "id='$id'");
    $variant = $variant_type_info['variant'];
    $description = $variant_type_info['description'];
    $status = $variant_type_info['active_flag'];
}
?>

<script src="functions/js/variant_type.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Variant Type</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Variant Type</li>
                    </ol>
                    <button type="button"
                            class="btn btn-info d-none d-lg-block m-l-15 text-white"
                            onclick="window.location.href='?page=manage_variant_type'">
                        <i class="fas fa-binoculars"></i> View All Variant Types
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Variant Type Panel</h4>

                        <form id="variantTypeForm" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Variant Type Name *</label>
                                <input type="text" class="form-control" name="variant_type_name" id="variant_type_name" value="<?php echo $variant; ?>">
                            </div>

                            <div class="form-group">
                                <label>Variant Type Description</label>
                                <textarea class="form-control" name="description" id="description" rows="4"><?php echo $description?></textarea>
                            </div>


                            <div class="form-group">
                                <label>Publish Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option <?php if($status==1){ echo "selected='selected'";}?> value="1">Publish</option>
                                    <option value="2" <?php if($status==2){ echo "selected='selected'";} ?>>Unpublish</option>
                                </select>
                            </div>

                            <?php if ($id != ""){ ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="button" class="btn btn-primary text-white" onclick="update_variant_type(<?php echo $id;?>)">Update Variant Type</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary text-white" onclick="save_variant_type()">Save Variant Type</button>
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
        document.getElementById("name")?.focus();

        const form = document.getElementById("userForm");

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

            if (!active.closest("#userForm")) return;

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
                    "#userForm input:not([type=hidden]):not([readonly]):not([disabled]), " +
                    "#userForm select:not([disabled]), " +
                    "#userForm textarea:not([readonly]):not([disabled])"
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
                submitBrandForm();
            }
        });
    });

    // 4️⃣ Auto Save / Update
    function submitBrandForm() {
        const brandId = document.querySelector('input[name="id"]');
        if (brandId) {
            update(brandId.value);
        } else {
            save();
        }
    }
</script>
