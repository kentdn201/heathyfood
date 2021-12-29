<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "crp_final";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if(!$conn){
        die("Connect failed: " .mysqli_connect_error());
    }

?>