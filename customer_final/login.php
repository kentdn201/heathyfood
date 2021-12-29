<?php
include("../shared_assets/conn.php");
session_start();
$name = $_POST['name'];
$password = $_POST['password'];
if(isset($_POST['Login'])) {
    $query = "SELECT * FROM tbl_account 
              WHERE accountUsername = '$name' AND roleID = 'role_2'";
    $res = mysqli_query($conn, $query);
    if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            if(password_verify($password, $row['accountPassword'])) {
                $_SESSION['user'] = $row;
                echo "<script>alert('Login successful')</script>";
                echo "<script>window.open('cusprofile.php','_self')</script>";
            }
            else {
                echo "<script>alert('Wrong password')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            }
        }
    }
    else {
        echo "<script>alert('Login failed')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}
?>