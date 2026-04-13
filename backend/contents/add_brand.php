<?php
    include ("config/my_class_for_web.php");
    $obj = new my_class();
    extract($_REQUEST);
    $id = isset($id) ? $id : '';
    if ($id != ""){
        $brand_info = $obj->Details_By_Cond("brand", "id='$id'");
        $name = $brand_info['brand_name'];
        $description = $brand_info['brand_description'];
        $logo = $brand_info['brand_logo'];
        $status = $brand_info['active_flag'];
    }
?>

<script src="functions/js/brand.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Brand</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Brand</li>
                    </ol>
                    <button type="button"
                            class="btn btn-info d-none d-lg-block m-l-15 text-white"
                            onclick="window.location.href='?page=manage_brand'">
                        <i class="fas fa-binoculars"></i> View All Brands
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Brand Panel</h4>

                        <form id="userForm" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Brand Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?= $name ?>">
                            </div>

                            <div class="form-group">
                                <label>Brand Description</label>
                                <textarea class="form-control" name="description" id="description" rows="4"><?php echo $description?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Brand Logo</label>
                                <input type="file" class="form-control" id="profile_pic" onchange="brand_logo_upload()">
                                <input type="hidden" name="logo" id="hidden_profile_pic" value="<?= $logo ?>">
                                <div id="uploaded_profile_pic" class="mt-2">
                                    <?php if ($logo != ""){ ?>
                                        <img src="../resources/brand/brand_logo/<?php echo $logo;?>" width="100px">
                                    <?php } ?>
                                </div>
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
                                <button type="button" class="btn btn-primary text-white" onclick="update(<?php echo $id;?>)">Update Brand</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary text-white" onclick="save()">Save Brand</button>
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
