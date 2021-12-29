<?php
include('include/conn.php');
session_start();

$id = $_SESSION['user'];
// $query = mysqli_query($conn, "SELECT * FROM tbl_account WHERE accountID = '$id'");

// if($query){  
//     $user = mysqli_fetch_assoc($query);
// }

// $item = [
//     'id'=> $user['accountID'],
//     'fullname'=> $user['accountFullname'],
//     'username'=> $user['accountUsername'],
//     'address'=> $user['accountAddress'],
// ];

header("location:cusprofile.php");
?>