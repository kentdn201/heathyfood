<?php 
include('../shared_assets/conn.php');

$id = $_POST['roleID'];

$fetch = mysqli_query($conn, "SELECT * FROM tbl_account_role WHERE roleID = '$id'");
if($fetch) {
    $count = mysqli_num_rows(mysqli_query($conn, "SELECT logID FROM tbl_activity_log"));
    $not_inserted = true;
    for($i = 0; $i <= $count; $i++) {
        $temp = "log_".$i;
        $res = mysqli_query($conn, "SELECT logID FROM tbl_activity_log WHERE logID ='$temp'");
        if(!$res && $not_inserted) {
            $not_inserted = false;
        }
    }
    $logID = $temp;

    $content = mysqli_fetch_assoc($fetch);
    $logContent = "Delete Account Role ".$id." with the following identifications:
        Role Name: ".$content['roleName'].",
        Role Description: ".$content['roleDesc']."";

    $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                    VALUES ('$logID', 'Delete Account Role', '$logContent', '".$user['accountID']."')");
    if($log_sql) {
        $sql = "DELETE FROM tbl_account_role WHERE roleID = '$id'";
        mysqli_query($conn, $sql);
    }
}
?>