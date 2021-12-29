<?php
    $servername = "ec2-3-217-170-198.compute-1.amazonaws.com";
    $username = "epfhbsltcnedlv";
    $password = "3a4dd46548f9a48d9a19bdc2675ac1f01888b0f6a559498566ed31ad7f3330e5";
    $database = "d1a3vgbq801lf1";

    $conn = pg_connect($servername, $username, $password, $database);

    if(!$conn){
        die("Connect failed: " .pg_connect_error());
    }

?>
