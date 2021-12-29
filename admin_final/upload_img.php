<?php
include('../shared_assets/conn.php');
$product_id = $_GET['id'];

function file_already_uploaded($file_name, $conn)
{
    $query = mysqli_query($conn, "SELECT * FROM tbl_product_images WHERE imageName = '$file_name'");
    $res = mysqli_num_rows($query);
    if($res>0) {
        return true;
    } else {
        return false;
    }
}

if(count($_FILES["file"]["name"]) > 0)
{
    sleep(3);
    for($count=0; $count<count($_FILES["file"]["name"]); $count++) {
        $file_name = $_FILES["file"]["name"][$count];
        $tmp_name = $_FILES["file"]['tmp_name'][$count];
        $file_array = explode(".", $file_name);
        $file_extension = end($file_array);
        $res = '';
        do {
            $res = file_already_uploaded($file_name, $conn);
            if($res) {
                $file_name = $file_array[0] . '-'. rand() . '.' . $file_extension;
            }
        } while($res==true);
        $folder = '../shared_assets/img/product/'.$product_id;
        if(!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $location = $folder.'/'.$file_name;

        if(move_uploaded_file($tmp_name, $location)) {
            $img_id = '';
            $id_count = mysqli_num_rows(mysqli_query($conn, "SELECT imageID FROM tbl_product_images"));
            for($i=0; $i <= $id_count; $i++) {
                $temp_id = 'img_'.$i;
                $id_check = mysqli_num_rows(mysqli_query($conn, "SELECT imageID FROM tbl_product_images WHERE imageID = '$temp_id'"));
                if($id_check==0) {
                    $img_id = $temp_id;
                    mysqli_query($conn, "INSERT INTO tbl_product_images(imageID, imageName, productID) VALUES ('$img_id', '$file_name', '$product_id')");
                }
            }
        }
    }
}

?>