<?php
include("../shared_assets/conn.php");

if(isset($_POST['imageID'])) {
    $file_path = 'assets/img/'.$_POST['imageName'];
    if(unlink($file_path)) {
        $query = "DELETE FROM tbl_product_images WHERE imageID = '".$_POST["imageID"]."'";
        mysqli_query($conn, $query);
    }
}
?>