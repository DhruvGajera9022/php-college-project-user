<?php

require_once 'database/config.php';
session_start();

// Redirect to login page if the user is not authenticated
// if (isset($_SESSION['id'])) {
//     header("Location: index.php");
//     exit;
// }

$id = $_SESSION['id'] ?? "";

// Retrieve user details from the database
if ($id) {
    $sqlSelect = $conn->prepare("SELECT * FROM tbluser WHERE id = ?");
    $sqlSelect->bind_param("i", $id);
    $sqlSelect->execute();
    $res = $sqlSelect->get_result();
    $data = $res->fetch_assoc();

    $image = $data['image'];
    $fname = $data['fname'];
    $email = $data['email'];
} else {
    $image = "avatar.png";
    $fname = "User";
}

if ($id) {
    // Retrieve the total number of products in the cart
    $sqlSelectCart = $conn->prepare("SELECT COUNT(*) as total FROM tblcart WHERE uid = '$id' ");
    $sqlSelectCart->execute();
    $res = $sqlSelectCart->get_result();
    $dataCart = $res->fetch_assoc();

    $totalProductsInCart = $dataCart['total'];
} else {
    $totalProductsInCart = 0;
}


?>