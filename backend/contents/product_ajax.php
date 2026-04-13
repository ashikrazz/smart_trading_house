<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/my_class_for_web.php");
$obj = new my_class();

if (!isset($_POST['action'])) exit;

if ($_POST['action'] === "load_subcategory") {

    $cat_id = intval($_POST['category_id']);

    $rows = $obj->View_All_By_Cond(
        "web_product_subtype",
        "product_type_ref='$cat_id' AND active_flag=1"
    );

    echo '<option value="">Select Sub-Category</option>';

    if (!empty($rows)) {
        foreach ($rows as $row) {
            echo '<option value="'.$row['id'].'">'.$row['id']." |   ".$row['name'].'</option>';
        }
    } else {
        echo '<option value="">No Sub-Category Found</option>';
    }
}
else if ($_POST['action'] === "load_product") {

    $subcat_id = intval($_POST['subcat_id']);

    echo '<option value="">Select Product</option>';

    $rows = $obj->View_All_By_Cond(
        "products",
        "sub_type_ref='$subcat_id' AND active_flag=1"
    );

    if (!empty($rows)) {
        foreach ($rows as $row) {
            echo '<option value="'.$row['id'].'">'.$row['id']." |   ".$row['product_name'].'</option>';
        }
    } else {
        echo '<option value="">No Product Found</option>';
    }
}
else if ($_POST['action'] === "load_variant") {

    $product_id = intval($_POST['product_id']);

    echo '<option value="">Select Variant</option>';

    $rows = $obj->View_All_By_Cond(
        "variant",
        "product_ref='$product_id' AND active_flag=1"
    );

    if (!empty($rows)) {
        foreach ($rows as $row) {
            echo '<option value="'.$row['id'].'">'.$row['variant_name'].'</option>';
        }
    } else {
        echo '<option value="">No Variant Found</option>';
    }
}
else if ($_POST['action'] === "load_price") {

    $variant_id = intval($_POST['variant_id']);

    $row = $obj->Details_By_Cond(
        "product_price",
        "variant_ref='$variant_id' AND active_flag=1"
    );

    if (!empty($row)) {
        echo $row['sell_price'];
    } else {
        echo "0.00";
    }
}
else if ($_POST['action'] === "load_vat") {

    $variant_id = intval($_POST['variant_id']);

    $row = $obj->Details_By_Cond(
        "product_price",
        "variant_ref='$variant_id' AND active_flag=1"
    );

    if (!empty($row)) {
        echo $row['vat'];
    } else {
        echo "";
    }
}
else if ($_POST['action'] === "load_stock") {

    $variant_id = intval($_POST['variant_id']);

    $row = $obj->Details_By_Cond(
        "product_stocks",
        "variant_ref='$variant_id' AND active_flag=1"
    );

    if (!empty($row)) {
        echo $row['stock_in'];
    } else {
        echo "";
    }
}


/* ================= LOAD PRODUCT VARIANTS (TABLE) ================= */
else if ($_POST['action'] == 'load_product_variants') {

    $product_id = (int)$_POST['product_id'];

    $sql = "
        SELECT 
            pv.id AS variant_id,
            p.product_name,
            c.product_type_title AS category,
            sc.name AS sub_category,
            b.brand_name,
            vt.variant AS variant_type,
            pv.variant_name,
            pp.buy_price,
            pp.sell_price,
            pp.vat,
            ps.stock_in AS stock_qty
        FROM variant pv
        JOIN products p ON p.id = pv.product_ref
        JOIN web_product_type c ON c.id = p.type_ref
        JOIN web_product_subtype sc ON sc.id = p.sub_type_ref
        JOIN brand b ON b.id = p.brand_ref
        JOIN variant_type vt ON vt.id = pv.variant_type_ref
        JOIN product_price pp ON pp.variant_ref = pv.id
        JOIN product_stocks ps ON ps.variant_ref = pv.id
        WHERE pv.product_ref = :product_id
        AND pv.active_flag = 1
        ORDER BY pv.id DESC
    ";

    try {
        $stmt = $obj->con1->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($variants)) {
            echo '<tr><td colspan="10" class="text-center">No variants found</td></tr>';
            exit;
        }

        foreach ($variants as $row) {
            echo "
            <tr>
                <td>{$row['category']}</td>
                <td>{$row['sub_category']}</td>
                <td>{$row['brand_name']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['variant_name']}</td>
                <td>{$row['buy_price']}৳</td>
                <td>{$row['sell_price']}৳</td>
                <td>{$row['vat']}%</td>
                <td>{$row['stock_qty']}</td>
                <td>
                    <button 
                        type='button' 
                        class='btn btn-sm btn-success'
                        onclick='editVariant({$row['variant_id']})'>
                        <i class='fas fa-edit'></i>
                    </button>
                </td>
            </tr>";
        }

    } catch (PDOException $e) {
        echo '<tr><td colspan="10" class="text-center">Error: '.$e->getMessage().'</td></tr>';
        exit;
    }

}

else if ($_POST['action'] === 'get_variant_details') {

    $variant_id = (int)$_POST['variant_id'];

    $sql = "
        SELECT 
            pv.id,
            pv.variant_type_ref,
            pv.variant_name,
            pp.buy_price,
            pp.sell_price,
            pp.vat,
            ps.stock_in,
            ps.min_stock
        FROM variant pv
        JOIN product_price pp ON pp.variant_ref = pv.id
        JOIN product_stocks ps ON ps.variant_ref = pv.id
        WHERE pv.id = :variant_id
        AND pv.active_flag = 1
        LIMIT 1
    ";

    $stmt = $obj->con1->prepare($sql);
    $stmt->execute([':variant_id' => $variant_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($row);
}



