<?php
    require_once("../shared_assets/conn.php");
    session_start();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $action = (isset($_GET['action'])) ? $_GET['action'] : 'add';

    $quantity = (isset($_GET['quantity'])) ? $_GET['quantity'] : 1;

    if($quantity <= 0){
        $quantity = 1;
    }

    if($quantity > 0){
        $sqlProduct = "SELECT * FROM tbl_product WHERE productID = '{$id}'";
        $queryProduct = mysqli_query($conn, $sqlProduct);
        $product = mysqli_fetch_assoc($queryProduct);

        if($quantity >= $product['inventoryQuantity']){
            $quantity = $product['inventoryQuantity'];
        }
    }

    $query = mysqli_query($conn, "SELECT * FROM tbl_product_images INNER JOIN tbl_product 
    ON tbl_product_images.productID = tbl_product.productID WHERE tbl_product.productID = '$id' LIMIT 1");

    if($query){  
        $product = mysqli_fetch_assoc($query);
    }

    $item = [
        'id'=> $product['productID'],
        'name'=> $product['productName'],
        'image'=> $product['imageName'],
        'price'=> $product['productPrice'],
        'quantity'=> $quantity
    ];

    //Add new product to cart
    if($action == 'add'){
        if($_SESSION['cart'][$id]){
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else{
            $_SESSION['cart'][$id] = $item;
        }
    }

    //Update cart
    if($action == 'update'){
        $_SESSION['cart'][$id]['quantity'] = $quantity;
        if($quantity >= $product['inventoryQuantity']){
            $quantity = $product['inventoryQuantity'];
        }
    }

    //Delete product in cart
    if($action == 'delete'){
        unset($_SESSION['cart'][$id]);
    }
  
    header('location:cart.php');
?>