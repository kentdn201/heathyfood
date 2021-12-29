<?php
include("../shared_assets/conn.php");

$sql = "SELECT * FROM tbl_payment
        ORDER BY paymentID DESC";
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
                    <th>Description</th>
                    <th>Functions</th>
                    <th></th>
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
                    <td>'.$rows['paymentID'].'</td>
                    <td>'.$rows['paymentName'].'</td>
                    <td>'.$rows['paymentDesc'].'</td>
                    <td><a href="update_payment.php?id='.$rows["paymentID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
                    <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$rows["paymentID"].'"><i class="fas fa-trash"></i></button></td>
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
                <td><strong>Functions</strong></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>