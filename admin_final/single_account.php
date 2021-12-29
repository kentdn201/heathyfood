<?php
include('../shared_assets/conn.php');

$id = $_POST['accountID'];

$sql = "SELECT * FROM tbl_account, tbl_account_role WHERE accountID = '$id' AND tbl_account_role.roleID = tbl_account.roleID";
$query = mysqli_query($conn, $sql);

foreach($query as $rows) {
    $output['fullname'] = $rows['accountFullname'];
    $output['username'] = $rows['accountUsername'];
    $output['password'] = $rows['accountPassword'];
    $output['email'] = $rows['accountEmail'];
    $output['phone'] = $rows['accountPhone'];
    $output['role'] = $rows['roleName'];
}

echo json_encode($output);

?>