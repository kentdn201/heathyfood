<?php
include("../shared_assets/conn.php");

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_order_detail, tbl_product, tbl_order
        WHERE tbl_order_detail.orderID = '$id' AND tbl_product.productID = tbl_order_detail.productID AND tbl_order.orderID = tbl_order_detail.orderID
        ORDER BY createdTime DESC";
$query = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($query);

$output = '
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Current Price</th>
                    <th>Ordered Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
';

if($num_rows > 0) {
    $count = 0;
    $sum = mysqli_query($conn, "SELECT sum(totalPrice) as sum FROM tbl_order WHERE orderID = '$id'");
    $res = mysqli_fetch_array($sum);
    foreach($query as $rows) {
        $count++;
        $output .= '
                <tr>
                    <td><a href="update_product.php?id='.$rows['productID'].'">'.$rows['productID'].'</a></td>
                    <td>'.$rows['productName'].'</td>
                    <td>'.$rows['currentPrice'].'</td>
                    <td>'.$rows['orderedQuantity'].'</td>
                    <td>'.$rows['currentPrice']*$rows['orderedQuantity'].'</td>
                </tr>
        ';
    }
    $output .= '
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>'.$res["sum"].'</td>
                </tr>
    ';
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
                <td><strong>Current Price</strong></td>
                <td><strong>Ordered Quantity</strong></td>
                <td><strong>Total Price</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>