<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
$id = isset($id) ? $id : '';
if ($id != ""){
    $unit_info = $obj->Details_By_Cond("measurement_unit", "id='$id'");
    $name = $unit_info['unit_name'];
    $description = $unit_info['unit_description'];
    $status = $unit_info['active_flag'];
}
?>

<script src="functions/js/measurement_unit.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Measurement Unit</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Add Measurement Unit</li>
                    </ol>
                    <button type="button"
                            class="btn btn-info d-none d-lg-block m-l-15 text-white"
                            onclick="window.location.href='?page=manage_measurement_unit'">
                        <i class="fas fa-binoculars"></i> View All Measurement Units
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Measurement Units Panel</h4>

                        <form id="unitForm" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Measurement Units Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>">
                            </div>

                            <div class="form-group">
                                <label>Measurement Units Description</label>
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
                                <button type="button" class="btn btn-primary text-white" onclick="update_unit(<?php echo $id;?>)">Update Measurement Units</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary text-white" onclick="save_unit()">Save Measurement Units</button>
                            <?php } ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
