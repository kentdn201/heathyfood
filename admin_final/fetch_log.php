<?php
include("../shared_assets/conn.php");

if(isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM tbl_activity_log
            WHERE logName LIKE '%".$search."%'
            OR logContent LIKE '%".$search."%'
            OR accountID LIKE '%".$search."%'
            ORDER BY logTime DESC";
} else {
    $sql = "SELECT * FROM tbl_activity_log
            ORDER BY logTime DESC";
}
$query = mysqli_query($conn, $sql);

mysqli_fetch_all($query, MYSQLI_ASSOC);
$num_rows = mysqli_num_rows($query);

$output = '
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Log Time</th>
                    <th>Log Name</th>
                    <th>Account Created</th>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
';

if($num_rows) {
    $count = 0;
    foreach($query as $rows) {
        $count++;
        $output .= '
                <tr>
                    <td>'.$rows['logID'].'</td>
                    <td>'.$rows['logTime'].'</td>
                    <td>'.$rows['logName'].'</td>
                    <td>'.$rows['accountID'].'</td>
                    <td><button type="button" class="btn btn-primary btn-xs info" id="'.$rows['logID'].'"><i class="fas fa-info"></i></button></td>
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
                <td><strong>Log ID</strong></td>    
                <td><strong>Log Time</strong></td>
                <td><strong>Log Name</strong></td>
                <td><strong>Account Created</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>