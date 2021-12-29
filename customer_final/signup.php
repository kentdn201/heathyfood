<?php
include("../shared_assets/conn.php");
session_start();
if(isset($_POST['signUp'])) {
    $regexName = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
    $regexUser = "/^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
    $regexPhone = "/^[0-9\-\+]{9,15}$/";
    $regexEmail = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
    $regexPass = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    if(preg_match($regexName,$_POST['name'])){
        if(preg_match($regexUser,$_POST['user'])){
            if(preg_match($regexEmail,$_POST['email'])){
                if(preg_match($regexPhone,$_POST['phone'])){
                    if(preg_match($regexPass,$_POST['password'])){
                        $id = 'user'.rand(100, 900000);
                        $fullname = $_POST['name'];
                        $username = $_POST['user'];
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                
                        $sql = "SELECT * FROM tbl_account WHERE accountUsername = '{$username}'";
                        $queryCheck = mysqli_query($conn, $sql);
                
                        if(mysqli_num_rows($queryCheck) > 0){
                            echo "<script>alert('Account has been created')</script>";
                            echo "<script>window.open('index.php','_self')</script>";
                        } else{
                            $query = "INSERT INTO tbl_account (accountID, accountFullname, accountUsername, accountPassword, accountEmail, accountPhone, roleID)
                            VALUES ('$id', '$fullname', '$username', '$password', '$email', '$phone', 'role_2')";
                            $res = mysqli_query($conn, $query);
                            if($res) {
                                $username = $_POST['user'];
                                $password = $_POST['password'];
                                $sql = "SELECT * FROM tbl_account WHERE accountUsername = '$username' AND roleID = 'role_2'";
                                $query = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($query)>0) {
                                    while($row=mysqli_fetch_assoc($query)) {
                                        if(password_verify($password, $row['accountPassword'])) {
                                            $_SESSION['user'] = $row;
                                            $user = (isset($_SESSION['user']))? $_SESSION['user'] : [];

                                            $id = 'wallet'.rand(0, 100000);
                                            $walletBalance = 0;
                                            $accountID = $user['accountID'];
                        
                                            $sql = "INSERT INTO tbl_account_wallet (walletID, walletBalance, accountID) VALUES ('$id', '$walletBalance', '$accountID')";
                                            $query = mysqli_query($conn, $sql);
                                            if($query){
                                                $voucherID = "voucher_".rand(0, 100000);
                                                $typeID = 'type_0';
                                                $accountID = $user['accountID'];
                                                $sql = "INSERT INTO tbl_account_voucher (voucherID, typeID, accountID) VALUES('$voucherID', '$typeID', '$accountID')";
                                                $query = mysqli_query($conn, $sql);
                                                echo "<script>alert('Sign up successful')</script>";
                                                echo "<script>window.open('cusprofile.php','_self')</script>";
                                            }
                                        }
                                    }
                                }
                            }
                            else {
                                echo "<script>alert('Sign up failed')</script>";
                                echo "<script>window.open('index.php','_self')</script>";
                            }
                        }
                    } else {
                        echo "<script>alert('You have entered the wrong password format, you must enter at least 8 characters and must have 1 letter and 1 number')</script>";
                        echo "<script>window.open('index.php','_self')</script>";
                    }
                } else {
                    echo "<script>alert('Phone number must be 10 characters: Eg: 0987654321,...')</script>";
                    echo "<script>window.open('index.php','_self')</script>";
                }
            } else {
                echo "<script>alert('The email to enter has the format like this: Eg: abc@gmail.com,...')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            }
        } else {
            echo "<script>alert(You entered the wrong format user: Eg: abc1234,...)</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }
    } else {
        echo "<script>alert('The input name must have the format like this: Eg: John, Nguyen A,....')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}
?>