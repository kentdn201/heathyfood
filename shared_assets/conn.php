<?php

    $conn = pg_connect("host=ec2-3-217-170-198.compute-1.amazonaws.com user=epfhbsltcnedlv dbname=d1a3vgbq801lf1 password=3a4dd46548f9a48d9a19bdc2675ac1f01888b0f6a559498566ed31ad7f3330e5");
    if(!$conn){
        die("Connect failed: " .pg_connect_error());
    }

?>
