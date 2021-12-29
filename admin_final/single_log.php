<?php
include('../shared_assets/conn.php');

$id = $_POST['logID'];

$sql = "SELECT * FROM tbl_activity_log, tbl_account WHERE logID = '$id' AND tbl_account.accountID = tbl_activity_log.accountID";
$query = mysqli_query($conn, $sql);

foreach($query as $rows) {
    $output['logTime'] = $rows['logTime'];
    $output['logName'] = $rows['logName'];
    $output['logContent'] = $rows['logContent'];
    $output['accountCreated'] = $rows['accountUsername'];
}

echo json_encode($output);

?>