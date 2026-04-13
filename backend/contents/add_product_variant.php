<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
?>

<script src="functions/js/brand.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Product Variant</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Product Variant</li>
                    </ol>
                    <button type="button"
                            class="btn btn-info d-none d-lg-block m-l-15 text-white"
                            onclick="window.location.href='?page=manage_product_variant'">
                        <i class="fas fa-binoculars"></i> View All Product Variants
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Product Variant Panel</h4>

                        <form id="userForm" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Product Variant Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="">
                            </div>

                            <div class="form-group">
                                <label>Product Variant Description</label>
                                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Brand Logo</label>
                                <input type="file" class="form-control" id="profile_pic" onchange="brand_logo_upload()">
                                <input type="hidden" name="logo" id="hidden_profile_pic" value="">
                                <div id="uploaded_profile_pic" class="mt-2">

                                </div>
                            </div>

                            <div class="form-group">
                                <label>Publish Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="1">Publish</option>
                                    <option value="2">Unpublish</option>
                                </select>
                            </div>

                            <?php if ($id != ""){ ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="button" class="btn btn-primary text-white" onclick="update(<?php echo $id;?>)">Update Product Variant</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary text-white" onclick="save()">Save Product Variant</button>
                            <?php } ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
