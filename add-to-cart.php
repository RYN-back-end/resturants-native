<?php
require 'helper.php';
checkLogin();

if (!isset($_GET['id'])) {
    echo "<script> window.location = document.referrer;</script>";
    die();
}


$customer_id = $_SESSION['user']['Customer_id'];
$item_id = $_GET['id'] ?? 0;

$selectCountSql = "SELECT * FROM `cart` where `customer_id` = $customer_id And `item_id` = $item_id";
$selectCountResult = runQuery($selectCountSql);
$qty = $_GET['qty'] ?? 1;

if ($selectCountResult->num_rows > 0 && !isset($_GET['cart_id'])) {
    echo "<script> window.location = document.referrer+'&warning=The product has already been added to the cart';</script>";
    die();
}

if ($selectCountResult->num_rows > 0 && isset($_GET['cart_id'])) {
    $cartId = $selectCountResult->fetch_assoc()['id'];
    $updateSql = "UPDATE `cart` SET `qty`='{$qty}' WHERE `id`='{$_GET['cart_id']}'";
    runQuery($updateSql);
    echo "<script> window.location = document.referrer+'&success=The product has been Updated successfully';</script>";
    die();

}


$storeSql = "INSERT INTO `cart`( `customer_id`, `item_id`, `qty`) VALUES ('{$customer_id}','{$item_id}',$qty)";
runQuery($storeSql);
echo "<script> window.location = document.referrer+'&success=The product has been added successfully';</script>";
die();

?>
