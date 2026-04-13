<?php
	include ("config/my_class_for_web.php");
	$obj = new my_class();
	extract($_REQUEST);

	$id = isset($id) ? $id : '';

	if ($id != ""){
		$user_info = $obj->Details_By_Cond("web_user", "id='$id'");
		$user_name        = $user_info['user_profile_name'];
		$user_username    = $user_info['user_name'];
		$user_email       = $user_info['user_email'];
		$user_phone       = $user_info['user_phone'];
		$user_nid         = $user_info['nid'];
		$user_address     = $user_info['user_address'];
		$user_role        = $user_info['user_role_ref'];
		$user_type        = $user_info['user_type_ref'];
		$user_status      = $user_info['active_flag'];
		$user_photo       = $user_info['user_profile_pic'];
		$user_password    = $user_info['user_password'];
	}
	?>

<script src="functions/js/user.js"></script>

<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add User</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
                <button type="button" class="btn btn-info text-white"
                        onclick="window.location.href='?page=manage_user'">
                    View All User
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">User Registration</h4>

                <form id="userForm" enctype="multipart/form-data">
                    <div class="row">

                        <!-- Full Name -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_full_name_wrapper">
                                <label>User Full Name</label>
                                <input type="text" class="form-control" id="user_full_name" name="user_profile_name" value="<?= $user_name ?? '' ?>" placeholder="Enter Full Name">
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_user_name_wrapper">
                                <label>User Username</label>
                                <input type="text" class="form-control" id="user_user_name" name="user_user_name" value="<?= $user_username ?? '' ?>" placeholder="Enter Username">
                            </div>
                        </div>

                        <!-- Type -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_type_wrapper">
                                <label>User Type</label>
                                <select class="form-control" id="user_type" name="user_type">
                                    <option value="">Select Type</option>
                                    <option value="1" <?= ($user_type==1)?'selected':'' ?>>User</option>
                                    <option value="2" disabled<?= ($user_type==1)?'selected':'' ?>>Supplier</option>
                                    <option value="3" disabled<?= ($user_type==1)?'selected':'' ?>>Customer</option>
                                </select>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_role_wrapper">
                                <label>User Role</label>
                                <select class="form-control" id="user_role" name="user_role">
                                    <option value="">Select Role</option>
                                    <option value="1"<?= ($user_role==1)?'selected':'' ?>>Super Admin</option>
                                    <option value="2"<?= ($user_role==2)?'selected':'' ?>>Branch Admin</option>
                                    <option value="3"<?= ($user_role==3)?'selected':'' ?>>Executive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_email_wrapper">
                                <label>User Email</label>
                                <input type="email" class="form-control" id="user_email" name="user_email" value="<?= $user_email ?? '' ?>" placeholder="Enter Email">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_phone_wrapper">
                                <label>User Phone</label>
                                <input type="text" class="form-control" id="user_phone" name="user_phone" value="<?= $user_phone ?? '' ?>" placeholder="Enter Phone">
                            </div>
                        </div>

                        <!-- NID -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_nid_wrapper">
                                <label>User NID</label>
                                <input type="text" class="form-control" id="user_nid" name="user_nid" value="<?= $user_nid ?? '' ?>" placeholder="Enter NID">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_address_wrapper">
                                <label>User Address</label>
                                <textarea class="form-control" id="user_address" name="user_address"><?= $user_address ?? '' ?></textarea>
                            </div>
                        </div>

                        <!-- Password -->
                        <?php if ($id != ""){ ?>
                            <div class="col-md-4">
                                <div class="form-group" id="user_password_wrapper">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="user_password" value="<?= $user_password ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group" id="confirm_user_password_wrapper">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_user_password" value="<?= $user_password ?>" readonly>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-4">
                                <div class="form-group" id="user_password_wrapper">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter Password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group" id="confirm_user_password_wrapper">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_user_password" name="confirm_user_password" placeholder="Enter Confirm Password">
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Profile Picture -->
                        <div class="col-md-4">
                            <div class="form-group" id="user_profile_pic_wrapper">
                                <label>User Profile Picture</label>
                                <input type="file" class="form-control"
                                       id="user_profile_pic"
                                       onchange="user_pic_upload()">

                                <input type="hidden"
                                       id="hidden_user_profile_pic"
                                       name="user_profile_pic"
                                       value="<?= $user_photo ?? '' ?>">

                                <div id="uploaded_user_profile_pic" style="margin-top:10px;">
                                    <?php if(!empty($user_photo)){ ?>
                                        <img src="../resources/user/profile_pic/<?= $user_photo ?>" width="100">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <div class="form-group" id="publish_user_status_wrapper">
                                <label>Status</label>
                                <select class="form-control"
                                        id="publish_user_status"
                                        name="user_active_flag">
                                    <option value="1" <?= ($user_status==1)?'selected':'' ?>>Publish</option>
                                    <option value="2" <?= ($user_status==2)?'selected':'' ?>>Unpublish</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <?php if ($id != ""){ ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button type="button"
                                class="btn btn-primary"
                                onclick="update_user(<?= $id ?>)">
                            Update User
                        </button>
                    <?php } else { ?>
                        <button type="button"
                                class="btn btn-primary mt-3"
                                onclick="save_user()">
                            Save User
                        </button>
                    <?php } ?>

                </form>
            </div>
        </div>

    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {

        // 1️⃣ Auto focus first field
        document.getElementById("user_full_name")?.focus();

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

            // ✅ Allow Shift+Enter for textarea newline, otherwise navigate
            if (active.tagName === "TEXTAREA") {
                if (e.shiftKey) return; // New line
                e.preventDefault();     // Move to next field
            } else {
                e.preventDefault();
            }

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

                // Move to next field after a short delay to allow file selection
                setTimeout(() => {
                    if (index > -1 && index < focusable.length - 1) {
                        focusable[index + 1].focus();
                    }
                }, 100);
                return;
            }

            // Move to next
            if (index > -1 && index < focusable.length - 1) {
                focusable[index + 1].focus();
            }
            // Last field → submit
            else {
                submitUserForm();
            }
        });
    });

    // 4️⃣ Auto Save / Update
    function submitUserForm() {
        const userId = document.querySelector('input[name="id"]');
        if (userId) {
            update_user(userId.value);
        } else {
            save_user();
        }
    }
</script>




