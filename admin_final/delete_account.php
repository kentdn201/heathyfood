<?php 
include('../shared_assets/conn.php');

$id = $_POST['accountID'];

$sql = "DELETE FROM tbl_account WHERE accountID = '$id'";
mysqli_query($conn, $sql);

?>