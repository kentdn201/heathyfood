<?php
include("../shared_assets/conn.php");

if(isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM tbl_product_category
            WHERE categoryName LIKE '%".$search."%'
            ORDER BY categoryID DESC";
}
else {
    $sql = "SELECT * FROM tbl_product_category
            ORDER BY categoryID DESC";
}
$query = mysqli_query($conn, $sql);

mysqli_fetch_all($query, MYSQLI_ASSOC);
$num_rows = mysqli_num_rows($query);

$output = '
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
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
                    <td>'.$rows['categoryID'].'</td>
                    <td>'.$rows['categoryName'].'</td>
                    <td>'.$rows['categoryDesc'].'</td>
                    <td><a href="update_category.php?id='.$rows["categoryID"].'" class="btn btn-warning"><i class="fas fa-wrench"></i></a></td>
                    <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$rows["categoryID"].'"><i class="fas fa-trash"></i></button></td>
                </tr>
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
                <td><strong>Name</strong></td>
                <td><strong>Description</strong></td>
                <td><strong>Functions</strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
';

echo $output;
?>