<?php
include("../shared_assets/conn.php");

if(isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM tbl_order
            WHERE currentStatus LIKE '%".$search."%'
            OR customerName LIKE '%".$search."%'
            ORDER BY createdTime DESC";
}
else {
    $sql = "SELECT * FROM tbl_order
            ORDER BY createdTime DESC";
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
                    <th>Created Time</th>
                    <th>Current Status</th>
                    <th>Customer Name</th>
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
                    <td>'.$rows['orderID'].'</td>
                    <td>'.$rows['createdTime'].'</td>
                    <td>'.$rows['currentStatus'].'</td>
                    <td>'.$rows['customerName'].'</td>
                    <td><a href="update_order.php?id='.$rows["orderID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
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
                <td><strong>Created Time</strong></td>
                <td><strong>Current Status</strong></td>
                <td><strong>Customer Name</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>