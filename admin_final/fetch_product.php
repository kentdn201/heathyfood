<?php
include("../shared_assets/conn.php");

$sql = "SELECT * FROM tbl_product, tbl_product_category
        WHERE tbl_product_category.categoryID = tbl_product.categoryID
        ORDER BY productID DESC";
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
                    <th>Price</th>
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
                    <td>'.$rows['productPrice'].'</td>
                    <td><a href="update_product.php?id='.$rows["productID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
                    <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$rows["productID"].'"><i class="fas fa-trash"></i></button></td>
                </tr>
        ';
    }
}
else {
    $output .= '
        </tbody>
        <tbody>
            <tr>
                <td colspan="6" align="center">No Data Found</td>
            </tr>
        </tbody>
    ';
}

$output .= '
            <tfoot>
            <tr>    
                <td><strong>ID</strong></td>
                <td><strong>Name</strong></td>
                <td><strong>Category</strong></td>
                <td><strong>Price</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>