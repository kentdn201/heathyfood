<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "crp_final";
    $conn = mysqli_connect($servername, $username, $password, $database);
    
    $output = '';
    $sql = "SELECT * FROM tbl_product WHERE productName LIKE '%".$_POST["search"]."%'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $output .='<h1>OK</h1>';
        while($row = mysqli_fetch_array($result)){
            $output .= '
            <div class="special-sec1">
                <a href="single.php?id='.$row['productID'].'">
                    <div class="col-xs-4 img-deals">
                        <img src="images/nut1.png" alt="" style="width:100%">
                    </div>
                    <div class="col-xs-8 img-deal1">
                        <h3>'.$row['productName'].'</h3>
                        <a href="single.php?id='.$row['productID'].'">'.$row['productPrice'].'</a>
                    </div>
                <div class="clearfix"></div>
                </a>
            </div>
            ';
        }
        echo $output;
    } else {
        echo 'Data Not Found';
    }

?>