<?php
include("../shared_assets/conn.php");

$sql = "SELECT * FROM tbl_account_role 
        ORDER BY roleID DESC";
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
                    <td>'.$rows['roleID'].'</td>
                    <td>'.$rows['roleName'].'</td>
                    <td>'.$rows['roleDesc'].'</td>
                    <td><a href="update_role.php?id='.$rows["roleID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
                    <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$rows["roleID"].'"><i class="fas fa-trash"></i></button></td>
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
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>