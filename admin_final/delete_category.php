<?php 
include('../shared_assets/conn.php');

$id = $_POST['categoryID'];

$fetch = mysqli_query($conn, "SELECT * FROM tbl_product_category WHERE categoryID = '$id'");
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
    $logContent = "Delete Product Category ".$id." with the following identifications:
        Category Name: ".$content['categoryName'].",
        Category Description: ".$content['categoryDesc']."";

    $log_sql = mysqli_query($conn, "INSERT INTO tbl_activity_log (logID, logName, logContent, accountID)
                                    VALUES ('$logID', 'Delete Product Category', '$logContent', '".$user['accountID']."')");
    if($log_sql) {
        $sql = "DELETE FROM tbl_product_category WHERE categoryID = '$id'";
        mysqli_query($conn, $sql);
    }
}

?>