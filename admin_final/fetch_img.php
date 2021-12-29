<?php
include("../shared_assets/conn.php");

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_product_images 
        WHERE productID = '$id'
        ORDER BY imageID DESC";
$query = mysqli_query($conn, $sql);

mysqli_fetch_all($query, MYSQLI_ASSOC);
$num_rows = mysqli_num_rows($query);

$output = '
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
';

if($num_rows > 0) {
    $count = 0;
    foreach($query as $rows) {
        $count++;
        $output .= '
                <tr>
                    <td>'.$rows['imageID'].'</td>
                    <td><img src="../shared_assets/img/product/'.$rows['productID'].'/'.$rows['imageName'].'" class="img-thumbnail" width="100" height="100"></td>
                    <td>'.$rows['imageName'].'</td>
                    <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$rows['imageID'].'" data-name="'.$rows['imageName'].'"><i class="fas fa-trash"></i></button></td>
                </tr>
            </tbody>
        ';
    }
}
else {
    $output .= '
            <tr>
                <td colspan="6" align="center">No Data Found</td>
            </tr>
    ';
}

$output .= '
            </tbody>
            <tfoot>
            <tr>    
                <td><strong>ID</strong></td>
                <td><strong>Image</strong></td>
                <td><strong>Name</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>