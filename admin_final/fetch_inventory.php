<?php
include("../shared_assets/conn.php");

if(isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM tbl_product, tbl_product_category
            WHERE tbl_product_category.categoryID = tbl_product.categoryID
            AND productName LIKE '%".$search."%'
            OR categoryName LIKE '%".$search."%'
            OR productStatus LIKE '%".$search."%'
            ORDER BY productID DESC";
}
else {
    $sql = "SELECT * FROM tbl_product, tbl_product_category
            WHERE tbl_product_category.categoryID = tbl_product.categoryID
            ORDER BY productID DESC";
}
$query = mysqli_query($conn, $sql);

mysqli_fetch_all($query, MYSQLI_ASSOC);
$num_rows = mysqli_num_rows($query);

$output = '
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
';

if($num_rows > 0) {
    $count = 0;
    foreach($query as $rows) {
        $count++;
        $output .= '
                <tr>
                    <td>'.$rows['productID'].'</td>
                    <td>'.$rows['productName'].'</td>
                    <td>'.$rows['categoryName'].'</td>
                    <td>'.$rows['productStatus'].'</td>
                    <td>'.$rows['inventoryQuantity'].'</td>
                    <td><a href="update_inventory.php?id='.$rows["productID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
                </tr>
        ';
    }
}
else {
    $output .= '
            <tr>
                <td colspan="6" align="center">No Data Found</td>
            </tr>
    ';
}

$output .= '
            </tbody>
            <tfoot>
            <tr>    
                <td><strong>ID</strong></td>
                <td><strong>Name</strong></td>
                <td><strong>Category</strong></td>
                <td><strong>Status</strong></td>
                <td><strong>Quantity</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>