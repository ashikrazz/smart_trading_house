<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
$id = isset($id) ? $id : '';
if ($id != ""){
    $customer_info = $obj->Details_By_Cond("web_user", "id='$id'");
    $customer_name = $customer_info['user_profile_name'];
    $customer_username = $customer_info['user_name'];
    $customer_email = $customer_info['user_email'];
    $customer_phone = $customer_info['user_phone'];
    $customer_nid = $customer_info['nid'];
    $customer_address = $customer_info['user_address'];
    $customer_role = $customer_info['user_role_ref'];
    $customer_status = $customer_info['active_flag'];
    $customer_photo = $customer_info['user_profile_pic'];
    $customer_password = $customer_info['user_password'];
    $customer_type = $customer_info['user_type_ref'];

}
?>
<script src="functions/js/customer.js"></script>
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
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=manage_customer'"><i class="fas fa-binoculars"></i> View All Customer</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Registration</h4>
                        <form id="customerForm" enctype="multipart/form-data">
                            <div class="row">

                                <!-- Full Name -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_full_name_wrapper">
                                        <label>Customer Full Name</label>
                                        <input type="text" class="form-control" id="customer_full_name" name="customer_profile_name" placeholder="Full Name" value="<?php echo $customer_name; ?>">
                                    </div>
                                </div>

                                <!-- Username -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_user_name_wrapper">
                                        <label>Customer Username</label>
                                        <input type="text" class="form-control" id="customer_user_name" name="customer_user_name" placeholder="Username" value="<?php echo $customer_username; ?>">
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-md-4">
                                    <div class="form-group" id="user_type_wrapper">
                                        <label>User Type</label>
                                        <select class="form-control" id="user_type" name="user_type">
                                            <option value="" disabled>Select Type</option>
                                            <option value="1" disabled>User</option>
                                            <option value="2" disabled>Supplier</option>
                                            <option <?php if($customer_type==3){ echo "selected='selected'";}?> value="3">Customer</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_email_wrapper">
                                        <label>Customer Email</label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email" placeholder="Email" value="<?php echo $customer_email; ?>">
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_phone_wrapper">
                                        <label>Customer Phone</label>
                                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Phone" value="<?php echo $customer_phone; ?>">
                                    </div>
                                </div>

                                <!-- NID -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_nid_wrapper">
                                        <label>Customer NID</label>
                                        <input type="text" class="form-control" id="customer_nid" name="customer_nid" placeholder="NID" value="<?php echo $customer_nid; ?>">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_address_wrapper">
                                        <label>Customer Address</label>
                                        <textarea class="form-control" id="customer_address" name="customer_address" placeholder="Address"><?php echo $customer_address?></textarea>
                                    </div>
                                </div>

                                <!-- Password -->
                                <?php if ($id != ""){ ?>
                                    <div class="col-md-4">
                                        <div class="form-group" id="customer_password_wrapper">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="customer_password" name="customer_password" placeholder="Password" value="<?php echo $customer_password; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="col-md-4">
                                        <div class="form-group" id="confirm_customer_password_wrapper">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_customer_password" name="confirm_customer_password" placeholder="Confirm Password" value="<?php echo $customer_password; ?>" readonly>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-4">
                                        <div class="form-group" id="customer_password_wrapper">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="customer_password" name="customer_password" placeholder="Password" >
                                        </div>
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="col-md-4">
                                        <div class="form-group" id="confirm_customer_password_wrapper">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_customer_password" name="confirm_customer_password" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Profile Picture -->
                                <div class="col-md-4">
                                    <div class="form-group" id="customer_profile_pic_wrapper">
                                        <label>Customer Profile Picture</label>
                                        <input type="file" class="form-control" id="customer_profile_pic" onchange="customer_pic_upload()">
                                        <input type="hidden" id="hidden_profile_pic" name="customer_profile_pic" value="<?php echo $customer_photo;?>">
                                        <div id="uploaded_customer_profile_pic" style="margin-top:10px;">
                                            <?php if ($customer_photo != ""){ ?>
                                                <img src="../resources/customer/profile_pic/<?php echo $customer_photo;?>" width="100px">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Publish Status -->
                                <div class="col-md-4">
                                    <div class="form-group" id="publish_customer_status_wrapper">
                                        <label>Status</label>
                                        <select class="form-control" id="publish_customer_status" name="customer_active_flag">
                                            <option <?php if($customer_status==1){ echo "selected='selected'";}?> value="1">Publish</option>
                                            <option value="2" <?php if($customer_status==2){ echo "selected='selected'";} ?>>Unpublish</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <?php if ($id != ""){ ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="button" class="btn btn-primary text-white" onclick="update_customer(<?php echo $id;?>)">Update Customer</button>
                            <?php } else { ?>
                                <button type="button" onclick="save_customer()" class="btn btn-primary mt-3">Save Customer</button>
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
        document.getElementById("customer_full_name")?.focus();

        const form = document.getElementById("customerForm");

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

            if (!active.closest("#customerForm")) return;

            // ✅ Allow Shift+Enter for textarea newline
            if (active.tagName === "TEXTAREA") {
                if (e.shiftKey) return;
                e.preventDefault();
            } else {
                e.preventDefault();
            }

            const focusable = Array.from(
                document.querySelectorAll(
                    "#customerForm input:not([type=hidden]):not([readonly]):not([disabled]), " +
                    "#customerForm select:not([disabled]), " +
                    "#customerForm textarea:not([readonly]):not([disabled])"
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
                submitCustomerForm();
            }
        });
    });

    // 4️⃣ Auto Save / Update
    function submitCustomerForm() {
        const customerId = document.querySelector('input[name="id"]');
        if (customerId) {
            update_customer(customerId.value);
        } else {
            save_customer();
        }
    }
</script>
