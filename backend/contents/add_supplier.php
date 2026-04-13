<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
$id = isset($id) ? $id : '';
if ($id != ""){
    $supplier_info = $obj->Details_By_Cond("web_user", "id='$id'");
    $name = $supplier_info['user_profile_name'];
    $username = $supplier_info['user_name'];
    $email = $supplier_info['user_email'];
    $phone = $supplier_info['user_phone'];
    $nid = $supplier_info['nid'];
    $address = $supplier_info['user_address'];
    $role = $supplier_info['user_type_ref'];
    $status = $supplier_info['active_flag'];
    $photo = $supplier_info['user_profile_pic'];
    $password = $supplier_info['user_password'];

}
?>
<script src="functions/js/supplier.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Supplier</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Supplier</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=manage_supplier'"><i class="fas fa-binoculars"></i> View All Suppliers</button>
                    <button type="button" class="btn btn-success d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_purchase'"><i
                                class="fa fa-plus-circle"></i> Purchase Panel
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Supplier Registration</h4>
                        <form id="supplierForm" enctype="multipart/form-data">
                            <div class="row">

                                <!-- Full Name -->
                                <div class="col-md-4">
                                    <div class="form-group" id="full_name_wrapper">
                                        <label>Supplier Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="user_profile_name" placeholder="Full Name" value="<?php echo $name; ?>">
                                    </div>
                                </div>

                                <!-- Username -->
                                <div class="col-md-4">
                                    <div class="form-group" id="user_name_wrapper">
                                        <label>Supplier Username</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" value="<?php echo $username; ?>">
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-md-4">
                                    <div class="form-group" id="user_role_wrapper">
                                        <label>Role</label>
                                        <select class="form-control" id="user_role" name="user_role">
                                            <option value="" disabled>Select Role</option>
                                            <option value="1" disabled>User</option>
                                            <option <?php if($role==2){ echo "selected='selected'";}?> value="2">Supplier</option>
                                            <option value="3" disabled>Customer</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="form-group" id="email_wrapper">
                                        <label>Supplier Email</label>
                                        <input type="email" class="form-control" id="email" name="user_email" placeholder="Email" value="<?php echo $email; ?>">
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-4">
                                    <div class="form-group" id="phone_wrapper">
                                        <label>Supplier Phone</label>
                                        <input type="text" class="form-control" id="phone" name="user_phone" placeholder="Phone" value="<?php echo $phone; ?>">
                                    </div>
                                </div>

                                <!-- NID -->
                                <div class="col-md-4">
                                    <div class="form-group" id="nid_wrapper">
                                        <label>Supplier NID</label>
                                        <input type="text" class="form-control" id="nid" name="nid" placeholder="NID" value="<?php echo $nid; ?>">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-4">
                                    <div class="form-group" id="address_wrapper">
                                        <label>Supplier Address</label>
                                        <textarea class="form-control" id="address" name="user_address" placeholder="Address"><?php echo $address?></textarea>
                                    </div>
                                </div>

                                <!-- Password -->
                                <?php if ($id != ""){ ?>
                                    <div class="col-md-4">
                                        <div class="form-group" id="password_wrapper">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="password" name="user_password" placeholder="Password" value="<?php echo $password; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="col-md-4">
                                        <div class="form-group" id="confirm_password_wrapper">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="<?php echo $password; ?>" readonly>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-4">
                                        <div class="form-group" id="password_wrapper">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="password" name="user_password" placeholder="Password" >
                                        </div>
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="col-md-4">
                                        <div class="form-group" id="confirm_password_wrapper">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Profile Picture -->
                                <div class="col-md-4">
                                    <div class="form-group" id="profile_pic_wrapper">
                                        <label>Supplier Profile Picture</label>
                                        <input type="file" class="form-control" id="supplier_profile_pic" onchange="supplier_pic_upload()">
                                        <input type="hidden" id="hidden_profile_pic" name="supplier_profile_pic" value="<?php echo $photo;?>">
                                        <div id="uploaded_profile_pic" style="margin-top:10px;">
                                            <?php if ($photo != ""){ ?>
                                                <img src="../resources/supplier/profile_pic/<?php echo $photo;?>" width="100px">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Publish Status -->
                                <div class="col-md-4">
                                    <div class="form-group" id="publish_status_wrapper">
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
                                <button type="button" class="btn btn-primary text-white" onclick="update(<?php echo $id;?>)">Update Supplier</button>
                            <?php } else { ?>
                                <button type="button" onclick="save_supplier()" class="btn btn-primary mt-3">Save Supplier</button>
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
        document.getElementById("full_name")?.focus();

        const form = document.getElementById("supplierForm");

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

            if (!active.closest("#supplierForm")) return;

            // ✅ Allow Shift+Enter for textarea newline
            if (active.tagName === "TEXTAREA") {
                if (e.shiftKey) return;
                e.preventDefault();
            } else {
                e.preventDefault();
            }

            // Collect focusable elements, skip readonly
            const focusable = Array.from(
                document.querySelectorAll(
                    "#supplierForm input:not([type=hidden]):not([readonly]):not([disabled]), " +
                    "#supplierForm select:not([disabled]), " +
                    "#supplierForm textarea:not([readonly]):not([disabled])"
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
                submitSupplierForm();
            }
        });
    });

    // 4️⃣ Auto Save / Update
    function submitSupplierForm() {
        const supplierId = document.querySelector('input[name="id"]');
        if (supplierId) {
            update(supplierId.value);
        } else {
            save_supplier();
        }
    }
</script>
