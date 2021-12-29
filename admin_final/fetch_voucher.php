<?php
include("../shared_assets/conn.php");

$sql = "SELECT * FROM tbl_voucher_type 
        ORDER BY typeID DESC";
$query = mysqli_query($conn, $sql);

mysqli_fetch_all($query, MYSQLI_ASSOC);
$num_rows = mysqli_num_rows($query);

$output = '
    <div class="table-responsive table mt-2" id="dataTable" type="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Cost</th>
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
                    <td>'.$rows['typeID'].'</td>
                    <td>'.$rows['typeName'].'</td>
                    <td>'.$rows['typeDesc'].'</td>
                    <td>'.$rows['voucherCost'].'</td>
                    <td><a href="update_voucher.php?id='.$rows["typeID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
                    <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$rows["typeID"].'"><i class="fas fa-trash"></i></button></td>
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
                <td><strong>Description</strong></td>
                <td><strong>Cost</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>