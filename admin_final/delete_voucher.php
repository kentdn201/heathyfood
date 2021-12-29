<?php 
include('../shared_assets/conn.php');

$id = $_POST['voucherID'];

$fetch = mysqli_query($conn, "SELECT * FROM tbl_voucher_type WHERE typeID = '$id'");
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
    $logContent = "Delete Voucher Type ".$id." with the following identifications:
        Voucher Type Name: ".$content['typeName'].",
        Voucher Type Description: ".$content['typeDesc'].",
        Voucher Type Value: ".$content['voucherValue'].",
        Voucher Type Cost: ".$content['voucherCost']."";

    $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                    VALUES ('$logID', 'Delete Voucher Type', '$logContent', '".$user['accountID']."')");
    if($log_sql) {
        $sql = "DELETE FROM tbl_voucher_type WHERE typeID = '$id'";
    mysqli_query($conn, $sql);
    }
}

?>