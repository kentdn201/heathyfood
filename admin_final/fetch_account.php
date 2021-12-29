<?php
include("../shared_assets/conn.php");

if(isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM tbl_account, tbl_account_role 
        WHERE tbl_account_role.roleID = tbl_account.roleID
        AND accountFullname LIKE '%".$search."%'
        OR accountUsername LIKE '%".$search."%'
        OR accountEmail LIKE '%".$search."%'
        OR accountPhone LIKE '%".$search."%'
        ORDER BY accountID DESC";
} else {
    $sql = "SELECT * FROM tbl_account, tbl_account_role 
        WHERE tbl_account_role.roleID = tbl_account.roleID
        ORDER BY accountID DESC";
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
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Role</th>
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
                    <td>'.$rows['accountID'].'</td>
                    <td>'.$rows['accountFullname'].'</td>
                    <td>'.$rows['accountUsername'].'</td>
                    <td>'.$rows['roleName'].'</td>
                    <td><button type="button" class="btn btn-primary btn-xs info" id="'.$rows["accountID"].'"><i class="fas fa-info"></i></button></td>
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
                <td><strong>Fullname</strong></td>
                <td><strong>Username</strong></td>
                <td><strong>Role</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>